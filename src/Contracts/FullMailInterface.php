<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

/**
 * Interface FullMailInterface
 *
 * Represents a full mail interface extending the basic MailInterface.
 */
interface FullMailInterface extends MailInterface
{
    /**
     * Get the sender address.
     *
     * @return string|null The sender address.
     */
    public function getSender(): ?string;

    /**
     * Get the return path.
     *
     * @return string The return path.
     */
    public function getReturnPath(): string;

    /**
     * Get the date of the mail.
     *
     * @return \DateTimeInterface The date of the mail.
     */
    public function getDate(): \DateTimeInterface;

    /**
     * Get the message ID.
     *
     * @return string|null The message ID.
     */
    public function getMessageId(): ?string;

    /**
     * Get the newsgroups.
     *
     * @return mixed The newsgroups.
     */
    public function getNewsGroups();

    /**
     * Get the follow-up address.
     *
     * @return mixed The follow-up address.
     */
    public function getFollowupTo();

    /**
     * Get the references.
     *
     * @return mixed The references.
     */
    public function getReferences();

    /**
     * Get the message number.
     *
     * @return int The message number.
     */
    public function getMsgNumber(): int;

    /**
     * Get the mail date.
     *
     * @return \DateTimeInterface|null The mail date.
     */
    public function getMailDate(): ?\DateTimeInterface;

    /**
     * Get the size of the mail.
     *
     * @return int The size of the mail.
     */
    public function getSize(): int;

    /**
     * Get the fetch from information.
     *
     * @return mixed The fetch from information.
     */
    public function getFetchFrom();

    /**
     * Set the sender address.
     *
     * @param string|null $sender The sender address.
     *
     * @return self
     */
    public function setSender(?string $sender): self;

    /**
     * Set the return path.
     *
     * @param string $returnPath The return path.
     *
     * @return void
     */
    public function setReturnPath(string $returnPath): void;

    /**
     * Set the date of the mail.
     *
     * @param \DateTimeInterface $date The date of the mail.
     *
     * @return void
     */
    public function setDate(\DateTimeInterface $date): void;

    /**
     * Set the message ID.
     *
     * @param string|null $messageId The message ID.
     *
     * @return void
     */
    public function setMessageId(?string $messageId): void;

    /**
     * Set the newsgroups.
     *
     * @param mixed $newsGroups The newsgroups.
     *
     * @return void
     */
    public function setNewsGroups($newsGroups): void;

    /**
     * Set the recent status.
     *
     * @param bool $recent The recent status.
     *
     * @return void
     */
    public function setRecent(bool $recent): void;

    /**
     * Check if the mail is unseen.
     *
     * @return bool True if the mail is unseen, false otherwise.
     */
    public function isUnseen(): bool;

    /**
     * Set the follow-up address.
     *
     * @param mixed $followupTo The follow-up address.
     *
     * @return void
     */
    public function setFollowupTo($followupTo): void;

    /**
     * Set the flagged status.
     *
     * @param bool $flagged The flagged status.
     *
     * @return void
     */
    public function setFlagged(bool $flagged): void;

    /**
     * Set the answered status.
     *
     * @param bool $answered The answered status.
     *
     * @return void
     */
    public function setAnswered(bool $answered): void;

    /**
     * Set the deleted status.
     *
     * @param bool $deleted The deleted status.
     *
     * @return void
     */
    public function setDeleted(bool $deleted): void;

    /**
     * Set the draft status.
     *
     * @param bool $draft The draft status.
     *
     * @return void
     */
    public function setDraft(bool $draft): void;

    /**
     * Set the references.
     *
     * @param mixed $references The references.
     *
     * @return void
     */
    public function setReferences($references): void;

    /**
     * Set the message number.
     *
     * @param int $msgNumber The message number.
     *
     * @return void
     */
    public function setMsgNumber(int $msgNumber): void;

    /**
     * Set the mail date.
     *
     * @param \DateTimeInterface|null $mailDate The mail date.
     *
     * @return void
     */
    public function setMailDate(?\DateTimeInterface $mailDate): void;

    /**
     * Set the size of the mail.
     *
     * @param int $size The size of the mail.
     *
     * @return void
     */
    public function setSize(int $size): void;

    /**
     * Check if the mail is recent.
     *
     * @return bool True if the mail is recent, false otherwise.
     */
    public function isRecent(): bool;

    /**
     * Set the unseen status.
     *
     * @param bool $unseen The unseen status.
     *
     * @return void
     */
    public function setUnseen(bool $unseen): void;

    /**
     * Check if the mail is flagged.
     *
     * @return bool True if the mail is flagged, false otherwise.
     */
    public function isFlagged(): bool;

    /**
     * Check if the mail is answered.
     *
     * @return bool True if the mail is answered, false otherwise.
     */
    public function isAnswered(): bool;

    /**
     * Check if the mail is deleted.
     *
     * @return bool True if the mail is deleted, false otherwise.
     */
    public function isDeleted(): bool;

    /**
     * Check if the mail is a draft.
     *
     * @return bool True if the mail is a draft, false otherwise.
     */
    public function isDraft(): bool;

    /**
     * Get the Unix date of the mail.
     *
     * @return \DateTimeInterface|null The Unix date of the mail.
     */
    public function getUnixDate(): ?\DateTimeInterface;

    /**
     * Set the Unix date of the mail.
     *
     * @param \DateTimeInterface|null $unixDate The Unix date of the mail.
     *
     * @return void
     */
    public function setUnixDate(?\DateTimeInterface $unixDate): void;

    /**
     * Set the fetch from information.
     *
     * @param mixed $fetchFrom The fetch from information.
     *
     * @return void
     */
    public function setFetchFrom($fetchFrom): void;
}
