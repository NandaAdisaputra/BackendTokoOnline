<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct($db) {
        $this->categoryModel = new Category($db);
    }

    public function list() {
        $categories = $this->categoryModel->getAllCategories();
        
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat daftar kategori beranda",
            "data" => $categories
        ]);
    }
}
?>