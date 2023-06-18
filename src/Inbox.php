<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Config\ConfigDriver;
use Effectra\Mail\Exception\ConnectException;
use Exception;

/**
 * class Inbox
 * 
 * This class provides functionality for reading emails.
 * 
 * @package Effectra\Mail
 */
class Inbox extends ConfigDriver
{
    /**
     * mail flag by default
     * @var string
     */
    protected string $FLAG = 'ALL';

    /**
     * mail flags
     * @var array
     */
    private array $flags = [
        'ALL', //return all messages matching the rest of the criteria
        'ANSWERED', //match messages with the \\ANSWERED flag set
        'BCC', // match messages with "string" in the Bcc: field
        'BEFORE', //match messages with Date: before "date"
        'BODY', //match messages with "string" in the body of the message
        'CC', // match messages with "string" in the Cc: field
        'DELETED', //match deleted messages
        'FLAGGED', //match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
        'FROM', //match messages with "string" in the From: field
        'KEYWORD', //match messages with "string" as a keyword
        'NEW', //match new messages
        'OLD', //match old messages
        'ON', //match messages with Date: matching "date"
        'RECENT', //match messages with the \\RECENT flag set
        'SEEN', //match messages that have been read (the \\SEEN flag is set)
        'SINCE', //match messages with Date: after "date"
        'SUBJECT', //match messages with "string" in the Subject:
        'TEXT', //match messages with text "string"
        'TO', //match messages with "string" in the To:
        'UNANSWERED', //match messages that have not been answered
        'UNDELETED', //match messages that are not deleted
        'UNFLAGGED', //match messages that are not flagged
        'UNKEYWORD', //match messages that do not have the keyword "string"
        'UNSEEN', //match messages which have not been read yet
    ];

    /**
     * Connect to the mail server and return the IMAP connection.
     *
     * @throws Exception If unable to connect to the mail server.
     * @return \IMAP\Connection|bool The IMAP connection or false on failure.
     */
    private function connect()
    {
        $imapPath = "{" . $this->host . ":" . $this->port . "/$this->driver/ssl}INBOX";

        $stream = imap_open($imapPath, $this->username, $this->password);

        if (!$stream) {
            throw new ConnectException('Cannot connect to mailer: ' . imap_last_error());
        }

        return $stream;
    }

    /**
     * Set the type of emails to be returned.
     *
     * @param string $flag The flag representing the type of emails.
     * @throws Exception If the provided flag is not valid.
     * @return Inbox Returns the Inbox object.
     */
    public function setFlag(string $flag = 'ALL'): self
    {
        if (!in_array($flag, $this->flags)) {
            throw new Exception('Invalid flag');
        }

        $this->FLAG = $flag;

        return $this;
    }

    /**
     * Retrieve emails based on the set criteria.
     *
     * @return array An array of emails matching the set criteria.
     */
    public function get(): array
    {
        $inbox = $this->connect();
        $emails = imap_search($inbox, $this->FLAG);

        if ($emails == false) {
            return [];
        }

        $result = [];

        foreach ($emails as $mail) {
            $headerInfo = imap_headerinfo($inbox, $mail);

            $output = [
                'subject' => $headerInfo->subject,
                'to' => $headerInfo->toaddress,
                'date' => $headerInfo->date,
                'from' => $this->parseEmail($headerInfo->fromaddress),
                'reply_to' => $this->parseEmail($headerInfo->reply_toaddress),
                'flag' =>  $this->FLAG,
                'body' =>  [],
            ];

            $emailStructure = imap_fetchstructure($inbox, $mail);

            if (!isset($emailStructure->parts)) {
                $output['body'] = imap_body($inbox, $mail, FT_PEEK);
            } else {
                $output['body'] = [];
                $this->extractAttachments($inbox, $mail, $emailStructure, $output['body']);
            }

            $result[] = $output;
        }

        imap_expunge($inbox);
        imap_close($inbox);

        return $result;
    }

