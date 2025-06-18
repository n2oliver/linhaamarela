<?php
include('./database/connectdb.php');
include('./models/Usuario.php');
include('./models/Login.php');
$usuario = new Usuario($pdo);
$login = new Login($usuario);
$login->sair();