# Effectra\Mail

Effectra\Mail is a package that provides a flexible and easy-to-use email sending functionality for your applications. It supports multiple mail drivers and allows you to configure various email settings such as the mail server host, port, authentication, and more.

## Features

- Support for multiple mail drivers (SMTP, sendmail, etc.)
- Configuration options for mail server settings
- Easy setup and usage
- Exception handling for mail sending errors

## Installation

You can install the Effectra\Mail package via Composer. Run the following command in your terminal:

```bash
composer require effectra/mail
```

## Usage

### Creating a Mailer Instance

To send emails using the Effectra\Mail package, you need to create a mailer instance. The `MailerFactory` class provides a convenient way to create the mailer instance:

```php
use Effectra\Mail\Mailer;

// Create a mailer instance
$mailer = new Mailer(
    'smtp',         // Mail driver (e.g., 'smtp', 'sendmail')
    'mail.example.com',  // Mail server host
    587,            // Mail server port
    'username',     // Username for authentication
    'password',     // Password for authentication
    'info@example.com'  // "From" email address
);
```

### Sending an Email

Once you have a mailer instance, you can use it to send emails. The `Mailer` class provides methods for setting the email recipients, subject, content, and more. Here's an example of sending an email:

```php
$mail = new Mail();
// Set email recipients
$mail->to('recipient1@example.com');
$mail->cc('recipient2@example.com');
$mail->bcc('recipient3@example.com');

// Set email subject and content
$mail->subject('Hello, world!');
$mail->text('This is the plain text content of the email.');
$mail->html('<p>This is the HTML content of the email.</p>');

// Send the email
try {
    $mailer->send($mail);
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo 'An error occurred while sending the email: ' . $e->getMessage();
}
```

Feel free to explore the `Mailer` class and its methods to customize the email sending process according to your needs.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, please create an issue or submit a pull request on the GitHub repository.

## Credits

Effectra\Mail is developed and maintained by [Mohammed Taha](https://github.com/bmtMohammedTaha).

## Support

For any questions or support regarding the Effectra\Mail package, please contact [support@example.com](mailto:support@example.com).

```