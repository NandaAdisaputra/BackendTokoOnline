<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil seluruh daftar kategori untuk shortcut di Beranda (Screen 4)
    public function getAllCategories() {
        $query = "SELECT id, name, (SELECT image FROM products WHERE products.category_id = categories.id LIMIT 1) as sample_image 
                  FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>