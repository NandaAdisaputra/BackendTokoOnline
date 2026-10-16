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
        echo json_encode(["status" => true, "message" => "Berhasil memuat data menu", "data" => $products]);
    }

    public function getBestSellers() {
        $products = $this->productModel->getBestSellers();
        http_response_code(200);
        echo json_encode(["status" => true, "message" => "Berhasil memuat produk Best Seller", "data" => $products]);
    }

    public function search() {
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $products = $this->productModel->search($keyword);
        
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Hasil pencarian menu",
            "data" => $products
        ]);
    }

    public function create() {
        // kode create produk sebelumnya...
    }
}
?>