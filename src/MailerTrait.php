<?php

declare(strict_types=1);

namespace Effectra\Mail;

/**
 * Trait MailerTrait
 *
 * This trait provides functionality for sending emails.
 * 
 * @package Effectra\Mail
 */
trait MailerTrait
{
    /**
     * @var string $EMAIL_FROM The email sender address.
     */
    protected string $EMAIL_FROM;

    /**
     * @var string $EMAIL_TO The email recipient(s) address.
     */
    protected string $EMAIL_TO;

    /**
     * @var string $EMAIL_CC The email carbon copy (CC) recipient(s) address.
     */
    protected string $EMAIL_CC = '';

    /**
     * @var string $EMAIL_BCC The email blind carbon copy (BCC) recipient(s) address.
     */
    protected string $EMAIL_BCC = '';

    /**
     * @var string $EMAIL_TCC The email trashed carbon copy (TCC) recipient(s) address.
     */
    protected string $EMAIL_TCC = '';

    /**
     * @var string $EMAIL_SUBJECT The email subject.
     */
    protected string $EMAIL_SUBJECT;

    /**
     * @var string $EMAIL_TEXT The email plain text body.
     */
    protected string $EMAIL_TEXT;

    /**
     * @var string $EMAIL_HTML The email HTML body.
     */
    protected string $EMAIL_HTML;

    /**
     * @var string $REPLY_TO The email reply-to address.
     */
    protected string $REPLY_TO;

    /**
     * @var array $ATTACHMENTS The email attachments.
     */
    protected array $ATTACHMENTS = [];

    /**
     * Sends the email using a callback function.
     *
     * @param callable $callback The callback function responsible for sending the email.
     * @param mixed    $args     The arguments to be passed to the callback function.
     * @return mixed The result of the callback function.
     */
    public function send(callable $callback, $args): mixed
    {
        return call_user_func_array($callback, [$this, $args]);
    }

    /**
     * Get the email recipient(s) address.
     *
     * @return string The email recipient(s) address.
     */
    public function getTo(): string
    {
        return $this->EMAIL_TO;
    }

    /**
     * Get the email blind carbon copy (BCC) recipient(s) address.
     *
     * @return string The email BCC recipient(s) address.
     */
    public function getBcc(): string
    {
        return $this->EMAIL_BCC;
    }

    /**
     * Get the email carbon copy (CC) recipient(s) address.
     *
     * @return string The email CC recipient(s) address.
     */
    public function getCc(): string
    {
        return $this->EMAIL_CC;
    }

    /**
     * Get the email sender address.
     *
     * @return string The email sender address.
     */
    public function getFrom(): string
    {
        return $this->EMAIL_FROM;
    }

    /**
     * Get the email subject.
     *
     * @return string The email subject.
     */
    public function getSubject(): string
    {
        return $this->EMAIL_SUBJECT;
    }

    /**
     * Get the email message (plain text and HTML).
     *
     * @return array An array containing the email plain text and HTML body.
     */
    public function getMsg(): array
    {
        return [$this->EMAIL_TEXT, $this->EMAIL_HTML];
    }

    /**
     * Get the email plain text body.
     *
     * @return string The email plain text body.
     */
    public function getText(): string
    {
        return $this->EMAIL_TEXT;
    }

    /**
     * Get the email HTML body.
     *
     * @return string The email HTML body.
     */
    public function getHtml(): string
    {
        return $this->EMAIL_HTML;
    }

    /**
     * Get the email reply-to address.
     *
     * @return string The email reply-to address.
     */
    public function getReplyTo(): string
    {
        return $this->REPLY_TO;
    }

    /**
     * Set the email recipient(s) address.
     *
     * @param string|array $emails The email recipient(s) address.
     * @return self
     */
    public function to(string|array $emails): self
    {
        $clone = clone $this;
        if (is_array($emails)) {
            $emails = implode(',', $emails);
        }
        $clone->EMAIL_TO = $emails;
        return $clone;
    }

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|array $users The email BCC recipient(s) address.
     * @return self
     */
    public function bcc(string|array $users): self
    {
        $clone = clone $this;
        if (is_array($users)) {
            $users = implode(',', $users);
        }
        $clone->EMAIL_BCC = $users;
        return $clone;
    }

