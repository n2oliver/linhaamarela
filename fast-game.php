<?php
    include('../../load-env.php');
    include('../../database/connectdb.php');
    session_start();
    $_SESSION['partida_rapida'] = true;
    header("Location: game.php");
    exit;
?>