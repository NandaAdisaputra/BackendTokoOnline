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
                        "avatar" => $user['avatar'] ? 'http://localhost/backend_toko_online/' . $user['avatar'] : null,
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
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        
        $avatarPath = null;

        if (!empty($user_id) && !empty($username)) {
            // Handle upload file foto profil baru (Ganti Profil)
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileName = $_FILES['avatar']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'avatar_' . $user_id . '_' . time() . '.' . $fileExtension;
                    $uploadFileDir = __DIR__ . '/../uploads/avatars/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        $avatarPath = 'uploads/avatars/' . $newFileName;
                    }
                }
            }

            if ($this->userModel->updateProfileWithAvatar($user_id, $username, $avatarPath)) {
                http_response_code(200);
                echo json_encode([
                    "status" => true, 
                    "message" => "Profil berhasil diperbarui.",
                    "new_avatar" => $avatarPath ? 'http://localhost/backend_toko_online/' . $avatarPath : null
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memperbarui profil."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id dan username (nickname) wajib diisi."]);
        }
    }
}
?>