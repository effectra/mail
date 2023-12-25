<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Config\ConfigDriver;
use Effectra\DataOptimizer\Contracts\DataCollectionInterface;
use Effectra\DataOptimizer\DataCollection;
use Effectra\Mail\Build\MailBuilder;
use Effectra\Mail\Contracts\MailInterface;
use Effectra\Mail\Exception\ConnectException;


/**
 * Inbox Class
 *
 * The Inbox class is responsible for connecting to a mail server, retrieving emails based on specified criteria,
 * and providing a collection of mail objects. It extends the ConfigDriver class and implements functionality
 * for managing IMAP inboxes.
 *
 * @package Effectra\Mail
 */
class Inbox extends ConfigDriver
{
    private  $imap = null;

    /** @var string */
    private string $criteria = 'ALL';

    /** @var array */
    private array $criteriaProvided = [
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

    public function getConnection()
    {
        return $this->imap;
    }

    public function closeConnection()
    {
        imap_close($this->imap);
        $this->imap = null;
    }

    /**
     * Set the search criteria.
     *
     * @param string $criteria
     * @throws \Exception
     */
    public function setCriteria(string $criteria)
    {
        if (!in_array($criteria, $this->criteriaProvided)) {
            throw new \InvalidArgumentException('Invalid criteria');
        }
        $this->criteria = $criteria;
    }

    /**
     * Get the current search criteria.
     *
     * @return string
     */
    public function getCriteria(): string
    {
        return  $this->criteria;
    }

    /**
     * Connect to the mail server.
     *
     * @throws ConnectException
     */
    public function connect()
    {
        try {
            $this->imap =  imap_open($this->path($this->host, $this->port, $this->driver), $this->username, $this->password);
        } catch (\Exception $e) {
            throw new ConnectException('Failed to connect to the mail server', 1, $e);
        }
    }

    /**
     * Build the mailbox path.
     *
     * @param string $host
     * @param int $port
     * @param string $driver
     * @return string
     */
    private function path(string $host, int $port, string $driver = 'IMAP'): string
    {
        return "{" . $host . ":" . $port . "/$driver/ssl}INBOX";
    }

    /**
     * Get a collection of emails based on the search criteria.
     *
     * @return DataCollectionInterface|bool
     */
    public function getMails(): DataCollectionInterface
    {
        $result = [];
        $emails = imap_search($this->imap, $this->criteria);

        if (!$emails) {
            return new DataCollection([]);
        }

        foreach ($emails as $email) {
            $result[] = $this->getMail($email);
        }

        return new DataCollection($result);
    }

    /**
     * Get an email by its unique identifier.
     *
     * @param $email
     * @return MailInterface
     */
    public function getMail($email): MailInterface
    {

        return (new MailBuilder($this->imap, $email))->build();
    }
}
