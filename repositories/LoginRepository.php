<?php
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS sessions (
            id VARCHAR(128) NOT NULL PRIMARY KEY,
            data TEXT,
            timestamp INT(11) NOT NULL
        ) ENGINE=InnoDB;";
        $pdo->exec($sql);

    } catch (Exception $e) {
        echo "Erro ao obter o modelo de login!";
    }

    class LoginRepository {
        private $usuarioRepository;
        function __construct(UsuarioRepository $usuarioRepository) {
            $this->usuario = $usuarioRepository;
        }
        public function credenciaisValidas($email, $senha) {
            $usuario = $this->usuario->obterUsuario($email);
            return md5($usuario['senha']) == md5($senha);
        }
        public function sair() {
            unset($_SESSION['usuario_id']);
        }
    }