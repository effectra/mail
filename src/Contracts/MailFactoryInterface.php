<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

/**
 * Interface MailFactoryInterface
 *
 * Represents a mail factory interface for creating instances of MailInterface.
 */
interface MailFactoryInterface
{
    /**
     * Create a new instance of a mail object implementing MailInterface.
     *
     * @return MailInterface A new instance of a mail object.
     */
    public function createMail(): MailInterface;
}
