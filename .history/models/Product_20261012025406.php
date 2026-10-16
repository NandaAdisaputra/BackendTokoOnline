<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil seluruh produk beserta nama kategorinya (untuk halaman Menu Utama)
    public function getAll() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil produk khusus kategori Best Seller
    public function getBestSellers() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.is_best_seller = 1";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>