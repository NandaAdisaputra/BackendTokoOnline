<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestSellers() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.is_best_seller = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengambil menu Harga Terjangkau (contoh: harga <= 10000)
    public function getAffordableProducts() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.price <= 10000 
                  ORDER BY p.price ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.name LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (category_id, name, price, image, is_best_seller) 
                  VALUES (:category_id, :name, :price, :image, :is_best_seller)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image,
            'is_best_seller' => $this->is_best_seller
        ]);
    }
}
?>