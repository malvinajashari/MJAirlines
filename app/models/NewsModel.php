<?php
require_once __DIR__ . '/../config/Database.php';

class NewsModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT * FROM news ORDER BY created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM news WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $content) {
        $stmt = $this->conn->prepare("
            INSERT INTO news (title, content)
            VALUES (?, ?)
        ");
        return $stmt->execute([$title, $content]);
    }

    public function update($id, $title, $content) {
        $stmt = $this->conn->prepare("
            UPDATE news
            SET title = ?, content = ?
            WHERE id = ?
        ");
        return $stmt->execute([$title, $content, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("
            DELETE FROM news WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
?>
