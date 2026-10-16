<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function profile() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        if (!empty($user_id)) {
            $user = $this->userModel->findById($user_id);
            if ($user) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Berhasil memuat profil",
                    "data" => [
                        "id" => $user['id'],
                        "username" => $user['username'],
                        "email" => $user['email'],
                        "no_tlp" => $user['no_tlp'],
                        "role" => "User"
                    ]
                ]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "User tidak ditemukan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id wajib diisi."]);
        }
    }

    public function update() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $no_tlp = isset($_POST['no_tlp']) ? $_POST['no_tlp'] : '';

        if (!empty($user_id) && !empty($username) && !empty($email)) {
            if ($this->userModel->updateProfile($user_id, $username, $email, $no_tlp)) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Profil berhasil diperbarui."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memperbarui profil."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data wajib tidak lengkap."]);
        }
    }
}
?>