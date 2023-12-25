<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Mail\Contracts\FullMailInterface;

class FullMail extends Mail implements FullMailInterface
{
    /** @var string|null */
    protected ?string $sender = null;

    /** @var string */
    protected string $returnPath = '';

    /** @var \DateTimeInterface */
    protected \DateTimeInterface $date;

    /** @var string|null */
    protected ?string $messageId = null;

    /** @var mixed|null */
    protected $newsGroups = null;

    /** @var mixed|null */
    protected $followupTo = null;

    /** @var mixed|null */
    protected $references = null;

    /** @var bool */
    protected bool $recent = false;

    /** @var bool */
    protected bool $unseen = false;

    /** @var bool */
    protected bool $flagged = false;

    /** @var bool */
    protected bool $answered = false;

    /** @var bool */
    protected bool $deleted = false;

    /** @var bool */
    protected bool $draft = false;

    /** @var int */
    protected int $MsgNumber = 0;

    /** @var \DateTimeInterface|null */
    protected ?\DateTimeInterface $mailDate = null;

    /** @var int */
    protected int $size = 0;

    /** @var \DateTimeInterface|null */
    protected ?\DateTimeInterface $UnixDate = null;

    /** @var mixed|null */
    protected $fetchFrom = null;

    /** @var mixed|null */
    protected $fetchSubject = null;

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function getReturnPath(): string
    {
        return $this->returnPath;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function getNewsGroups()
    {
        return $this->newsGroups;
    }

    public function getFollowupTo()
    {
        return $this->followupTo;
    }

    public function getReferences()
    {
        return $this->references;
    }

    public function getMsgNumber(): int
    {
        return $this->MsgNumber;
    }

    public function getMailDate(): ?\DateTimeInterface
    {
        return $this->mailDate;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getFetchFrom()
    {
        return $this->fetchFrom;
    }

    public function setSender(?string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function setReturnPath(string $returnPath): void
    {
        $this->returnPath = $returnPath;
    }

    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }


    public function setMessageId(?string $messageId): void
    {
        $this->messageId = $messageId;
    }



    public function setNewsGroups($newsGroups): void
    {
        $this->newsGroups = $newsGroups;
    }


    public function setRecent(bool $recent): void
    {
        $this->recent = $recent;
    }


    public function isUnseen(): bool
    {
        return $this->unseen;
    }

    public function setFollowupTo($followupTo): void
    {
        $this->followupTo = $followupTo;
    }

    public function setFlagged(bool $flagged): void
    {
        $this->flagged = $flagged;
    }

    public function setAnswered(bool $answered): void
    {
        $this->answered = $answered;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function setDraft(bool $draft): void
    {
        $this->draft = $draft;
    }

    public function setReferences($references): void
    {
        $this->references = $references;
    }

    public function setMsgNumber(int $MsgNumber): void
    {
        $this->MsgNumber = $MsgNumber;
    }

    public function setMailDate(?\DateTimeInterface $mailDate): void
    {
        $this->mailDate = $mailDate;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function isRecent(): bool
    {
        return $this->recent;
    }

    public function setUnseen(bool $unseen): void
    {
        $this->unseen = $unseen;
    }

    public function isFlagged(): bool
    {
        return $this->flagged;
    }

    public function isAnswered(): bool
    {
        return $this->answered;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function getUnixDate(): ?\DateTimeInterface
    {
        return $this->UnixDate;
    }

    public function setUnixDate(?\DateTimeInterface $UnixDate): void
    {
        $this->UnixDate = $UnixDate;
    }


    public function setFetchFrom($fetchFrom): void
    {
        $this->fetchFrom = $fetchFrom;
    }

    /**
     * Get a mail manager instance for further mail management operations.
     *
     * @param $imap
     * @return MailManager
     */
    public function manage($imap): MailManager
    {
        return new MailManager($imap, $this->messageId);
    }
}
