<?php
include("../../load-env.php");
include("../../database/connectdb.php");
include("./repositories/UsuarioRepository.php");
include("./repositories/PontoRepository.php");

$usuarioRepository = new UsuarioRepository($pdo);
$pontoRepository = new PontoRepository($pdo, $usuarioRepository);

$usuarioId = $_SESSION['usuario_id'];
$pontos = $_POST['pontos'];
$nivel = $_POST['nivel'];

$pontoRepository->adicionarPontos($usuarioId, $pontos, $nivel);