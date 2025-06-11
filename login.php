<?php
    include('./database/connectdb.php');
    include('./models/Usuario.php');
    include('./models/Login.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuario = new Usuario($pdo);
    $login = new Login($usuario);

    if($login->credenciaisValidas($email, $senha)) {
        http_response_code(200);
        echo json_encode(['data'=>json_encode($usuario->obterUsuario($email))]);
    } else {
        http_response_code(401);
        echo json_encode(['error'=> 'Credenciais inválidas!']);
    }
?>