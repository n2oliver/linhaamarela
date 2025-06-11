<?php
try {
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        senha TEXT NOT NULL
    )";
    $pdo->exec($sql);

} catch (Exception $e) {
    echo "Erro ao obter o modelo de usuarios!";
}

class Usuario {
    private $pdo;
    function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function usuarioExiste($email) {
        $sql = "SELECT COUNT(*) total FROM usuario WHERE email LIKE '$email'";
        $result = $this->pdo->query($sql)->fetch();
        return $result['total'] > 0;
    }
    public function senhaExiste($senha) {
        $sql = "SELECT COUNT(*) total FROM usuario WHERE senha LIKE '$senha'";
        $result = $this->pdo->query($sql)->fetch();
        return $result['total'] > 0;
    }

    public function obterUsuario($email) {
        $sql = "SELECT id, nome, email FROM usuario WHERE email LIKE '$email' ORDER BY id DESC LIMIT 1";
        $result = $this->pdo->query($sql)->fetch();
        return $result;
    }
}