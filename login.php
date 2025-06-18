<?php
    include('./database/connectdb.php');
    include('./models/Usuario.php');
    include('./models/Login.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new Usuario($pdo);
    $login = new Login($usuarioModel);

    if($login->credenciaisValidas($email, $senha)) {
        $usuario = $usuarioModel->obterUsuario($email);
        
        $_SESSION['usuario_id'] = $usuario['id'];
        var_dump($_SESSION['usuario_id']);
        http_response_code(200);

        echo json_encode(['data'=>json_encode($usuario)]);
    } else {
        http_response_code(401);
        echo json_encode(['error'=> 'Credenciais inválidas!']);
    }
?>