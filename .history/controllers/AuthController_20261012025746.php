<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function register() {
        // Mengambil data dari form-data Postman ($_POST)
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $no_tlp = isset($_POST['no_tlp']) ? trim($_POST['no_tlp']) : '';

        if (!empty($username) && !empty($email) && !empty($password) && !empty($no_tlp)) {
            $this->userModel->username = $username;
            $this->userModel->email = $email;

            if ($this->userModel->isExists()) {
                http_response_code(400);
                echo json_encode(["status" => false, "message" => "Username atau Email sudah terdaftar."]);
                return;
            }

            $this->userModel->password = $password;
            $this->userModel->no_tlp = $no_tlp;

            if ($this->userModel->create()) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Registrasi berhasil."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal melakukan registrasi."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data tidak lengkap. Semua field wajib diisi."]);
        }
    }

    public function login() {
        // Mengambil data dari form-data Postman ($_POST)
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!empty($username) && !empty($password)) {
            $user = $this->userModel->findByUsernameOrEmail($username);

            if ($user && password_verify($password, $user['password'])) {
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