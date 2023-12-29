<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Mail\Components\Address;
use Effectra\Mail\Components\Attachment;

trait MailSimpleTrait
{

    /**
     * Set the email sender address.
     *
     * @param string|Address $email The email sender address. If null, the current sender address will be used.
     * @return self
     */
    public function from(string|Address $email): self
    {
        return $this->setFrom($email);
    }

    /**
     * add the email recipient(s) address.
     *
     * @param string|Address $emails The email recipient(s) address.
     * @return self
     */
    public function to(string|Address $email): self
    {
        return $this->addTo($email);
    }

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|Address $email The email CC recipient(s) address.
     * @return self
     */
    public function cc(string|Address $email): self
    {
        return $this->setCc($email);
    }

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|Address $email The email BCC recipient(s) address.
     * @return self
     */
    public function bcc(string|Address $email): self
    {
        return $this->setBcc($email);
    }

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return self
     */
    public function subject(string $subject = ''): self
    {
        return $this->setSubject($subject);
    }

    /** 
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
     * @return self
     */
    public function text(string $text = ''): self
    {
        return $this->setText($text);
    }

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
     * @return self
     */
    public function html(string $html): self
    {
        return $this->setHtml($html);
    }

    /**
     * Set the email reply-to address.
     *
     * @param string|Address $email The email reply-to address.
     * @return self
     */
    public function replyTo(string $email): self
    {
        return $this->setReplyTo($email);
    }

    /**
     * Set the email attachment(s).
     *
     * @param Attachment[] $files The file name(s) or file path(s) of the attachment(s).
     * @return self
     */
    public function attachments(array $files): self
    {

        return $this->setAttachments($files);
    }

    /**
     * Set the email attachment.
     *
     * @param Attachment|string $file The file name with file path of the attachment(s) or Attachment object.
     * @return self
     */
    public function attachment(Attachment|string $file): self
    {
        return $this->setAttachment($file);
    }

    /**
     * set the email message (plain text and HTML).
     * @param string $text
     * @param string $template used for set HTML template by `sprintf` function,the html content must using `%s` to set $text correctly in HTML body 
     * @return self
     */
    public function msg(string $text, string $template = '<p>%s</p>'): self
    {
        return $this->setMsg($text, $template);
    }
}
