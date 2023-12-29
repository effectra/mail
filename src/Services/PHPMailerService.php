<?php

declare(strict_types=1);

namespace Effectra\Mail\Services;

use Effectra\Config\ConfigDriver;
use Effectra\Mail\Contracts\MailerInterface;
use Effectra\Mail\Contracts\MailInterface;
use Effectra\Mail\Exception\MailerException;
use Effectra\Mail\Utils\LoggerTrait;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class PHPMailerService
 *
 * Service class for sending emails using PHPMailer.
 */
class PHPMailerService extends ConfigDriver implements MailerInterface
{
    use LoggerTrait;
    /**
     * Send an email using PHPMailer.
     *
     * @param MailInterface $mail The MailInterface instance representing the email to be sent.
     *
     * @throws MailerException If an error occurs during the email sending process.
     */
    public function send(MailInterface $mail)
    {
        $phpMailer = new PHPMailer();

        if ($this->logger) {
            $phpMailer->SMTPDebug = 2;  // Set the debug level (0 to disable)
            $phpMailer->Debugoutput = function ($str, $level) {
                $this->startLog($level, $str);
            };
        }

        $phpMailer->isSMTP();
        $phpMailer->Host = $this->getHost();
        $phpMailer->SMTPAuth = true;
        $phpMailer->Username = $this->getUsername();
        $phpMailer->Password = $this->getPassword();
        $phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $phpMailer->SMTPSecure = 'tls';
        $phpMailer->Port = $this->getPort();

        $phpMailer->setFrom(
            $mail->getFrom()->getEmail(),
            $mail->getFrom()->getName()
        );

        foreach ($mail->getTo() as $address) {
            $phpMailer->addAddress(
                $address->getEmail(),
                $address->getName()
            );
        }

        if ($mail->getReplyTo()) {
            $phpMailer->addReplyTo(
                $mail->getReplyTo()->getEmail(),
                $mail->getReplyTo()->getName()
            );
        }
        if ($mail->getCC()) {
            $phpMailer->addCC(
                $mail->getCC()->getEmail(),
                $mail->getCC()->getName()
            );
        }

        if ($mail->getBcc()) {
            $phpMailer->addBCC(
                $mail->getBcc()->getEmail(),
                $mail->getBcc()->getName()
            );
        }

        $phpMailer->Subject = $mail->getSubject();
        $phpMailer->AltBody = $mail->getText();

        if (!empty($mail->getHtml())) {
            $phpMailer->isHTML(true);
            $phpMailer->Body = $mail->getHtml();
        }

        if (!empty($mail->getAttachments())) {
            foreach ($mail->getAttachments() as  $attachment) {

                if (!$attachment->isPathExists()) {
                    throw new \Exception('Attachment path is empty or invalid.');
                }

                $phpMailer->addAttachment($attachment->getPath());
            }
        }

        $phpMailer->send();

        $phpMailer->ClearAddresses();
        $phpMailer->ClearAttachments();
    }
}
