
<?php

class Review {
    private $conn;
    private $table_name = "reviews";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Menyimpan ulasan ke database
    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                      (order_id, user_id, product_id, rating, comment, tags)
                      VALUES
                      (:order_id, :user_id, :product_id, :rating, :comment, :tags)";

            $stmt = $this->conn->prepare($query);

            return $stmt->execute([
                ':order_id'   => $data['order_id'],
                ':user_id'    => $data['user_id'],
                ':product_id' => $data['product_id'],
                ':rating'     => (int) $data['rating'],
                ':comment'    => $data['comment'] ?? '',
                ':tags'       => $data['tags'] ?? ''
            ]);

        } catch (PDOException $e) {
            error_log("Review create error: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
