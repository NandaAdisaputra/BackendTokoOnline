<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;

    public function __construct($db) {
        $this->cartModel = new Cart($db);
    }

    public function add() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

        if (!empty($user_id) && !empty($product_id)) {
            if ($this->cartModel->addToCart($user_id, $product_id, $quantity)) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Produk berhasil ditambahkan ke keranjang."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menambahkan ke keranjang."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id dan product_id wajib diisi."]);
        }
    }

    public function getList() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        if (!empty($user_id)) {
            $items = $this->cartModel->getCartByUser($user_id);
            
            // Hitung total harga keseluruhan dalam keranjang
            $total_amount = 0;
            foreach ($items as $item) {
                $total_amount += $item['subtotal'];
            }

            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat data keranjang",
                "data" => [
                    "items" => $items,
                    "total_amount" => $total_amount
                ]
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id wajib diisi."]);
        }
 
        }
        public function updateQty() {
    $cart_id = isset($_POST['cart_id']) ? $_POST['cart_id'] : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if (!empty($cart_id)) {
        if ($this->cartModel->updateQuantity($cart_id, $quantity)) {
            http_response_code(200);
            echo json_encode(["status" => true, "message" => "Kuantitas keranjang diperbarui."]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => false, "message" => "Gagal memperbarui kuantitas."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => false, "message" => "cart_id wajib diisi."]);
    }
}
}
?>