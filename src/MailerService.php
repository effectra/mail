<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Config\ConfigDriver;
use Effectra\Mail\Contracts\MailerInterface;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Class MailerService
 *
 * This class represents a mailer service for sending emails using the PHPMailer library.
 * It extends the ConfigDriver class and implements the MailerInterface.
 *
 * @package Effectra\Mail
 */
class MailerService extends ConfigDriver implements MailerInterface
{
    use MailerTrait;

    /**
     * @var PHPMailer The instance of the PHPMailer class.
     */
    protected $phpMailer;

    /**
     * MailerService constructor.
     *
     * Initializes the mailer service with the provided configuration.
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

        // Instantiate PHPMailer
        $this->phpMailer = new PHPMailer(true);
    }

    /**
     * Setup the PHPMailer instance with the configured settings and recipients.
     *
     * @return $this
     */
    public function setupPHPMailer()
    {
        $this->phpMailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->phpMailer->isSMTP();
        $this->phpMailer->Host = $this->getHost();
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->Username = $this->getUsername();
        $this->phpMailer->Password = $this->getPassword();
        $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $this->phpMailer->SMTPSecure = 'tls';
        $this->phpMailer->Port = $this->getPort();

        // Set recipients
        $this->phpMailer->setFrom($this->getFrom(), 'Mailer');
        $this->phpMailer->addAddress($this->getTo());
        $this->phpMailer->addReplyTo('info@example.com', 'Information');
        $this->phpMailer->addCC($this->getCC());
        $this->phpMailer->addBCC($this->getBcc());

        // Set content
        $this->phpMailer->isHTML(true);
        $this->phpMailer->Subject = $this->getSubject();
        $this->phpMailer->Body = $this->getHtml();
        $this->phpMailer->AltBody = $this->getText();

        return $this;
    }

    /**
     * Send the email using PHPMailer.
     *
     * @throws Exception If an error occurs while sending the email.
     */
    public function sendWithPHPMailer()
    {
        if (!$this->phpMailer->send()) {
            throw new Exception('Mailer Error: ' . $this->phpMailer->ErrorInfo);
        }
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->ClearAttachments();
    }
}
