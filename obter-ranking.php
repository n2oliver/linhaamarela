<?php
include("./load-env.php");
include("./database/connectdb.php");
include("./repositories/UsuarioRepository.php");
include("./repositories/PontoRepository.php");

$usuarioRepository = new UsuarioRepository($pdo);
$pontoRepository = new PontoRepository($pdo, $usuarioRepository);

$idUsuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
echo $pontoRepository->obterRanking($idUsuario);