<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

use Effectra\Mail\Components\Address;
use Effectra\Mail\Components\Attachment;

/**
 * Interface MailSimpleInterface
 *
 * Represents a simplified mail interface providing methods for setting basic email details.
 */
interface MailSimpleInterface
{
     /**
     * Set the email sender address.
     *
     * @param string|Address $email The email sender address. If null, the current sender address will be used.
    */
     public function from(string|Address $email): self;
    

    /**
     * add the email recipient(s) address.
     *
     * @param string|Address $emails The email recipient(s) address.
    */
     public function to(string|Address $email): self;
    

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|Address $email The email CC recipient(s) address.
    */
     public function cc(string|Address $email): self;
    

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|Address $email The email BCC recipient(s) address.
    */
     public function bcc(string|Address $email): self;
    

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
    */
     public function subject(string $subject = ''): self;
    

    /** 
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
    */
     public function text(string $text = ''): self;
    

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
    */
     public function html(string $html): self;
    

    /**
     * Set the email reply-to address.
     *
     * @param string|Address $email The email reply-to address.
    */
     public function replyTo(string $email): self;
    

    /**
     * Set the email attachment(s).
     *
     * @param Attachment[] $files The file name(s) or file path(s) of the attachment(s).
    */
     public function attachments(array $files): self;
    


    /**
     * Set the email attachment.
     *
     * @param Attachment|string $file The file name with file path of the attachment(s) or Attachment object.
    */
     public function attachment(Attachment|string $file): self;
    

    /**
     * set the email message (plain text and HTML).
     * @param string $text
     * @param string $template used for set HTML template by `sprintf` function,the html content must using `%s` to set $text correctly in HTML body 
    */
     public function msg(string $text, string $template = '<p>%s</p>'): self;
    
}
