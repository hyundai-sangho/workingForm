<?php

// PHPMailer 클래스를 전역 네임스페이스로 가져오기
// 함수 내부가 아니라 스크립트 상단에 있어야 합니다.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Composer의 오토로더 로드
require 'vendor/autoload.php';

// 인스턴스를 생성합니다. 'true'를 전달하면 예외가 활성화됩니다.
$mail = new PHPMailer(true);

// POST로 전달받은 폼 데이터 변수로 추출
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$website = $_POST['website'];
$message = $_POST['message'];

if(!empty($email) && !empty($message)) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        try {
            //Server settings
            $mail->CharSet    = "utf-8";
            $mail->Encoding   = "base64";
            $mail->SMTPDebug    = SMTP::DEBUG_SERVER;                // Enable verbose debug output
            $mail->isSMTP();                                              // Send using SMTP
            $mail->Host         = 'smtp.naver.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth     = true;                             // Enable SMTP authentication
            $mail->Username     = 'teha007@naver.com';                    // SMTP username
            $mail->Password     = 'UHEZGVW41CYL';                         // SMTP password
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;    // Enable implicit TLS encryption
            $mail->Port         = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('teha007@naver.com', '조상호');
            $mail->addAddress($email, '상대방');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');   // 참조
            // $mail->addBCC('bcc@example.com'); // 숨은 참조

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "${name}에게 메일 보냄";
            $mail->Body    = "이름: $name<br>이메일: $email<br>폰번호: $phone<br>웹사이트: $website<br><br>메시지: $message<br>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo "메시지 전송이 완료되었습니다.";
        } catch (Exception $e) {
            echo "메시지 전송에 실패하였습니다.";
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "유효한 이메일 주소를 입력하세요.";
    }
} else {
    echo "이메일과 비밀번호를 입력해주세요.";
}
