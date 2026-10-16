<?php
require_once __DIR__ . '/../models/Notification.php';

class NotificationController {
    private $notifModel;

    public function __construct($db) {
        $this->notifModel = new Notification($db);
    }

    public function list() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        if (!empty($user_id)) {
            $notifications = $this->notifModel->getByUser($user_id);
            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat daftar notifikasi",
                "data" => $notifications
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id wajib diisi."]);
        }
    }
}
?>