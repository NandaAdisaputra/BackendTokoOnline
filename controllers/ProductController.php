<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        // Ambil parameter page dan limit dari GET (Query Params) atau POST (Form-data)
        $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 10;

        // Inisialisasi Model Product
        $productModel = new Product($this->conn);

        // Panggil method getAll dengan pagination dari model
        $result = $productModel->getAll($page, $limit);

        // Format respons JSON dengan metadata pagination standar industri
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat daftar produk",
            "pagination" => $result["pagination"],
            "data" => $result["data"]
        ]);
    }
}
?>