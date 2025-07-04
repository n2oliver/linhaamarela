<?php
if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['partida_rapida'])) {
    // Redireciona para a página de login
    header("Location: index.php");
    exit;
}