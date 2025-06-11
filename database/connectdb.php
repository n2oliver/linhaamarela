<?php
try {
    // Cria (ou abre) o banco de dados SQLite
    $pdo = new PDO("sqlite:". __DIR__ . "/usuario.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco!";
}