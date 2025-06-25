<?php
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS ponto (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT UNSIGNED,
            pontuacao INT(11) NOT NULL,
            nivel INT(11) NOT NULL,
            data DATETIME DEFAULT CURRENT_TIMESTAMP,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_usuario) REFERENCES usuario(id)
        ) ENGINE=InnoDB;";
        $pdo->exec($sql);

    } catch (Exception $e) {
        echo "Erro ao obter o modelo de ponto! " . $e;
    }

    class PontoRepository {
        private $usuarioRepository;
        private $pdo;
        function __construct(PDO $pdo, UsuarioRepository $usuarioRepository) {
            $this->pdo = $pdo;
            $this->usuario = $usuarioRepository;
        }
        public function adicionarPontos($usuarioId, $pontos, $nivel) {
            try {
                $pontosAtuais = $this->pdo->query("SELECT pontuacao FROM ponto WHERE id_usuario = $usuarioId LIMIT 1")->fetch();
                if($pontosAtuais) {
                    if($pontosAtuais->pontuacao < $pontos) {
                        $result = $this->pdo->exec("UPDATE ponto SET pontuacao = $pontos, nivel = $nivel WHERE id_usuario = $usuarioId");
                    }
                    return;
                }
                $sql = "INSERT INTO ponto (id_usuario, pontuacao, nivel) VALUES ($usuarioId, $pontos, $nivel)";
                $this->pdo->exec($sql);
            } catch(Exception $e) {
                http_response_code(400);
                echo "Erro ao adicionar pontos!";
            }
        }
    }