<?php
class Favorite {
    private $conn;
    private $table_name = "favorites";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($user_id, $product_id) {
        $check = "SELECT id FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($check);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        
        if ($stmt->rowCount() > 0) {
            return true; // Sudah ada di favorit
        }

        $query = "INSERT INTO " . $this->table_name . " (user_id, product_id) VALUES (:user_id, :product_id)";
        $insert = $this->conn->prepare($query);
        return $insert->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    public function remove($user_id, $product_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    public function getByUser($user_id, $category_filter = null) {
        $query = "SELECT f.id as favorite_id, p.id as product_id, p.name, p.price, p.image, p.is_best_seller, p.is_available, c.name as category_name 
                  FROM " . $this->table_name . " f
                  JOIN products p ON f.product_id = p.id
                  JOIN categories c ON p.category_id = c.id
                  WHERE f.user_id = :user_id";
        
        if (!empty($category_filter) && strtolower($category_filter) !== 'semua') {
            $query .= " AND c.name = :category_name";
        }

        $stmt = $this->conn->prepare($query);
        if (!empty($category_filter) && strtolower($category_filter) !== 'semua') {
            $stmt->execute(['user_id' => $user_id, 'category_name' => $category_filter]);
        } else {
            $stmt->execute(['user_id' => $user_id]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>