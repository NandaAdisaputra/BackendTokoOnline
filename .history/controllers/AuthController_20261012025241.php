<?php
class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->email) && !empty($data->password) && !empty($data->no_tlp)) {
            // Cek duplikasi username/email
            $query = "SELECT id FROM users WHERE username = :username OR email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['username' => $data->username, 'email' => $data->email]);

            if ($stmt->rowCount() > 0) {
                http_response_code(400);
                echo json_encode(["status" => false, "message" => "Username atau Email sudah terdaftar."]);
                return;
            }

            // Insert user baru
            $query = "INSERT INTO users (username, email, password, no_tlp) VALUES (:username, :email, :password, :no_tlp)";
            $stmt = $this->conn->prepare($query);
            
            $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);

            if ($stmt->execute([
                'username' => $data->username,
                'email' => $data->email,
                'password' => $hashedPassword,
                'no_tlp' => $data->no_tlp
            ])) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Registrasi berhasil."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal melakukan registrasi."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data tidak lengkap (username, email, password, no_tlp wajib diisi)."]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->password)) {
            $query = "SELECT * FROM users WHERE username = :username OR email = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['username' => $data->username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data->password, $user['password'])) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Login berhasil.",
                    "data" => [
                        "id" => $user['id'],
                        "username" => $user['username'],
                        "email" => $user['email'],
                        "no_tlp" => $user['no_tlp']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["status" => false, "message" => "Username atau Password salah."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Username dan Password wajib diisi."]);
        }
    }
}
?>