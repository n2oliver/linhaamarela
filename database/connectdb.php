<?php
include('DBSessionHandler.php');
try {
    $pdo = new PDO(
        "mysql:host=" . getenv('DB_HOST') . 
        ";port=" . getenv('DB_PORT') . 
        ";dbname=" . getenv('DB_NAME'), 
        getenv('DB_USER'), 
        getenv('DB_PASS'), 
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
    $handler = new DBSessionHandler($pdo);

    session_set_save_handler($handler, true);
    session_start();
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco!" . $e;
}
