<?php
require_once __DIR__ . '/../models/Review.php';

class ReviewController {
    private $reviewModel;

    public function __construct($db) {
        $this->reviewModel = new Review($db);
    }

    public function create() {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
        $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
        $tags = isset($_POST['tags']) ? $_POST['tags'] : ''; // Contoh: "Rasa,Porsi"

        if (!empty($order_id) && !empty($user_id) && !empty($product_id) && !empty($rating)) {
            $data = [
                'order_id' => $order_id,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'rating' => $rating,
                'comment' => $comment,
                'tags' => $tags
            ];

            if ($this->reviewModel->create($data)) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Ulasan berhasil dikirim."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal mengirim ulasan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data tidak lengkap (order_id, user_id, product_id, rating wajib diisi)."]);
        }
    }
}
?>