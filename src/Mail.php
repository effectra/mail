<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\DataOptimizer\DataValidator;
use Effectra\Mail\Components\Address;
use Effectra\Mail\Components\Attachment;
use Effectra\Mail\Contracts\MailInterface;

class Mail implements MailInterface
{
    use MailSimpleTrait, MailCloneTrait;

    /**
     * @var Address $emailFrom The email sender address.
     */
    protected Address $from;

    /**
     * @var Address[] $to The email recipient(s) address.
     */
    protected array $to = [];

    /**
     * @var Address $cc The email carbon copy (CC) recipient(s) address.
     */
    protected ?Address $cc = null;

    /**
     * @var Address $bcc The email blind carbon copy (BCC) recipient(s) address.
     */
    protected ?Address $bcc = null;

    /**
     * @var string $subject The email subject.
     */
    protected string $subject;

    /**
     * @var string $text The email plain text body.
     */
    protected string $text;

    /**
     * @var string $html The email HTML body.
     */
    protected string $html;

    /**
     * @var null|Address $replyTo The email reply-to address.
     */
    protected ?Address $replyTo = null;

    /**
     * @var Attachment[] $attachments The email attachments.
     */
    protected array $attachments = [];

    /**
     * Get the email sender address.
     *
     * @return Address The email sender address.
     */
    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * Get the email recipient(s) address.
     *
     * @return Address[] The email recipient(s) address.
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * Get the email carbon copy (CC) recipient(s) address.
     *
     * @return Address The email CC recipient(s) address.
     */
    public function getCc(): ?Address
    {
        return $this->cc;
    }

    /**
     * Get the email blind carbon copy (BCC) recipient(s) address.
     *
     * @return Address The email BCC recipient(s) address.
     */
    public function getBcc(): ?Address
    {
        return $this->bcc;
    }

    /**
     * Get the email subject.
     *
     * @return string The email subject.
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Get the email plain text body.
     *
     * @return string The email plain text body.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get the email HTML body.
     *
     * @return string The email HTML body.
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * Get the email reply-to address.
     *
     * @return null|Address The email reply-to address.
     */
    public function getReplyTo(): ?Address
    {
        return $this->replyTo;
    }

    /**
     * Get the email attachments.
     *
     * @return Attachment[] The email attachments.
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * Get the email message (plain text and HTML).
     *
     * @return array An array containing the email plain text and HTML body.
     */
    public function getMsg(): array
    {
        return [$this->text, $this->html];
    }

    /**
     * Get the specific email attachment.
     *
     * @param string $file The file name of the attachment.
     * @return ?Attachment The attachment object or null if not exists.
     */
    public function getAttachment(string $file): ?Attachment
    {
        foreach ($this->attachments as $attachment) {
            if ($attachment->getName() === $file)
                return  $attachment;
        }
        return  null;
    }

    /**
     * Set the email sender address.
     *
     * @param string|Address $email The email sender address. If null, the current sender address will be used.
     * @return self
     */
    public function setFrom(string|Address $email): self
    {
        $this->from = is_string($email) ? Address::createFrom($email) : $email;
        return $this;
    }

    /**
     * Set the email recipient(s) address.
     *
     * @param Address[] $emails The email recipient(s) address.
     * @return self
     */
    public function setTo(array $emails): self
    {
        $this->to = $this->setAddressFromArray($emails);
        return $this;
    }

    /**
     * Set the email carbon copy (CC) recipient(s) address.
     *
     * @param string|Address $email The email CC recipient(s) address.
     * @return self
     */
    public function setCc(string|Address $email): self
    {
        $this->cc = is_string($email) ? Address::createFrom($email) : $email;
        return $this;
    }

    /**
     * Set the email blind carbon copy (BCC) recipient(s) address.
     *
     * @param string|Address $email The email BCC recipient(s) address.
     * @return self
     */
    public function setBcc(string|Address $email): self
    {
        $this->bcc = is_string($email) ? Address::createFrom($email) : $email;
        return $this;
    }

    /**
     * Set the email subject.
     *
     * @param string $subject The email subject.
     * @return self
     */
    public function setSubject(string $subject = ''): self
    {

        $this->subject = $subject;
        return $this;
    }

    /** 
     * Set the email plain text body.
     *
     * @param string $text The email plain text body.
     * @return self
     */
    public function setText(string $text = ''): self
    {

        $this->text = $text;
        return $this;
    }

