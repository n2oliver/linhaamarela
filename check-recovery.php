<?php
session_start();
include("../../load-env.php");
include("../../database/connectdb.php");
include("./repositories/UsuarioRepository.php");

use PHPMailer\PHPMailer\Exception;

$code = $_POST['codigo'];

try {
    if($code == $_SESSION['code']) {
        $usuarioRepository = new UsuarioRepository($pdo);
        /* TODO Adicionar usuario ao validar o email */
        /* TODO Abrir etapa de criação de senha */
        $_SESSION['email_validado'] = 1;
        http_response_code(200);
        echo json_encode(['data'=>'Código validado com sucesso! Crie sua senha!'], true);
        exit;
    }

    http_response_code(401);
    echo json_encode(['error'=>"Código inválido! Tente novamente!"], true);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error'=>"Erro ao verificar código!"], true);
}