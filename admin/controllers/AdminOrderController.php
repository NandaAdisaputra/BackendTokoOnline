<?php
class AdminOrderController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        $query = "SELECT o.*, u.username as customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode(["status" => true, "message" => "Berhasil memuat daftar pesanan admin", "data" => $orders]);
    }

    public function detail() {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

        if (!empty($order_id)) {
            $query = "SELECT o.*, u.username, u.no_tlp FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id' => $order_id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Pesanan tidak ditemukan."]);
                return;
            }

            $itemsStmt = $this->conn->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :id");
            $itemsStmt->execute(['id' => $order_id]);
            $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat detail pesanan",
                "data" => [
                    "order_no" => "Antrian 2024" . str_pad($order['id'], 4, '0', STR_PAD_LEFT),
                    "customer_name" => $order['username'],
                    "customer_phone" => $order['no_tlp'],
                    "pickup_info" => "Diambil pukul " . ($order['pickup_time_value'] ?? '12:30') . " di " . $order['pickup_location'],
                    "status" => $order['status'],
                    "notes" => $order['notes'],
                    "total_amount" => $order['total_amount'],
                    "items" => $items
                ]
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "order_id wajib diisi."]);
        }
    }

    public function updateStatus() {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : ''; // 'Diproses', 'Siap', 'Selesai'

        if (!empty($order_id) && !empty($status)) {
            $query = "UPDATE orders SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(['status' => $status, 'id' => $order_id])) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Status pesanan berhasil diperbarui menjadi " . $status]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal mengubah status pesanan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "order_id dan status wajib diisi."]);
        }
    }
}
?>