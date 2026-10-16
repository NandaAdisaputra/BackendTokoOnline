<?php
class AdminProfileController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get() {
        $admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : 1;

        $stmt = $this->conn->prepare("SELECT id, username, nickname, avatar FROM admins WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat profil admin",
                "data" => [
                    "id" => $admin['id'],
                    "username" => $admin['username'],
                    "nickname" => $admin['nickname'],
                    "role" => "Administrator",
                    "avatar" => $admin['avatar'] ? 'http://localhost/backend_toko_online/' . $admin['avatar'] : null
                ]
            ]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => false, "message" => "Admin tidak ditemukan."]);
        }
    }

    public function update() {
        $admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : 1;
        $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';

        if (!empty($nickname)) {
            $stmt = $this->conn->prepare("UPDATE admins SET nickname = :nickname WHERE id = :id");
            if ($stmt->execute(['nickname' => $nickname, 'id' => $admin_id])) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Profil admin berhasil diperbarui."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memperbarui profil."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Nickname wajib diisi."]);
        }
    }
}
?>