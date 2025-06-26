<?php
include("./load-env.php");
include("./database/connectdb.php");
include("./repositories/UsuarioRepository.php");
include("./repositories/PontoRepository.php");

$usuarioRepository = new UsuarioRepository($pdo);
$pontoRepository = new PontoRepository($pdo, $usuarioRepository);

$page = $_POST['page'];
echo json_encode($pontoRepository->obterPaginacao($page));
