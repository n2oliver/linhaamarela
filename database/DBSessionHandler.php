<?php
class DBSessionHandler implements SessionHandlerInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {   // Testa se a pasta padrão está funcional (local vs servidor)
        if (!is_writable(session_save_path())) {
            session_save_path(__DIR__ . '/sessao-temp'); // só se local estiver quebrado
            if (!is_dir(__DIR__ . '/sessao-temp')) {
                mkdir(__DIR__ . '/sessao-temp', 0700, true);
            }
        }
        $this->pdo = $pdo;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT data FROM sessions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['data'];
        }
        return '';
    }

    public function write($id, $data) {
        $timestamp = time();
        $stmt = $this->pdo->prepare("
            REPLACE INTO sessions (id, data, timestamp)
            VALUES (:id, :data, :timestamp)
        ");
        return $stmt->execute([
            'id' => $id,
            'data' => $data,
            'timestamp' => $timestamp
        ]);
    }

    public function destroy($id) {
        $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function gc($maxLifetime) {
        $old = time() - $maxLifetime;
        $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE timestamp < :old");
        return $stmt->execute(['old' => $old]);
    }
}
