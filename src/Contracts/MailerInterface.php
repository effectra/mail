<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

/**
 * Interface MailerInterface
 *
 * Represents a mailer interface for sending emails.
 */
interface MailerInterface
{
    /**
     * Send an email using the provided MailInterface instance.
     *
     * @param MailInterface $mail The MailInterface instance representing the email to be sent.
     *
     * @return mixed The result of the email sending operation, depending on the implementation.
     */
    public function send(MailInterface $mail);
}
