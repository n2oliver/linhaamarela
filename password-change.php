<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('../../load-env.php');
require_once("../../database/connectdb.php");
require_once("./repositories/UsuarioRepository.php");
require_once("./lib/phpmailer/PHPMailer.php");
require_once("./lib/phpmailer/SMTP.php");
require_once("./lib/phpmailer/Exception.php");

$email = $_POST['email'];
$senha = $_POST['senha'];
$emailValidado = $_SESSION['email_validado'];

if($emailValidado && !empty($email) && !empty($senha)) {
    $usuarioRepository = new UsuarioRepository($pdo);
    $mailService = new PHPMailer(true);
    try {
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
        $mailService->Subject = 'Sua senha foi alterada no Linha Amarela!';
        $mailService->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 2px solid #f8c300; border-radius: 12px; overflow: hidden; background-color: #fff;">
                <div style="background-color: #f8c300; padding: 20px; text-align: center;">
                    <h1 style="color: #000; margin: 0;">Sua solicitação de alteração de senha foi concluída!</h1>
                </div>
                <div style="padding: 20px; color: #333;">
                    <p style="font-size: 16px;">
                        Prepare-se para uma experiência divertida, cheia de desafios e jogadas rápidas!
                    </p>
                    <p style="font-size: 16px;">
                        Você acaba de voltar ao mundo do <strong>Linha Amarela</strong>, um jogo onde cada segundo conta e cada movimento importa.
                    </p>
                    <p style="font-size: 16px;">
                        Agradecemos por fazer parte da nossa comunidade. Bons jogos!
                    </p>
                    <p style="font-size: 14px; color: #999; margin-top: 40px;">
                        Dica: agora você já pode fazer o login com a nova senha cadastrada. 🚀
                    </p>
                </div>
                <div style="background-color: #f8c300; padding: 10px; text-align: center;">
                    <small style="color: #000;">&copy; '.date('Y').' Linha Amarela – Jogue com inteligência.</small>
                </div>
            </div>';
        $mailService->AltBody = 'Bem-vindo de volta ao Linha Amarela! Você acaba de entrar em um jogo cheio de desafios e diversão. Obrigado por se juntar a nós!';
        
        $mailService->send();
        $usuario = $usuarioRepository->obterUsuario($email);
        $usuarioRepository->alterarSenhaUsuario($usuario['id'], $senha);
        $_SESSION['usuario_id'] = $usuario['id'];
        
        http_response_code(200);
        echo json_encode(['data' => 'Boas-vindas enviadas! Agora é só entrar no jogo e se divertir! 😄'], true);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error'=>"Erro ao cadastrar usuário!"], true);
    }
} else {
    if(!$emailValidado) {
        http_response_code(401);
        echo json_encode(['error'=>"E-mail não validado!"], true);
        return;
    }

    http_response_code(401);
    echo json_encode(['error'=>"Preencha todos os campos!"], true);
}