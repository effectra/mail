<?php

declare(strict_types=1);

namespace Effectra\Mail;

use Effectra\Config\ConfigDriver;
use Effectra\Mail\Contracts\MailerInterface;
use Effectra\Mail\Contracts\MailInterface;
use Effectra\Mail\Exception\MailerException;

/**
 * class Mailer
 * This class represents a mailer for sending emails using a specific driver. It extends the ConfigDriver class and implements the MailerInterface.
 */
class Mailer extends ConfigDriver implements MailerInterface
{

    /**
     * Send an email using the provided MailInterface instance.
     *
     * @param MailInterface $mail The MailInterface instance representing the email to be sent.
     */
    public function send(MailInterface $mail)
    {
        // Use the methods from the Mail class to get the necessary information
        
        $to = join(',',array_map(fn($address) => (string) $address,$mail->getTo()));
        $from = (string) $mail->getFrom();
        $subject = $mail->getSubject();
        $html = $mail->getHtml();

        // Additional parameters can be added based on your requirements
        // For example, you might want to add CC and BCC recipients
        $headers = "From: $from\r\n";
        $headers .= "Content-Type: text/html\r\n";

        // Add CC and BCC if they are set in the Mail object
        $cc = $mail->getCc();
        $bcc = $mail->getBcc();

        if ($cc) {
            $headers .= "Cc: $cc\r\n";
        }

        if ($bcc) {
            $headers .= "Bcc: $bcc\r\n";
        }

        try {
            return mail($to, $subject, $html, $headers);
        } catch (\Exception $e) {
            throw new MailerException('Mailer Error: ' . $e->getMessage());
        }
    }
}
