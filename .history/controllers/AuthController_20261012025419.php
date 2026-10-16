<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->email) && !empty($data->password) && !empty($data->no_tlp)) {
            $this->userModel->username = $data->username;
            $this->userModel->email = $data->email;

            if ($this->userModel->isExists()) {
                http_response_code(400);
                echo json_encode(["status" => false, "message" => "Username atau Email sudah terdaftar."]);
                return;
            }

            $this->userModel->password = $data->password;
            $this->userModel->no_tlp = $data->no_tlp;

            if ($this->userModel->create()) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Registrasi berhasil."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal melakukan registrasi."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data tidak lengkap."]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->password)) {
            $user = $this->userModel->findByUsernameOrEmail($data->username);

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