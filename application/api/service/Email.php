<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/5
 * Time: 21:41
 */

namespace app\api\service;

use app\exception\Base;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public function __construct($address, $name, array $content)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.qq.com';
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = '1422476675@qq.com';
            $mail->Password = 'cbpbsswbevbjbafb';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('1422476675@qq.com', 'lee129');
            $mail->addAddress($address, $name);     // Add a recipient
            //            $mail->addAddress('ellen@example.com');  //添加多个收件人 则多次调用方法即可
            //            $mail->addReplyTo('info@example.com', 'Information');//回复地址
            //            $mail->addCC('cc@example.com');
            //            $mail->addBCC('bcc@example.com');

            // Attachments
            //            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);
            $mail->Body = $content['body'];
            if(!empty($content['subject'])){
                $mail->Subject = $content['subject'];
            }
            if(!empty($content['alt_body'])){
                $mail->AltBody = $content['alt_body'];
            }

            $mail->send();
        } catch (Exception $e) {
            throw Base(['msg' => $mail->ErrorInfo]);
        }
    }
}