<?php
    include('../../load-env.php');
    include('../../database/connectdb.php');
    include('./repositories/LoginRepository.php');
    include('./repositories/UsuarioRepository.php');
    
    $_SESSION['partida_rapida'] = null;
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new UsuarioRepository($pdo);
    $loginRepository = new LoginRepository($usuarioModel);

    $usuario = $usuarioModel->obterUsuario($email);
    if($usuario && $loginRepository->credenciaisValidas($email, $senha)) {
        
        $_SESSION['usuario_id'] = $usuario['id'];
        http_response_code(200);

        echo json_encode(['data'=>'Você já pode começar!']);
    } else {
        http_response_code(401);
        echo json_encode(['error'=> 'Credenciais inválidas!']);
    }
?>