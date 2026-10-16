<?php
class Cart {
    private $conn;
    private $table_name = "carts";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($user_id, $product_id, $quantity, $notes = null) {
        $query = "SELECT id, quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $newQty = $row['quantity'] + $quantity;
            $updateQuery = "UPDATE " . $this->table_name . " SET quantity = :quantity, notes = :notes WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            return $updateStmt->execute(['quantity' => $newQty, 'notes' => $notes, 'id' => $row['id']]);
        } else {
            $insertQuery = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity, notes) VALUES (:user_id, :product_id, :quantity, :notes)";
            $insertStmt = $this->conn->prepare($insertQuery);
            return $insertStmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity, 'notes' => $notes]);
        }
    }

    // Fungsi Update Qty (+ / -) di Keranjang (Screen 09)
    public function updateQuantity($cart_id, $quantity) {
        if ($quantity <= 0) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :cart_id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['cart_id' => $cart_id]);
        } else {
            $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE id = :cart_id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['quantity' => $quantity, 'cart_id' => $cart_id]);
        }
    }

    public function getCartByUser($user_id) {
        $query = "SELECT c.id as cart_id, p.id as product_id, p.name, p.price, p.image, c.quantity, c.notes, (p.price * c.quantity) as subtotal
                  FROM " . $this->table_name . " c
                  JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>