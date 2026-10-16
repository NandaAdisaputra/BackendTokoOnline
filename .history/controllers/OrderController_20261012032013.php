<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';

class OrderController {
    private $orderModel;
    private $productModel;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->orderModel = new Order($db);
        $this->productModel = new Product($db);
    }

    public function checkout() {
        // Mengambil data dari Postman form-data ($_POST)
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : ''; // 'Diambil' atau 'Makan Di Tempat'
        $dine_capacity = isset($_POST['dine_capacity']) ? $_POST['dine_capacity'] : null; // '1 Orang', '2-4 Orang', '4++ Orang'
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

        if (!empty($user_id) && !empty($product_id) && !empty($order_type) && !empty($payment_method)) {
            
            // Ambil informasi harga produk dari database
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
                'dine_capacity' => $dine_capacity,
                'notes' => $notes,
                'payment_method' => $payment_method,
                'total_amount' => $total_amount,
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
                    "message" => "Pesanan berhasil dibuat (Checkout sukses).",
                    "data" => [
                        "order_id" => $result['order_id'],
                        "total_amount" => $total_amount,
                        "payment_method" => $payment_method
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memproses pesanan: " . $result['message']]);
            }

        } else {
            http_response_code(400);
            echo json_encode([
                "status" => false, 
                "message" => "Data tidak lengkap. user_id, product_id, order_type, dan payment_method wajib diisi."
            ]);
        }
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
?>