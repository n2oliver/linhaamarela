<?php
include('./database/connectdb.php');
include('./repositories/UsuarioRepository.php');
include('./repositories/LoginRepository.php');
$usuarioRepository = new UsuarioRepository($pdo);
$loginRepository = new LoginRepository($usuarioRepository);
$loginRepository->sair();