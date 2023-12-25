<?php

declare(strict_types=1);

namespace Effectra\Mail;

use IMAP\Connection;

class MailManager
{

    public function __construct(
        private readonly Connection $mailbox,
        private readonly string $emailId
    ) {
    }

    public function markAsSeen()
    {
        imap_setflag_full($this->mailbox, $this->emailId, "\\Seen");
    }

    public function markAsUnseen()
    {
        // Mark email as unseen
        imap_clearflag_full($this->mailbox, $this->emailId, "\\UnSeen");
    }

    public function flag()
    {
        // Flag email
        imap_setflag_full($this->mailbox, $this->emailId, "\\Flag");
    }

    public function unFlag()
    {
        imap_clearflag_full($this->mailbox, $this->emailId, "\\UnFlag");
    }

    public function delete()
    {
        imap_delete($this->mailbox, $this->emailId);
    }

    public function expungeDeletedEmails()
    {
        imap_expunge($this->mailbox);
    }

}
