<?php
require_once __DIR__ . '/../config/Database.php';

class MessageModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT * FROM messages ORDER BY created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM messages WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $subject, $message) {
        $stmt = $this->conn->prepare("
            INSERT INTO messages (name, email, subject, message)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $email, $subject, $message]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("
            DELETE FROM messages WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
?>
