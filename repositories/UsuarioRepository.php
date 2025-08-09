<?php
try {
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB;";
    $pdo->exec($sql);

} catch (Exception $e) {
    echo "Erro ao obter o modelo de usuarios!";
}

class UsuarioRepository {
    private $pdo;
    function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function usuarioExiste($email) {
        $sql = "SELECT COUNT(*) total FROM usuario WHERE email LIKE '$email'";
        $result = $this->pdo->query($sql)->fetch();
        return $result['total'] > 0;
    }
    public function nomeJaEmUso($nome) {
        $sql = "SELECT COUNT(*) total FROM usuario WHERE nome LIKE '$nome'";
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


    public function obterUsuarioComSenha($email) {
        $sql = "SELECT id, nome, email, senha FROM usuario WHERE email LIKE '$email' ORDER BY id DESC LIMIT 1";
        $result = $this->pdo->query($sql)->fetch();
        return $result;
    }

    public function obterUsuarioPorId($id) {
        $sql = "SELECT nome, email FROM usuario WHERE id = '$id' ORDER BY id DESC LIMIT 1";
        $result = $this->pdo->query($sql)->fetch();
        return $result;
    }

    public function inserirUsuario($nome, $email, $senha) {
        $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '" . md5($senha) . "');";
        $result = $this->pdo->exec($sql);
        return $result;
    }

    public function alterarSenhaUsuario($idUsuario, $senha) {
        $sql = "UPDATE usuario SET senha = '" . md5($senha) . "' WHERE id = $idUsuario;";
        $result = $this->pdo->exec($sql);
        return $result;
    }
}