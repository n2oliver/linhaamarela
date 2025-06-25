<?php
    include('./load-env.php');
    include('./database/connectdb.php');
    include('./repositories/LoginRepository.php');
    include('./repositories/UsuarioRepository.php');
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new UsuarioRepository($pdo);
    $loginRepository = new LoginRepository($usuarioModel);

    if($loginRepository->credenciaisValidas($email, $senha)) {
        $usuario = $usuarioModel->obterUsuario($email);
        
        $_SESSION['usuario_id'] = $usuario['id'];
        http_response_code(200);

        echo json_encode(['data'=>json_encode($usuario)]);
    } else {
        http_response_code(401);
        echo json_encode(['error'=> 'Credenciais inválidas!']);
    }
?>