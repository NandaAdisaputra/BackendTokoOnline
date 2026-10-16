<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';

class OrderController {
    private $orderModel;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->orderModel = new Order($db);
    }

    public function checkout() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        // Parameter Pengambilan (Screen 10)
        $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : 'Diambil';
        $pickup_time_type = isset($_POST['pickup_time_type']) ? $_POST['pickup_time_type'] : 'Secepatnya';
        $pickup_time_value = isset($_POST['pickup_time_value']) ? $_POST['pickup_time_value'] : null;
        $pickup_location = isset($_POST['pickup_location']) ? $_POST['pickup_location'] : 'Resto Pusat - Pandanaran';
        
        // Parameter Pembayaran (Screen 11)
        $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'Gopay'; // DANA, Gopay, QRIS, dll
        $account_name = isset($_POST['account_name']) ? $_POST['account_name'] : '';
        $down_payment = isset($_POST['down_payment']) ? floatval($_POST['down_payment']) : 0.00;
        
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

        if (!empty($user_id) && !empty($product_id)) {
            // Ambil harga produk
            $query = "SELECT price FROM products WHERE id = :product_id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['product_id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Produk tidak ditemukan."]);
                return;
            }

            $price = $product['price'];
            $total_amount = $price * $quantity;

            $checkoutData = [
                'user_id' => $user_id,
                'order_type' => $order_type,
                'dine_capacity' => null,
                'notes' => $notes,
                'payment_method' => $payment_method,
                'total_amount' => $total_amount,
                'pickup_time_type' => $pickup_time_type,
                'pickup_time_value' => $pickup_time_value,
                'pickup_location' => $pickup_location,
                'account_name' => $account_name,
                'down_payment' => $down_payment,
                'items' => [
                    [
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'price' => $price
                    ]
                ]
            ];

            $result = $this->orderModel->createCheckout($checkoutData);

            if ($result['status']) {
                http_response_code(201);
                echo json_encode([
                    "status" => true,
                    "message" => "Transaksi Anda Berhasil",
                    "data" => [
                        "order_id" => $result['order_id'],
                        "nomor_antrian" => "2024" . str_pad($result['order_id'], 4, '0', STR_PAD_LEFT),
                        "metode_pembayaran" => $payment_method,
                        "atas_nama" => $account_name,
                        "uang_muka" => $down_payment,
                        "kekurangan" => $result['remaining_amount'],
                        "total_amount" => $total_amount
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memproses pesanan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id dan product_id wajib diisi."]);
        }
    }

    // Endpoint untuk menampilkan Struk (Screen 12)
    public function receipt() {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

        if (!empty($order_id)) {
            $receipt = $this->orderModel->getReceiptById($order_id);
            if ($receipt) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Berhasil memuat data struk",
                    "data" => $receipt
                ]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Struk pesanan tidak ditemukan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "order_id wajib diisi."]);
        }
    }
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