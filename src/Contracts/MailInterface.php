<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

use Effectra\Mail\Components\Address;
use Effectra\Mail\Components\Attachment;

/**
 * Interface MailInterface
 *
 * Represents a mail interface providing methods to work with email details.
 *
 * @package Effectra\Mail\Contracts
 */
interface MailInterface extends \JsonSerializable, MailSimpleInterface
{
    /**
     * Get the email sender address.
     *
     * @return Address The email sender address.
     */
    public function getFrom(): Address;

    /**
     * Get the email recipient(s) address.
     *
     * @return Address[] The email recipient(s) address.
     */
    public function getTo(): array;

    /**
     * Get the email carbon copy (CC) recipient(s) address.
     *
     * @return Address|null The email CC recipient(s) address.
     */
    public function getCc(): ?Address;

    /**
     * Get the email blind carbon copy (BCC) recipient(s) address.
     *
     * @return Address|null The email BCC recipient(s) address.
     */
    public function getBcc(): ?Address;

    /**
     * Get the email subject.
     *
     * @return string The email subject.
     */
    public function getSubject(): string;

    /**
     * Get the email plain text body.
     *
     * @return string The email plain text body.
     */
    public function getText(): string;

    /**
     * Get the email HTML body.
     *
     * @return string The email HTML body.
     */
    public function getHtml(): string;

    /**
     * Get the email reply-to address.
     *
     * @return null|Address The email reply-to address.
     */
    public function getReplyTo(): ?Address;

    /**
     * Get the email attachments.
     *
     * @return Attachment[] The email attachments.
     */
    public function getAttachments(): array;

    /**
     * Get the email message (plain text and HTML).
     *
     * @return array An array containing the email plain text and HTML body.
     */
    public function getMsg(): array;

     /**
     * Get the specific email attachment.
     *
     * @param string $file The file name of the attachment.
     * @return ?Attachment The attachment object or null if not exists.
     */
    public function getAttachment(string $file): ?Attachment;

    /**
     * Set the email sender address.
     *
     * @param string|Address $email The email sender address. If null, the current sender address will be used.
     * @return self
     */
    public function setFrom(string|Address $email): self;

    /**
     * Set the email recipient(s) address.
     *
     * @param Address[] $emails The email recipient(s) address.
     * @return self
     */
    public function setTo(array $emails): self;

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|Address $emails The email CC recipient(s) address.
     * @return self
     */
    public function setCc(string|Address $emails): self;

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|Address $emails The email BCC recipient(s) address.
     * @return self
     */
    public function setBcc(string|Address $emails): self;

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return self
     */
    public function setSubject(string $subject = ''): self;

    /**
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
     * @return self
     */
    public function setText(string $text = ''): self;

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
     * @return self
     */
    public function setHtml(string $html): self;

    /**
     * Set the email reply-to address.
     *
     * @param string|Address $email The email reply-to address.
     * @return self
     */
    public function setReplyTo(string|Address $email): self;

    /**
     * Set the email attachment(s).
     *
     * @param Attachment[] $files The file name(s) or file path(s) of the attachment(s)  or array of Attachment object(s).
     * @return self
     */
    public function setAttachments(array $files): self;

    /**
     * Set the email attachment.
     *
     * @param Attachment $file The file name with file path of the attachment(s) or Attachment object.
     * @return self
     */
    public function addAttachment(Attachment|string $file): self;

    /**
     * Check if the specific email attachment exists.
     *
     * @param string $file The file name of the attachment.
     * @return bool True if the attachment exists, false otherwise.
     */
    public function hasAttachment(string $file): bool;

     /**
     * add the email recipient(s) address.
     *
     * @param Address $emails The email recipient(s) address.
     * @return self
     */
    public function addTo(Address $email): self;

    /**
     * Convert the email object to its string representation.
     *
     * @return string The email object as a string.
     */
    public function __toString(): string;

    /**
     * Convert the email object to an array for serialization.
     *
     * @return array An array representation of the email object.
     */
    public function jsonSerialize(): array;
}
