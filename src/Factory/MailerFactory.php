<?php

declare(strict_types=1);

namespace Effectra\Mail\Factory;

use Effectra\Mail\Contracts\MailerInterface;
use Effectra\Mail\Mailer;

/**
 * Class MailerFactory
 *
 * Factory class responsible for creating instances of the Mailer class.
 *
 * @package Effectra\Mail\Factory
 */
class MailerFactory
{
    /**
     * Create a new mailer instance.
     *
     * @param string $driver The mail driver.
     * @param string $host The mail server host.
     * @param int $port The mail server port.
     * @param string $username The username for authentication.
     * @param string $password The password for authentication.
     * @param string $from The "from" email address.
     *
     * @return MailerInterface The created mailer instance.
     */
    public function createMailer(
        string $driver,
        string $host,
        int $port,
        string $username,
        string $password,
        string $from
    ): MailerInterface {
        $mailer = new Mailer($driver, $host, $port, $username, $password, $from);
        return $mailer->to('')->from('');
    }
}
