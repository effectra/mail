<?php

declare(strict_types=1);

namespace Effectra\Mail\Factory;

use Effectra\Mail\Contracts\MailInterface;
use Effectra\Mail\Mail;

/**
 * Class MailFactory
 *
 * Factory class for creating instances of MailInterface.
 */
class MailFactory
{
    /**
     * Create a new instance of MailInterface.
     *
     * @return MailInterface A new instance of MailInterface.
     */
    public function createMail(): MailInterface
    {
        return new Mail();
    }
}
