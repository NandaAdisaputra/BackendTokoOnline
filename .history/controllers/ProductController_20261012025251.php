<?php
class ProductController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat data menu",
            "data" => $products
        ]);
    }

    public function getBestSellers() {
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_best_seller = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat produk Best Seller",
            "data" => $products
        ]);
    }
}
?>