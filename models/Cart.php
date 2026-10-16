
<?php

class Cart {
    private $conn;
    private $table_name = "carts";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Menambahkan produk ke keranjang
    public function addToCart($user_id, $product_id, $quantity, $notes = '') {
        try {
            // Periksa apakah produk sudah ada di keranjang pengguna
            $query = "SELECT id, quantity
                      FROM " . $this->table_name . "
                      WHERE user_id = :user_id
                      AND product_id = :product_id
                      LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':user_id' => $user_id,
                ':product_id' => $product_id
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Jika sudah ada, tambahkan kuantitas dan perbarui notes
                $newQty = (int) $row['quantity'] + (int) $quantity;

                $updateQuery = "UPDATE " . $this->table_name . "
                                SET quantity = :quantity,
                                    notes = :notes
                                WHERE id = :id";

                $updateStmt = $this->conn->prepare($updateQuery);

                return $updateStmt->execute([
                    ':quantity' => $newQty,
                    ':notes' => $notes,
                    ':id' => $row['id']
                ]);
            }

            // Jika belum ada, buat data keranjang baru
            $insertQuery = "INSERT INTO " . $this->table_name . "
                            (user_id, product_id, quantity, notes)
                            VALUES
                            (:user_id, :product_id, :quantity, :notes)";

            $insertStmt = $this->conn->prepare($insertQuery);

            return $insertStmt->execute([
                ':user_id' => $user_id,
                ':product_id' => $product_id,
                ':quantity' => $quantity,
                ':notes' => $notes
            ]);

        } catch (PDOException $e) {
            error_log("Cart addToCart error: " . $e->getMessage());
            return false;
        }
    }

    // Mengambil seluruh produk dalam keranjang pengguna
    public function getCartByUser($user_id) {
        $query = "SELECT
                    c.id AS cart_id,
                    p.id AS product_id,
                    p.name,
                    p.price,
                    p.image,
                    c.quantity,
                    c.notes,
                    (p.price * c.quantity) AS subtotal
                  FROM " . $this->table_name . " c
                  INNER JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id
                  ORDER BY c.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memperbarui kuantitas atau menghapus produk
    public function updateQuantity($cart_id, $quantity) {
        try {
            if ($quantity <= 0) {
                $query = "DELETE FROM " . $this->table_name . "
                          WHERE id = :cart_id";

                $stmt = $this->conn->prepare($query);

                return $stmt->execute([
                    ':cart_id' => $cart_id
                ]);
            }

            $query = "UPDATE " . $this->table_name . "
                      SET quantity = :quantity
                      WHERE id = :cart_id";

            $stmt = $this->conn->prepare($query);

            return $stmt->execute([
                ':quantity' => $quantity,
                ':cart_id' => $cart_id
            ]);

        } catch (PDOException $e) {
            error_log("Cart updateQuantity error: " . $e->getMessage());
            return false;
        }
    }
}
?>
