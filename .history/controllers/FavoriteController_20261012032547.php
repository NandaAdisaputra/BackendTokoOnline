<?php
require_once __DIR__ . '/../models/Favorite.php';

class FavoriteController {
    private $favModel;

    public function __construct($db) {
        $this->favModel = new Favorite($db);
    }

    public function add() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (!empty($user_id) && !empty($product_id)) {
            if ($this->favModel->add($user_id, $product_id)) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Produk ditambahkan ke favorit."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menambahkan ke favorit."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id dan product_id wajib diisi."]);
        }
    }

    public function remove() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (!empty($user_id) && !empty($product_id)) {
            if ($this->favModel->remove($user_id, $product_id)) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Produk dihapus dari favorit."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menghapus dari favorit."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id dan product_id wajib diisi."]);
        }
    }

    public function list() {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $category = isset($_POST['category']) ? $_POST['category'] : 'Semua'; // Filter tab Semua, Makanan, Minuman

        if (!empty($user_id)) {
            $favorites = $this->favModel->getByUser($user_id, $category);
            http_response_code(200);
            echo json_encode([
                "status" => true,
                "message" => "Berhasil memuat daftar favorit",
                "total_menu" => count($favorites),
                "data" => $favorites
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "user_id wajib diisi."]);
        }
    }
}
?>