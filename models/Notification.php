<?php
class Notification {
    private $conn;
    private $table_name = "notifications";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByUser($user_id) {
        $query = "SELECT id, message, created_at FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>