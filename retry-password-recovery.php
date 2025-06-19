<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once(__DIR__."/load-env.php");
require_once(__DIR__."/generate-secure-id.php");
require_once(__DIR__."/lib/phpmailer/PHPMailer.php");
require_once(__DIR__."/lib/phpmailer/SMTP.php");
require_once(__DIR__."/lib/phpmailer/Exception.php");

$email = $_POST['email'];

$mailService = new PHPMailer(true);

try {
    loadEnv(__DIR__ . '/.env');
    $mailService->isSMTP();
    $mailService->Host       = getenv('SMTP_HOST');
    $mailService->SMTPAuth   = getenv('SMTP_AUTH');
    $mailService->Username   = getenv('SMTP_USER'); // seu email da Umbler
    $mailService->Password   = getenv('SMTP_PASS');          // a senha do email
    $mailService->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailService->Port       = getenv('SMTP_PORT');

    $mailService->setFrom(getenv('SMTP_USER'), 'Linha Amarela');
    $mailService->addAddress($email, $email);
    $mailService->addReplyTo(getenv('SMTP_USER'), 'Information');

    $mailService->CharSet = "UTF-8";

    $mailService->isHTML(true);
    $mailService->Subject = 'Seu Código - Linha Amarela';
    $mailService->Body    = 'Seu código é: <b>'.$_SESSION['code'].'</b>';
    $mailService->AltBody = '<b>'.$_SESSION['code'].'</b>Copie ou digite este código e insira no campo Código do Email!';

    $mailService->send();

    http_response_code(200);
    echo json_encode(['data'=>'Enviamos um código para o seu e-mail. Por favor, verifique sua caixa de entrada!'], true);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error'=>"Erro ao enviar: {$mailService->ErrorInfo}"], true);
}