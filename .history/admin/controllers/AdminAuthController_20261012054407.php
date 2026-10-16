<?php
class AdminAuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!empty($username) && !empty($password)) {
            $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Login Admin Berhasil",
                    "data" => [
                        "id" => $admin['id'],
                        "username" => $admin['username'],
                        "nickname" => $admin['nickname'],
                        "avatar" => $admin['avatar'] ? 'http://localhost/backend_toko_online/' . $admin['avatar'] : null
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["status" => false, "message" => "Username atau Password Admin salah."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Username dan Password wajib diisi."]);
        }
    }
}
?>