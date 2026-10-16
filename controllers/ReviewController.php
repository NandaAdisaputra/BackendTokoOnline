
<?php
require_once __DIR__ . '/../models/Review.php';

class ReviewController {
    private $reviewModel;

    public function __construct($db) {
        $this->reviewModel = new Review($db);
    }

    // Menambahkan ulasan produk
    public function create() {
        header("Content-Type: application/json; charset=UTF-8");

        $order_id = trim($_POST['order_id'] ?? '');
        $user_id = trim($_POST['user_id'] ?? '');
        $product_id = trim($_POST['product_id'] ?? '');
        $rating = $_POST['rating'] ?? '';
        $comment = trim($_POST['comment'] ?? '');
        $tags = trim($_POST['tags'] ?? '');

        // Validasi data wajib
        if (
            $order_id === '' ||
            $user_id === '' ||
            $product_id === '' ||
            $rating === ''
        ) {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "order_id, user_id, product_id, dan rating wajib diisi."
            ], JSON_PRETTY_PRINT);
            return;
        }

        // Validasi rating 1 sampai 5
        if (!is_numeric($rating) || (int) $rating < 1 || (int) $rating > 5) {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "Rating harus berupa angka dari 1 sampai 5."
            ], JSON_PRETTY_PRINT);
            return;
        }

        $data = [
            'order_id' => $order_id,
            'user_id' => $user_id,
            'product_id' => $product_id,
            'rating' => (int) $rating,
            'comment' => $comment,
            'tags' => $tags
        ];

        try {
            if ($this->reviewModel->create($data)) {
                http_response_code(201);
                echo json_encode([
                    "status" => true,
                    "message" => "Ulasan berhasil dikirim.",
                    "data" => $data
                ], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode([
                    "status" => false,
                    "message" => "Gagal menyimpan ulasan ke database."
                ], JSON_PRETTY_PRINT);
            }
        } catch (Throwable $e) {
            error_log("Review create error: " . $e->getMessage());

            http_response_code(500);
            echo json_encode([
                "status" => false,
                "message" => "Terjadi kesalahan saat memproses ulasan."
            ], JSON_PRETTY_PRINT);
        }
    }
}
?>
