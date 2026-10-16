<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    public function getAll() {
        $products = $this->productModel->getAll();
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat data menu",
            "data" => $products
        ]);
    }

    public function getBestSellers() {
        $products = $this->productModel->getBestSellers();
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat produk Best Seller",
            "data" => $products
        ]);
    }
}
?>