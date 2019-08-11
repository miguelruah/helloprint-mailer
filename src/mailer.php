<?php

    require_once('../config/config.php'); // include database config data

    require_once('./autoloader.php'); // include autoloader function
    autoload();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    /* Exception class. */
    require '../vendor/PHPMailer/src/Exception.php';

    /* The main PHPMailer class. */
    require '../vendor/PHPMailer/src/PHPMailer.php';

    /* SMTP class, needed if you want to use SMTP. */
    require '../vendor/PHPMailer/src/SMTP.php';

    $input = json_decode(file_get_contents('php://input'), true);

    $recipient     = $input['recipient'];
    $recipientname = $input['recipientname'];
    $subject       = $input['subject'];
    $body          = $input['body'];

    
    // send email to user with new password
    $mailer = new PHPMailer(true);
    try {
        $mailer->SMTPDebug = 0; // 0=mute, 1=echo errors and messages, 2=echo messages
        $mailer->isSMTP();

        $mailer->Host = $GLOBALS['smtpserver'];
        $mailer->SMTPAuth = true;
        $mailer->Username = $GLOBALS['user'];
        $mailer->Password = $GLOBALS['password'];
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = $GLOBALS['port'];

        $mailer->setFrom($GLOBALS['from'], $GLOBALS['fromname']);
        $mailer->addAddress($recipient, $recipientname);

        $mailer->isHTML(true);
        $mailer->Subject = $subject;
        $mailer->Body = $body;

        $mailer->send();
        $mailer->ClearAllRecipients();
        $mailResult = "Success sending email";

    } catch (Exception $e) {
        $mailResult = "Sending email failed with error: " . $mailer->ErrorInfo;
    }
?>