    /**
     * Extract attachments from the email structure recursively.
     *
     * @param resource $inbox The IMAP stream resource.
     * @param int $mail The message ID.
     * @param object $structure The email structure.
     * @param array $attachments Reference to the attachments array.
     * @param string $partNumber The current part number (for nested parts).
     */
    private function extractAttachments($inbox, $mail, $structure, &$attachments, $partNumber = '')
    {
        if (isset($structure->parts) && is_array($structure->parts)) {
            foreach ($structure->parts as $index => $subStructure) {
                $newPartNumber = $partNumber . ($index + 1);

                if ($subStructure->type === 0) { // Part is an attachment
                    $attachment = $this->fetchAttachment($inbox, $mail, $newPartNumber);
                    if ($attachment) {
                        $attachments[] = $attachment;
                    }
                } elseif ($subStructure->type === 1) { // Part is an embedded message
                    $this->extractAttachments($inbox, $mail, $subStructure, $attachments, $newPartNumber . '.');
                } elseif ($subStructure->type === 2) { // Part is an inline image
                    $attachment = $this->fetchAttachment($inbox, $mail, $newPartNumber);
                    if ($attachment) {
                        $attachments[] = $attachment;
                    }
                } elseif ($subStructure->type === 3) { // Part is a nested multipart
                    $this->extractAttachments($inbox, $mail, $subStructure, $attachments, $newPartNumber . '.');
                }
            }
        }
    }

    /**
     * Fetch an attachment from the email.
     *
     * @param  $inbox The IMAP stream resource.
     * @param int $mail The message ID.
     * @param string $partNumber The part number of the attachment.
     * @return array|false An array containing the attachment information, or false on failure.
     */
    private function fetchAttachment($inbox, $mail, $partNumber)
    {
        if (!is_numeric($partNumber)) {
            return false;
        }

        $attachment = [];
        $attachmentData = imap_fetchbody($inbox, $mail, $partNumber);

        if ($attachmentData) {
            $structure = imap_fetchstructure($inbox, $mail);

            if (isset($structure->parts[$partNumber - 1]->dparameters) && is_array($structure->parts[$partNumber - 1]->dparameters)) {
                foreach ($structure->parts[$partNumber - 1]->dparameters as $dparam) {
                    if (strtolower($dparam->attribute) === 'filename') {
                        $attachment['filename'] = $dparam->value;
                        break;
                    }
                }
            } elseif (isset($structure->parts[$partNumber - 1]->parameters) && is_array($structure->parts[$partNumber - 1]->parameters)) {
                foreach ($structure->parts[$partNumber - 1]->parameters as $param) {
                    if (strtolower($param->attribute) === 'name') {
                        $attachment['filename'] = $param->value;
                        break;
                    }
                }
            }

            $attachment['data'] = $attachmentData;

            return $attachment;
        }

        return false;
    }

    /**
     * Parse the name and email address from an email string.
     *
     * @param string $email The email string to parse.
     * @return array|false An array containing the 'name' and 'email' keys, or false on failure.
     */
    private function parseEmail($email)
    {
        $addressList = imap_rfc822_parse_adrlist($email, '');

        if ($addressList) {
            $address = $addressList[0];
            $name = isset($address->personal) ? $address->personal : '';
            $email = $address->mailbox . '@' . $address->host;

            return array(
                'name' => $name,
                'email' => $email
            );
        } else {
            return false;
        }
    }

    /**
     * Get the flag information from the IMAP header.
     *
     * @param  $imapStream The IMAP stream.
     * @param int $msgNumber The message number.
     * @return array|false An array containing the flags, or false on failure.
     */
    private function getImapFlags($imapStream, $msgNumber)
    {
        $header = imap_headerinfo($imapStream, $msgNumber);

        if ($header) {
            $flags = array();
            if ($header->Unseen) {
                $flags[] = 'Unseen';
            }
            if ($header->Flagged) {
                $flags[] = 'Flagged';
            }
            if ($header->Answered) {
                $flags[] = 'Answered';
            }
            if ($header->Deleted) {
                $flags[] = 'Deleted';
            }
            if ($header->Draft) {
                $flags[] = 'Draft';
            }
            if ($header->Recent) {
                $flags[] = 'Recent';
            }

            return $flags;
        } else {
            return false;
        }
    }
}
