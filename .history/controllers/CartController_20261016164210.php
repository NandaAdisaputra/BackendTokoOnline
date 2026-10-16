<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;

    public function __construct($db) {
        $this->cartModel = new Cart($db);
    }

    // Menambahkan produk ke keranjang
    public function add() {
        header("Content-Type: application/json; charset=UTF-8");

        $user_id = $_POST['user_id'] ?? '';
        $product_id = $_POST['product_id'] ?? '';
        $quantity = isset($_POST['quantity'])
            ? (int) $_POST['quantity']
            : 1;
        $notes = trim($_POST['notes'] ?? '');

        if ($user_id === '' || $product_id === '') {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "user_id dan product_id wajib diisi."
            ], JSON_PRETTY_PRINT);
            return;
        }

        if ($quantity < 1) {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "Quantity minimal 1."
            ], JSON_PRETTY_PRINT);
            return;
        }

        $success = $this->cartModel->addToCart(
            $user_id,
            $product_id,
            $quantity,
            $notes
        );

        if (!$success) {
            http_response_code(500);
            echo json_encode([
                "status" => false,
                "message" => "Gagal menambahkan produk ke keranjang."
            ], JSON_PRETTY_PRINT);
            return;
        }

        // Ambil data keranjang terbaru
        $items = $this->cartModel->getCartByUser($user_id);
        $addedItem = null;

        foreach ($items as $item) {
            if ((string) $item['product_id'] === (string) $product_id) {
                $addedItem = $item;
                break;
            }
        }

        if ($addedItem === null) {
            http_response_code(500);
            echo json_encode([
                "status" => false,
                "message" => "Data keranjang gagal ditemukan."
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(201);
        echo json_encode([
            "status" => true,
            "message" => "Produk berhasil ditambahkan ke keranjang.",
            "data" => $addedItem
        ], JSON_PRETTY_PRINT);
    }

    // Menampilkan daftar keranjang pengguna
    public function getList() {
        header("Content-Type: application/json; charset=UTF-8");

        $user_id = $_POST['user_id'] ?? '';

        if ($user_id === '') {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "user_id wajib diisi."
            ], JSON_PRETTY_PRINT);
            return;
        }

        $items = $this->cartModel->getCartByUser($user_id);
        $total_amount = 0;

        foreach ($items as $item) {
            $total_amount += (float) $item['subtotal'];
        }

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat data keranjang.",
            "data" => [
                "items" => $items,
                "total_amount" => $total_amount
            ]
        ], JSON_PRETTY_PRINT);
    }

    // Memperbarui kuantitas atau menghapus produk
    public function updateQty() {
        header("Content-Type: application/json; charset=UTF-8");

        $cart_id = $_POST['cart_id'] ?? '';

        if ($cart_id === '') {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "cart_id wajib diisi."
            ], JSON_PRETTY_PRINT);
            return;
        }

        if (!isset($_POST['quantity']) || $_POST['quantity'] === '') {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "quantity wajib diisi."
            ], JSON_PRETTY_PRINT);
            return;
        }

        $quantity = (int) $_POST['quantity'];

        $success = $this->cartModel->updateQuantity(
            $cart_id,
            $quantity
        );

        if (!$success) {
            http_response_code(500);
            echo json_encode([
                "status" => false,
                "message" => "Gagal memperbarui keranjang."
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => $quantity <= 0
                ? "Produk berhasil dihapus dari keranjang."
                : "Kuantitas keranjang berhasil diperbarui."
        ], JSON_PRETTY_PRINT);
    }
}
?>