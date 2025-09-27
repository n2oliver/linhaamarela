<?php
    include('../../load-env.php');
    include('../../database/connectdb.php');
    $_SESSION['partida_rapida'] = true;
    header("Location: game.php");
    exit;
?>