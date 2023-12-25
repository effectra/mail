<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Mail\Components\Address;

trait MailCloneTrait
{
    /**
     * Set the email sender address.
     *
     * @param string|Address $email The email sender address. If null, the current sender address will be used.
     * @return self
     */
    public function withFrom(string|Address $email): self
    {
        $clone = clone $this;
        $clone->setFrom($email);
        return $clone;
    }

    /**
     * add the email recipient(s) address.
     *
     * @param string|Address $emails The email recipient(s) address.
     * @return self
     */
    public function withTo(string|Address $email): self
    {
        $clone = clone $this;
        $clone->setTo($email);
        return $clone;
    }

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|Address $email The email CC recipient(s) address.
     * @return self
     */
    public function withCc(string|Address $email): self
    {
        $clone = clone $this;
        $clone->setCc($email);
        return $clone;
    }

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|Address $email The email BCC recipient(s) address.
     * @return self
     */
    public function withBcc(string|Address $email): self
    {
        $clone = clone $this;
        $clone->setBcc($email);
        return $clone;
    }

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return self
     */
    public function withSubject(string $subject = ''): self
    {
        $clone = clone $this;
        $clone->setSubject($subject);
        return $clone;
    }

    /** 
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
     * @return self
     */
    public function withText(string $text = ''): self
    {
        $clone = clone $this;
        $clone->setText($text);
        return $clone;
    }

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
     * @return self
     */
    public function withHtml(string $html): self
    {
        $clone = clone $this;
        $clone->setHtml($html);
        return $clone;
    }

    /**
     * Set the email reply-to address.
     *
     * @param string $email The email reply-to address.
     * @return self
     */
    public function withReplyTo(string $email): self
    {
        $clone = clone $this;
        $clone->setReplyTo($email);
        return $clone;
    }

    /**
     * Set the email attachment(s).
     *
     * @param string|array $files The file name(s) or file path(s) of the attachment(s).
     * @return self
     */
    public function withAttachments(array $files): self
    {
        $clone = clone $this;
        $clone->setAttachments($files);
        return $clone;
    }

    /**
     * Set the email attachment.
     *
     * @param string $file The file name or file path of the attachment(s).
     * @return self
     */
    public function withAttachment(string $file): self
    {
        $clone = clone $this;
        $clone->setAttachment($file);
        return $clone;
    }

    /**
     * set the email message (plain text and HTML).
     * @param string $text
     * @param string $template used for set HTML template by `sprintf` function,the html content must using `%s` to set $text correctly in HTML body 
     * @return self
     */
    public function withMsgmsg(string $text, string $template = '<p>%s</p>'): self
    {
        $clone = clone $this;
        $clone->setMsg($text, $template);
        return $clone;
    }
}
