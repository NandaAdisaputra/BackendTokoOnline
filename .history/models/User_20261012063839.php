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

    // Perbaikan: Implementasi pengecekan duplikasi username atau email
    public function isExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username OR email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'username' => $this->username,
            'email' => $this->email
        ]);
        return $stmt->rowCount() > 0;
    }

    // Penambahan: Method create untuk menyimpan user baru dan hashing password
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password, no_tlp) 
                  VALUES (:username, :email, :password, :no_tlp)";
        $stmt = $this->conn->prepare($query);

        // Hash password agar aman
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        return $stmt->execute([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $hashed_password,
            'no_tlp' => $this->no_tlp
        ]);
    }

    // Penambahan: Method untuk mencari user berdasarkan username atau email saat login
    public function findByUsernameOrEmail($usernameOrEmail) {
        $query = "SELECT id, username, email, password, no_tlp, avatar, created_at 
                  FROM " . $this->table_name . " 
                  WHERE username = :value OR email = :value 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['value' => $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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