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
            $this->usuarioRepository = $usuarioRepository;
        }
        public function adicionarPontos($usuarioId, $pontos, $nivel) {
            try {
                $pontosAtuais = $this->pdo->query("SELECT pontuacao FROM ponto WHERE id_usuario = $usuarioId LIMIT 1")->fetch();
                if($pontosAtuais) {
                    if($pontosAtuais['pontuacao'] < $pontos) {
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
        function obterPosicaoUsuario(int $usuarioId): ?string {
            $sql = "
                SELECT posicao FROM (
                    SELECT 
                        id_usuario,
                        @pos := @pos + 1 AS posicao
                    FROM ponto, (SELECT @pos := 0) AS init
                    ORDER BY pontuacao DESC, id_usuario ASC
                ) AS ranking
                WHERE id_usuario = :id_usuario
                LIMIT 1
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id_usuario', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $posicao = $resultado ? $resultado['posicao'] : null;

            return ($posicao == 1
                ? "<div style=\"display: flex; justify-content: center\"><div class=\"trofeu\"></div>$posicao"."º</div>"
                : $posicao);
        }
        function obterRanking(int $usuarioId) {
            // 1. Primeiro, descubra a posição do usuário
            $sqlPosicao = "
                SELECT posicao FROM (
                    SELECT 
                        id_usuario,
                        @pos := @pos + 1 AS posicao
                    FROM ponto, (SELECT @pos := 0) AS init
                    ORDER BY pontuacao DESC, id_usuario ASC
                ) AS ranking
                WHERE id_usuario = :usuarioId
            ";
            $stmtPos = $this->pdo->prepare($sqlPosicao);
            $stmtPos->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmtPos->execute();
            $linha = $stmtPos->fetch();
            
            if (!$linha) return ""; // Usuário não tem pontuação ainda

            $posicao = (int) $linha['posicao'];
            $min = $posicao - 2;
            $max = $posicao + 2;

            // 2. Agora pega os usuários entre as posições
            $sqlRanking = "
                SELECT posicao, nome, pontuacao FROM (
                    SELECT 
                        p.id_usuario,
                        u.nome,
                        p.pontuacao,
                        @pos := @pos + 1 AS posicao
                    FROM ponto p
                    JOIN usuario u ON p.id_usuario = u.id,
                    (SELECT @pos := 0) AS init
                    ORDER BY p.pontuacao DESC, p.id_usuario ASC
                ) AS ranking
                WHERE posicao BETWEEN :min AND :max
            ";

            $stmt = $this->pdo->prepare($sqlRanking);
            $stmt->bindValue(':min', $min, PDO::PARAM_INT);
            $stmt->bindValue(':max', $max, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetchAll();

            // Geração HTML
            $registros = "";
            foreach ($resultado as $item) {
                $trofeu = ($item['posicao'] == 1) ? 
                    "<div style=\"display: flex; justify-content: center\"><div class=\"trofeu\"></div>{$item['posicao']}º</div>" : 
                    "{$item['posicao']}º";

                $registros .= "<tr>
                    <td>{$trofeu}</td>
                    <td>{$item['nome']}</td>
                    <td>{$item['pontuacao']}</td>
                </tr>";
            }

            return $registros;
        }
        public function obterPontuacoes($page, $userId = null) {
            if($page) {
                $limit = 10;
                $offset = ($page - 1) * $limit;
                $sql = "SELECT usuario.nome, id_usuario, pontuacao, @pos := @pos + 1 AS posicao FROM ponto INNER JOIN usuario ON usuario.id = id_usuario, (SELECT @pos := 0) AS init " . (isset($userId) ? "WHERE id_usuario = " . $_SESSION['usuario_id'] : "") ." ORDER BY pontuacao DESC, nome LIMIT $offset, $limit";
                $points = $this->pdo->query($sql)->fetchAll();
                $posicao = $offset;
                $posicao++;
                if($userId) {
                    $result = $this->obterPosicaoUsuario($userId);
                    $points[0]['posicao'] = $result;
                } else {
                    foreach($points as $key => $point) {
                        $points[$key]['posicao'] = ($posicao == 1 ? "<div style=\"display: flex; justify-content: center\"><div class=\"trofeu\"></div>" : "<div style=\"display: flex; justify-content: center\">") . $posicao . "º</div>";
                        $posicao++;
                    }
                }
                return $points;
            }
        }
        public function obterPaginacao($page) {
            $sql = "SELECT COUNT(id_usuario) as total FROM ponto";
            $paginas = $this->pdo->query($sql)->fetch()['total'] / 10; 
            $paginacao = '<li class="page-item"><a class="page-link" href="#">Anterior</a></li>';
            for($i=1; $i < $paginas + 1; $i++) {
                $paginacao .= "<li class=\"page-item\"><a class=\"page-link\" href=\"#\">$i</a></li>";
            }
            $paginacao .= '<li class="page-item"><a class="page-link" href="#">Próximo</a></li>';
            return array('paginacao' => $paginacao, 'paginas' => $paginas);
        }
    }