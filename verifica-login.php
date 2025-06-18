<?php
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para a página de login
    header("Location: index.php");
    exit;
}