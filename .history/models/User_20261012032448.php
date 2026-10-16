<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $no_tlp;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk memeriksa apakah username atau email sudah terdaftar
    public function isExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username OR email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'username' => $this->username,
            'email' => $this->email
        ]);
        return $stmt->rowCount() > 0;
    }

    // Fungsi untuk mendaftarkan user baru (Register)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password, no_tlp) VALUES (:username, :email, :password, :no_tlp)";
        $stmt = $this->conn->prepare($query);

        // Enskripsi password menggunakan Bcrypt
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $executed = $stmt->execute([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $hashedPassword,
            'no_tlp' => $this->no_tlp
        ]);

        return $executed;
    }

    // Fungsi untuk mencari user berdasarkan username atau email (untuk Login)
    public function findByUsernameOrEmail($identifier) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :identifier OR email = :identifier LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['identifier' => $identifier]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findById($id) {
    $query = "SELECT id, username, email, no_tlp, created_at FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateProfile($id, $username, $email, $no_tlp) {
    $query = "UPDATE " . $this->table_name . " SET username = :username, email = :email, no_tlp = :no_tlp WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        'username' => $username,
        'email' => $email,
        'no_tlp' => $no_tlp,
        'id' => $id
    ]);
}
}
?>