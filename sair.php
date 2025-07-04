<?php
include('./load-env.php');
include('./database/connectdb.php');

if(isset($_SESSION['partida_rapida']) && $_SESSION['partida_rapida'] == 1) {
    $_SESSION['partida_rapida'] = null;
    // Redireciona para a página de login
    header("Location: index.php");
    exit;
}

include('./repositories/UsuarioRepository.php');
include('./repositories/LoginRepository.php');
$usuarioRepository = new UsuarioRepository($pdo);
$loginRepository = new LoginRepository($usuarioRepository);
$loginRepository->sair();
// Redireciona para a página de login
header("Location: index.php");
exit;