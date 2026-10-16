<?php
class Review {
    private $conn;
    private $table_name = "reviews";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (order_id, user_id, product_id, rating, comment, tags) 
                  VALUES (:order_id, :user_id, :product_id, :rating, :comment, :tags)";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            'order_id' => $data['order_id'],
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'tags' => $data['tags']
        ]);
    }
}
?>