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
        public function obterRanking(int $usuarioId) {
            try {
                // 1) Posição do usuário (query segura: subselect ordenado + contador)
                $sqlPosicao = "
                    SELECT posicao FROM (
                        SELECT
                            p.id_usuario,
                            @pos := @pos + 1 AS posicao
                        FROM (
                            SELECT id_usuario
                            FROM ponto
                            ORDER BY pontuacao DESC, id_usuario ASC
                        ) AS p
                        CROSS JOIN (SELECT @pos := 0) AS init
                    ) AS r
                    WHERE id_usuario = :usuarioId
                    LIMIT 1
                ";

                $stmtPos = $this->pdo->prepare($sqlPosicao);
                $stmtPos->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
                $stmtPos->execute();
                $linha = $stmtPos->fetch(PDO::FETCH_ASSOC);

                if (!$linha) {
                    // usuário sem pontuação
                    return "";
                }

                $posicao = (int) $linha['posicao'];
                $min = max(1, $posicao - 2);
                $max = $posicao + 2;

                // 2) Tenta buscar a janela de ranking usando a mesma técnica segura
                $sqlRanking = "
                    SELECT posicao, nome, pontuacao FROM (
                        SELECT
                            @r := @r + 1 AS posicao,
                            u.nome,
                            p.pontuacao
                        FROM (
                            SELECT id_usuario, pontuacao
                            FROM ponto
                            ORDER BY pontuacao DESC, id_usuario ASC
                        ) AS p
                        JOIN usuario u ON u.id = p.id_usuario
                        CROSS JOIN (SELECT @r := 0) AS init
                    ) AS ranking
                    WHERE posicao BETWEEN :min AND :max
                    ORDER BY posicao ASC
                ";

                $stmt = $this->pdo->prepare($sqlRanking);
                $stmt->bindValue(':min', $min, PDO::PARAM_INT);
                $stmt->bindValue(':max', $max, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 3) Validação: garantir que pontuações vieram ordenadas numericamente desc.
                $isOrdered = true;
                $last = PHP_INT_MAX;
                foreach ($resultado as $row) {
                    // força int para comparação numérica
                    $cur = (int) $row['pontuacao'];
                    if ($cur > $last) { // se algum atual for maior que o anterior -> não está decrescente
                        $isOrdered = false;
                        break;
                    }
                    $last = $cur;
                }

                // 4) Se estiver tudo ok com a ordernação, monta HTML e retorna
                if ($isOrdered && count($resultado) > 0) {
                    return $this->montarHtmlRanking($resultado);
                }

                // 5) --- Fallback: se a query ainda retornou ordem estranha, calcula em PHP ---
                // Carrega tudo (id, nome, pontuacao), ordena numericamente em PHP e monta janela
                $sqlAll = "
                    SELECT p.id_usuario, u.nome, p.pontuacao
                    FROM ponto p
                    JOIN usuario u ON u.id = p.id_usuario
                ";
                $stmtAll = $this->pdo->prepare($sqlAll);
                $stmtAll->execute();
                $all = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

                if (!$all) return "";

                // Ordena em PHP por pontuacao numericamente desc, tie-break por id_usuario asc
                usort($all, function($a, $b) {
                    $pa = (int)$a['pontuacao'];
                    $pb = (int)$b['pontuacao'];
                    if ($pa === $pb) {
                        // tie-breaker em id (ou nome) para estabilidade
                        return ((int)$a['id_usuario']) <=> ((int)$b['id_usuario']);
                    }
                    return $pb <=> $pa;
                });

                // Atribui posições e encontra janela
                $indexed = [];
                $idx = 0;
                foreach ($all as $row) {
                    $idx++;
                    $indexed[] = [
                        'posicao' => $idx,
                        'id_usuario' => $row['id_usuario'],
                        'nome' => $row['nome'],
                        'pontuacao' => $row['pontuacao']
                    ];
                }

                // encontra a posição real do usuario (caso tenha mudado no entretempo)
                $realPos = null;
                foreach ($indexed as $r) {
                    if ((int)$r['id_usuario'] === (int)$usuarioId) {
                        $realPos = (int)$r['posicao'];
                        break;
                    }
                }
                if ($realPos === null) return ""; // não encontrado (sem pontuação)

                $min = max(1, $realPos - 2);
                $max = $realPos + 2;

                // filtra a janela
                $window = array_filter($indexed, function($r) use ($min, $max) {
                    return $r['posicao'] >= $min && $r['posicao'] <= $max;
                });

                // normaliza (ordenado por posicao asc)
                usort($window, function($a, $b) {
                    return $a['posicao'] <=> $b['posicao'];
                });

                // transforma para o mesmo formato da query original (posicao,nome,pontuacao)
                $resultadoFallback = array_map(function($r) {
                    return [
                        'posicao' => $r['posicao'],
                        'nome' => $r['nome'],
                        'pontuacao' => $r['pontuacao']
                    ];
                }, $window);

                return $this->montarHtmlRanking($resultadoFallback);

            } catch (\Throwable $e) {
                // Em caso de erro qualquer, retorne string vazia (ou logue o erro conforme sua política)
                error_log("obterRanking error: " . $e->getMessage());
                return "";
            }
        }

        /**
         * Monta HTML a partir do array de resultado (posicao, nome, pontuacao)
         */
        private function montarHtmlRanking(array $rows): string {
            $html = "";
            foreach ($rows as $item) {
                $pos = (int)$item['posicao'];
                $trofeu = ($pos === 1)
                    ? "<div style='display:flex; justify-content:center'><div class='trofeu'></div>{$pos}º</div>"
                    : "{$pos}º";

                $nome = htmlspecialchars($item['nome'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $pont = htmlspecialchars((string)$item['pontuacao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

                $html .= "
                    <tr>
                        <td>{$trofeu}</td>
                        <td>{$nome}</td>
                        <td>{$pont}</td>
                    </tr>
                ";
            }
            return $html;
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