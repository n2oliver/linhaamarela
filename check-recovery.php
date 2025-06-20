<?php
session_start();

use PHPMailer\PHPMailer\Exception;

$code = $_POST['codigo'];


try {
    if($code == $_SESSION['code']) {
        http_response_code(200);
        echo json_encode(['data'=>'Código validado com sucesso!'], true);
        return;
    }

    http_response_code(401);
    echo json_encode(['error'=>"Código inválido! Tente novamente!".$_SESSION['code']], true);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error'=>"Erro ao verificar código!"], true);
}