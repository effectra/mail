<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Config\ConfigDriver;
use Effectra\Mail\Contracts\MailerInterface;

/**
 * Class Mailer
 *
 * This class represents a mailer for sending emails using a specific driver.
 * It extends the ConfigDriver class and implements the MailerInterface.
 *
 * @package Effectra\Mail
 */
class Mailer extends ConfigDriver implements MailerInterface
{
    use MailerTrait;

    /**
     * Mailer constructor.
     *
     * Initializes the mailer with the provided configuration.
     *
     * @param string $driver The mail driver.
     * @param string $host The mail server host.
     * @param int $port The mail server port.
     * @param string $username The mail server username.
     * @param string $password The mail server password.
     * @param string $from The sender's email address.
     */
    public function __construct(string $driver, string $host, int $port, string $username, string $password, string $from)
    {
        // Call the parent constructor with the provided arguments
        parent::__construct(...func_get_args());

        // Set the EMAIL_FROM and REPLY_TO properties to the provided $from value
        $this->EMAIL_FROM = $from;
        $this->REPLY_TO = $from;
    }
}
