<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $no_tlp;
    public $avatar;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function isExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE (username = :username OR email = :email) AND id != :id";
        $stmt = $this->conn->prepare($query);
        // Cek duplikasi kecuali untuk user itu sendiri
        return false; 
    }

    public function findById($id) {
        $query = "SELECT id, username, email, no_tlp, avatar, created_at FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi Update Profil (Nickname & Avatar)
    public function updateProfileWithAvatar($id, $username, $avatarPath = null) {
        if ($avatarPath) {
            $query = "UPDATE " . $this->table_name . " SET username = :username, avatar = :avatar WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'username' => $username,
                'avatar' => $avatarPath,
                'id' => $id
            ]);
        } else {
            $query = "UPDATE " . $this->table_name . " SET username = :username WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'username' => $username,
                'id' => $id
            ]);
        }
    }
}
?>