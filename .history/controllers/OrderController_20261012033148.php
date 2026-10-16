<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';


    public function history() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        if (!empty($user_id)) {
            $history = $this->orderModel->getHistoryByUser($user_id);
            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat riwayat pesanan",
                "data" => $history
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id wajib diisi."]);
        }
    }

    public function detail() {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

        if (!empty($order_id)) {
            $detail = $this->orderModel->getDetailById($order_id);

            if ($detail) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Berhasil memuat detail pesanan",
                    "data" => $detail
                ]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Pesanan tidak ditemukan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "order_id wajib diisi."]);
        }
    }
}

?>