    /**
     * Set the email trashed carbon copy (TCC) recipient(s) address.
     *
     * @param string|array $users The email TCC recipient(s) address.
     * @return self
     */
    public function tcc(string|array $users): self
    {
        $clone = clone $this;
        if (is_array($users)) {
            $users = implode(',', $users);
        }
        $clone->EMAIL_TCC = $users;
        return $clone;
    }

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|array $users The email CC recipient(s) address.
     * @return self
     */
    public function cc(string|array $users): self
    {
        $clone = clone $this;
        if (is_array($users)) {
            $users = implode(',', $users);
        }
        $clone->EMAIL_CC = $users;
        return $clone;
    }

    /**
     * Set the email sender address.
     *
     * @param string|null $email The email sender address. If null, the current sender address will be used.
     * @return self
     */
    public function from(?string $email = null): self
    {
        $clone = clone $this;
        $clone->EMAIL_FROM = $email ?? $clone->EMAIL_FROM;
        return $clone;
    }

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return self
     */
    public function subject(string $subject = ''): self
    {
        $clone = clone $this;
        $clone->EMAIL_SUBJECT = $subject;
        return $clone;
    }

    /**
     * Set the email message (plain text and HTML).
     *
     * @param string $msg The email message.
     * @return self
     */
    public function msg(string $msg = ''): self
    {
        $clone = clone $this;
        $clone->EMAIL_TEXT = $msg;
        $clone->EMAIL_HTML = sprintf('<p>%s</p>', $msg);
        return $clone;
    }

    /**
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
     * @return self
     */
    public function text(string $text = ''): self
    {
        $clone = clone $this;
        $clone->EMAIL_TEXT = $text;
        return $clone;
    }

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
     * @return self
     */
    public function html(string $html): self
    {
        $clone = clone $this;
        $clone->EMAIL_HTML = $html;
        return $clone;
    }

    /**
     * Get the email attachments.
     *
     * @return array The email attachments.
     */
    public function getAttachments(): array
    {
        return $this->ATTACHMENTS;
    }

    /**
     * Get the specific email attachment.
     *
     * @param string $file The file name of the attachment.
     * @return string The attachment file path.
     */
    public function getAttachment(string $file): string
    {
        return $this->ATTACHMENTS[$file];
    }

    /**
     * Set the email attachment(s).
     *
     * @param string|array $files The file name(s) or file path(s) of the attachment(s).
     * @return self
     */
    public function attachment(string|array $files): self
    {
        $clone = clone $this;
        if (is_string($files)) {
            $clone->ATTACHMENTS[] = $files;
        }
        if (is_array($files)) {
            $clone->ATTACHMENTS = array_merge($clone->ATTACHMENTS, $files);
        }
        return $clone;
    }

    /**
     * Set the email reply-to address.
     *
     * @param string $email The email reply-to address.
     * @return self
     */
    public function replyTo(string $email): self
    {
        $clone = clone $this;
        $clone->REPLY_TO = $email;
        return $clone;
    }

    /**
     * Validate if an email address is valid.
     *
     * @param string $email The email address to validate.
     * @return bool True if the email is valid, false otherwise.
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Generate the HTML template for the email.
     *
     * @param string|false $html The custom HTML template or false to use the default template.
     * @return string The generated HTML template.
     */
    public function generateHtmlTemplate(string|false $html = false): string
    {
        if ($html) {
            return $html;
        }

        return '
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>' . $this->getSubject() . '</title>
            </head>
            <body>
                ' . $this->getHtml() . '
            </body>
        </html>';
    }

    /**
     * Convert the email object to its string representation.
     *
     * @return string The email object as a string.
     */
    public function __toString(): string
    {
        $mail = 'MAIL';
        $mail .= "\n FROM: " . $this->getFrom();
        $mail .= "\n TO: " . $this->getTo();
        $mail .= "\n CC: " . $this->getCc();
        $mail .= "\n BCC: " . $this->getBcc();
        $mail .= "\n SUBJECT: " . $this->getSubject();
        $mail .= "\n MESSAGE: " . $this->getText();
        $mail .= "\n ATTACHMENTS: " . implode(', ', $this->getAttachments());
        return $mail;
    }
}
