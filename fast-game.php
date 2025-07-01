<?php
    include('./load-env.php');
    include('./database/connectdb.php');
    session_start();
    $_SESSION['partida_rapida'] = true;
    $_SESSION['usuario_id'] = null;
    header("Location: game.php");
    exit;
?>