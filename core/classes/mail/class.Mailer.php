<?php

namespace core\classes\mail;

use PHPMailer\PHPMailer\PHPMailer,
    PHPMailer\PHPMailer\Exception,
    PHPMailer\PHPMailer\SMTP;

/**
 * Description of class Mailer
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
class Mailer
{

    /**
     * 
     * @see https://github.com/PHPMailer/PHPMailer
     * 
     * @param string $to
     * @param string $subject
     * @param string $messages
     * @param string $header
     */
    public function sendMail(string $to = '', string $subject = '', string $message = '', string $header = '')
    {
        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer();

        // Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = MAIL_HOST;                           //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                     //Enable SMTP authentication
        $mail->Username = MAIL_USERNAME;                       //SMTP username
        $mail->Password = MAIL_PASSWORD;                                 //SMTP password
        $mail->SMTPSecure = MAIL_SECURE;            //Enable implicit TLS encryption
        $mail->Port = MAIL_PORT;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        // Recipients
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($to);                         //Add a recipient
//            $mail->addAddress(MAIL_ADMIN, MAIL_ADMIN_NAME);                   //Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');
        // Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');               //Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');          //Optional name
        // Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

}