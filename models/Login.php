<?php
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS sessions (
            id VARCHAR(128) PRIMARY KEY,
            data TEXT,
            timestamp INT(11)
        )";
        $pdo->exec($sql);

    } catch (Exception $e) {
        echo "Erro ao obter o modelo de login!";
    }

    class Login {
        private $usuario;
        function __construct(Usuario $usuario) {
            $this->usuario = $usuario;
        }
        public function credenciaisValidas($email, $senha) {
            return $this->usuario->usuarioExiste($email) && 
                    $this->usuario->senhaExiste($senha);
        }
        public function sair() {
            unset($_SESSION['usuario_id']);
        }
    }