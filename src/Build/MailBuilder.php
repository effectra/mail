<?php

declare(strict_types=1);

namespace Effectra\Mail\Build;

use Effectra\Mail\Components\Attachment;
use Effectra\Mail\Contracts\FullMailInterface;
use Effectra\Mail\Factory\FullMailFactory;
use IMAP\Connection;

/**
 * Class MailBuilder
 *
 * The MailBuilder class is responsible for building a FullMailInterface object by extracting information
 * from an IMAP connection and a specific message number. It handles the creation of a FullMail object
 * with details such as sender, recipient, subject, attachments, and more.
 *
 */
class MailBuilder
{

    /**
     * MailBuilder constructor.
     *
     * @param Connection $imapConnection The IMAP connection object.
     * @param int $messageNumber The number of the message to build.
     */
    public function __construct(
        private readonly Connection $imapConnection,
        private readonly int $messageNumber
    ) {
    }

    /**
     * Build a FullMailInterface object with details extracted from the IMAP connection.
     *
     * @return FullMailInterface
     */
    public function build(): FullMailInterface
    {
        $headerInfo = imap_headerinfo($this->imapConnection, $this->messageNumber);

        $mail = (new FullMailFactory())->createMail();

        $mail->setFrom($headerInfo->fromaddress);

        $mail->setTo($this->setAddresses($headerInfo->toaddress));

        if (isset($headerInfo->ccaddress)) {
            $mail->setCc($headerInfo->ccaddress);
        }
        if (isset($headerInfo->bccaddress)) {
            $mail->setBcc($headerInfo->bccaddress);
        }
        $mail->setSubject($headerInfo->subject);

        $mail->setText($this->getTextBody($this->imapConnection, $this->messageNumber));

        $mail->setHtml($this->getHtmlBody($this->imapConnection, $this->messageNumber));

        if (isset($headerInfo->reply_toaddress)) {
            $mail->setReplyTo($headerInfo->reply_toaddress);
        }

        $mail->setAttachments($this->getAttachments());

        $mail->setSender($headerInfo->senderaddress);
        $mail->setReturnPath($headerInfo->return_path ?? '');
        $mail->setDate($this->getDatetime($headerInfo->date));
        $mail->setMessageId($headerInfo->message_id);
        $mail->setNewsGroups($headerInfo->newsgroups  ?? null);
        $mail->setFollowupTo($headerInfo->followup_to ?? null);
        $mail->setReferences($headerInfo->references ?? null);
        $mail->setRecent($this->setBoolean($headerInfo->Recent));
        $mail->setUnseen($this->setBoolean($headerInfo->Unseen));
        $mail->setFlagged($this->setBoolean($headerInfo->Flagged));
        $mail->setAnswered($this->setBoolean($headerInfo->Answered));
        $mail->setDeleted($this->setBoolean($headerInfo->Deleted));
        $mail->setDraft($this->setBoolean($headerInfo->Draft));
        $mail->setMsgNumber((int) $headerInfo->Msgno ?? 0);
        $mail->setMailDate($this->getDatetime($headerInfo->MailDate));
        $mail->setSize((int) $headerInfo->Size ?? 0);
        $mail->setUnixDate($this->getDatetime($headerInfo->udate));
        $mail->setFetchFrom($headerInfo->from);

        return $mail;
    }

    /**
     * Get an array of attachments represented as Attachment objects.
     *
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        $connection =  $this->imapConnection;
        $structure = imap_fetchstructure($connection, $this->messageNumber);

        $attachments = array();
        if (isset($structure->parts) && count($structure->parts)) {
            foreach ($structure->parts as $part) {
                if (isset($part->disposition) && $part->disposition === 'ATTACHMENT') {
                    $sec = $part->ifid + 1;
                    $data = imap_fetchbody($this->imapConnection, $this->messageNumber, "$sec");
                    $encodingData = match ($part->encoding) {
                        3 => base64_decode($data),
                        4 => quoted_printable_decode($data),
                    };

                    $attachments[] = new Attachment(
                        $part->dparameters[0]->value,
                        $part->parameters[0]->value,
                        $part->subtype,
                        $part->id,
                        $encodingData
                    );
                }
            }
        }

        return $attachments;
    }

    /**
     * Get the text body of the email.
     *
     * @return false|string
     */
    public function getTextBody()
    {
        return $this->getPart($this->imapConnection, $this->messageNumber, "TEXT/PLAIN");
    }

    /**
     * Get the HTML body of the email.
     *
     * @return false|string
     */
    public function getHtmlBody()
    {
        return $this->getPart($this->imapConnection, $this->messageNumber, "TEXT/HTML");
    }

    /**
     * Get a specific part of the email based on MIME type, structure, and part number.
     *
     * @param resource|Connection $imap The IMAP resource connection.
     * @param int $uid The unique identifier of the email.
     * @param string $mimetype The MIME type to match.
     * @param object|false $structure The structure of the email, if available.
     * @param string|false $partNumber The part number of the email, if available.
     *
     * @return false|string The content of the specified part or false if not found.
     */
    private function getPart($imap, $uid, $mimetype, $structure = false, $partNumber = false)
    {
        if (!$structure) {
            $structure = imap_fetchstructure($imap, $uid, FT_UID);
        }
        if ($structure) {
            if ($mimetype == $this->getMimeType($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
                $text = imap_fetchbody($imap, $uid, (string) $partNumber, FT_UID);
                switch ($structure->encoding) {
                    case 3:
                        return imap_base64($text);
                    case 4:
                        return imap_qprint($text);
                    default:
                        return $text;
                }
            }

            // multipart
            if ($structure->type == 1) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = "";
                    if ($partNumber) {
                        $prefix = $partNumber . ".";
                    }
                    $data = $this->getPart($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Get the MIME type of a given structure.
     *
     * @param object $structure
     * @return string
     */
    private function getMimeType($structure)
    {
        $primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

        if ($structure->subtype) {
            return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }

    /**
     * Convert a date string or timestamp to a DateTimeImmutable object.
     *
     * @param mixed $date
     * @return \DateTimeImmutable
     */
    private function getDatetime($date)
    {
        return is_numeric($date) ? new \DateTimeImmutable('@' . $date) : new \DateTimeImmutable($date);
    }

    /**
     * Set a boolean value based on a cleaned and trimmed input.
     *
     * @param mixed $value
     * @return bool
     */
    private function setBoolean($value): bool
    {
        $cleanValue = trim($value);
        return !empty($cleanValue) ? true : false;
    }

    /**
     * Set an array of addresses from a comma-separated string.
     *
     * @param string $address
     * @return array
     */
    public function setAddresses(string $address): array
    {
        return explode(', ', $address);
    }
}
