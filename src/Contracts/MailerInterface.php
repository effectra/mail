<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

/**
 * Interface MailerInterface
 * @package Effectra\Mail\Contracts
 */
interface MailerInterface
{
    /**
     * Set the "from" email address.
     *
     * @param string|null $email The "from" email address.
     * @return MailerInterface
     */
    public function from(string|null $email = null): self;

    /**
     * Set the "to" email address(es).
     *
     * @param string|array $email The "to" email address(es).
     * @return MailerInterface
     */
    public function to(string|array  $email): self;

    /**
     * Add the "bcc" email address(es).
     *
     * @param string|array $users The "bcc" email address(es).
     * @return MailerInterface
     */
    public function bcc(string|array $users): self;

    /**
     * Add the "cc" email address(es).
     *
     * @param string|array $users The "cc" email address(es).
     * @return MailerInterface
     */
    public function cc(string|array $users): self;

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return MailerInterface
     */
    public function subject(string $subject): self;

    /**
     * Set the email content as plain text.
     *
     * @param string $msg The plain text email content.
     * @return MailerInterface
     */
    public function text(string $msg): self;

    /**
     * Set the email content as HTML.
     *
     * @param string $html The HTML email content.
     * @return MailerInterface
     */
    public function html(string $html): self;

    /**
     * Attach file(s) to the email.
     *
     * @param string|array $files The file(s) to attach.
     * @return MailerInterface
     */
    public function attachment(string|array $files): self;

    /**
     * Send the email.
     *
     * @param callable $callback The callback function to execute before sending the email.
     * @param mixed $args Additional arguments to pass to the callback function.
     * @return mixed
     */
    public function send(callable $callback, $args): mixed;
}
