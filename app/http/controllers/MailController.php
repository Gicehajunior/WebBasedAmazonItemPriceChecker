<?php
// Load Composer's autoloader
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    public $set_from_Header_name;
    public $set_from_email;
    public $set_to_user_emails;
    public $subject;
    public $message;
    public $html_body;
    public $attachments;
    public $set_from_password;

    public function __construct($set_from_Header_name, $set_from_email, $set_to_user_emails = [], $subject, $message = '', $html_body = '', $attachments = [], $set_from_password)
    {
        $this->set_from_Header_name = $set_from_Header_name;
        $this->set_from_email = $set_from_email;
        $this->set_to_user_emails = $set_to_user_emails;
        $this->subject = $subject;
        $this->message = $message;
        $this->html_body = $html_body;
        $this->attachments = $attachments;
        $this->set_from_password = $set_from_password;
    }

    public function email_user()
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                               // Disable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'mail.urbanviewhotel.co.ke';      // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $this->set_from_email;                     // SMTP username
            $mail->Password   = $this->set_from_password;                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet  = 'UTF-8';

            //Recipients
            $mail->setFrom($this->set_from_email, $this->set_from_Header_name);

            if (is_array($this->set_to_user_emails)) {
                if (count($this->set_to_user_emails) > 0) {
                    foreach ($this->set_to_user_emails as $to_email_address) {
                        $mail->addAddress($to_email_address);         // Add a recipient
                    }
                }
            } else {
                if (!empty($this->set_to_user_emails)) {
                    $to_email_address = $this->addresses;
                    $mail->addAddress($to_email_address);
                }
            }

            // Attachmentsmail.urbanviewhotel@booking.com
            if (is_array($this->attachments)) {
                if (count($this->attachments) > 0) {
                    foreach ($this->attachments as $attachment) {
                        $mail->addAttachment($attachment);         // Add attachments 
                    }
                }
            } else {
                if (!empty($this->attachments)) {
                    $attachment = $this->attachments;
                    $mail->addAttachment($attachment);
                }
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->html_body;
            $mail->AltBody = $this->message;

            if ($mail->send()) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
