<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once(__DIR__."/lib/phpmailer/PHPMailer.php");
require_once(__DIR__."/lib/phpmailer/SMTP.php");
require_once(__DIR__."/lib/phpmailer/Exception.php");

$email = $_POST['email'];

$mailService = new PHPMailer(true);

try {
    $mailService->isSMTP();
    $mailService->Host       = 'smtp.umbler.com';
    $mailService->SMTPAuth   = true;
    $mailService->Username   = 'linha.amarela@n2oliver.com'; // seu email da Umbler
    $mailService->Password   = 'P2Paccountr#';          // a senha do email
    $mailService->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailService->Port       = 587;

    $mailService->setFrom('linha.amarela@n2oliver.com', 'Linha Amarela');
    $mailService->addAddress($email, $email);
    $mailService->addReplyTo('linha.amarela@n2oliver.com', 'Information');

    $mailService->isHTML(true);
    $mailService->Subject = 'Aqui está o assunto';
    $mailService->Body    = 'Este é o corpo da mensagem em <b>HTML</b>';
    $mailService->AltBody = 'Este é o corpo da mensagem em texto simples';

    $mailService->send();
    echo 'Mensagem enviada com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar: {$mailService->ErrorInfo}";
}