    /**
     * Set the email HTML body.
     *
     * @param string $html The email HTML body.
     * @return self
     */
    public function setHtml(string $html): self
    {

        $this->html = $html;
        return $this;
    }

    /**
     * set the email message (plain text and HTML).
     * @param string $text
     * @param string $template used for set HTML template by `sprintf` function,the html content must using `%s` to set $text correctly in HTML body 
     * @return self
     */
    public function setMsg(string $text, string $template = '<p>%s</p>'): self
    {
        $this->text = $text;
        $this->html = sprintf($template, $text);
        return $this;
    }

    /**
     * Set the email reply-to address.
     *
     * @param string|Address $email The email reply-to address.
     * @return self
     */
    public function setReplyTo(string|Address $email): self
    {

        $this->replyTo = is_string($email) ? Address::createFrom($email) : $email;
        return $this;
    }

    /**
     * Set the email attachment(s).
     *
     * @param Attachment[] $files The file name(s) or file path(s) of the attachment(s).
     * @return self
     */
    public function setAttachments(array $files): self
    {
        foreach ($files as $file) {
            $this->addAttachment($file);
        }
        return $this;
    }

    /**
     * Set the email attachment.
     *
     * @param Attachment|string $file The file name with file path of the attachment(s) or Attachment object.
     * @return self
     */
    public function addAttachment(Attachment|string $file): self
    {
        if (is_string($file)) {
            $nameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);

            $name = pathinfo($file, PATHINFO_BASENAME);

            $att = new Attachment(path: $file, name: $nameWithoutExtension, fileName: $name);
            $this->attachments[] = $att;
        } elseif ($file instanceof Attachment) {
            $this->attachments[] = $file;
        }

        return $this;
    }


    /**
     * check the specific email attachment if exists.
     *
     * @param string $file The file name of the attachment.
     * @return string The attachment file path.
     */
    public function hasAttachment(string $file): bool
    {
        return isset($this->attachments[$file]);
    }

    /**
     * add the email recipient(s) address.
     *
     * @param string|Address $emails The email recipient(s) address.
     * @return self
     */
    public function addTo(string|Address $email): self
    {
        $this->to[] = is_string($email) ? Address::createFrom($email) : $email;
        return $this;
    }

    /*
    * Convert the email object to its string representation.
    *
    * @return string The email object as a string.
    */
    public function __toString(): string
    {
        $mail = 'MAIL: ';
        $mail .= "\n FROM: " . $this->getFrom();
        $mail .= "\n TO: " . join(',', array_map(fn ($address) => (string) $address, $this->getTo()));
        $mail .= "\n CC: " . $this->getCc();
        $mail .= "\n BCC: " . $this->getBcc();
        $mail .= "\n SUBJECT: " . $this->getSubject();
        $mail .= "\n MESSAGE: " . $this->getText();
        $mail .= "\n ATTACHMENTS: " . implode(', ', array_map(fn ($att) => (string) $att, $this->getAttachments()));
        return $mail;
    }

    /**
     * Returns an array representation of the object.
     *
     * @return array The array representation of the object.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __debugInfo()
    {
        $this->text  = substr($this->text, 0, 250) . '...';
        $this->html  = substr($this->html, 0, 150) . '...';
    }

    /**
     * Converts the object to an array.
     *
     * @return array The array representation of the object.
     */
    private function toArray(): array
    {
        return get_class_vars($this::class);
    }

    /**
     * Set email addresses from an array or Address object.
     *
     * @param array|Address $emails An array or Address object containing email addresses.
     *
     * @return array An array of Address objects.
     */
    public function setAddressFromArray(array|Address $emails)
    {
        $addresses = [];

        if (is_array($emails)) {
            $v = new DataValidator($emails);

            if (count($emails) === 1 && !$v->isAssoc()) {
                $addresses[] = Address::createFrom($emails[0]);
            } elseif ($v->isAssoc()) {
                foreach ($emails as $name => $email) {
                    $addresses[] = new Address($email, $name);
                }
            } elseif ($v->isArrayOfAssoc()) {
                foreach ($emails as $email) {
                    foreach ($email as $key => $value) {
                        $addresses[] = new Address($value, $key);
                    }
                }
            } else {
                foreach ($emails as $email) {
                    $addresses[] = new Address($email);
                }
            }
        }

        return $addresses;
    }
}
