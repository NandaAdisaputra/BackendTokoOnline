<?php
class Order {
    private $conn;
    private $table_orders = "orders";
    private $table_items = "order_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createCheckout($data) {
        try {
            // Mulai Database Transaction untuk keamanan data
            $this->conn->beginTransaction();

            // 1. Simpan ke tabel orders
            $queryOrder = "INSERT INTO " . $this->table_orders . " (user_id, order_type, dine_capacity, notes, payment_method, total_amount) 
                           VALUES (:user_id, :order_type, :dine_capacity, :notes, :payment_method, :total_amount)";
            
            $stmtOrder = $this->conn->prepare($queryOrder);
            $stmtOrder->execute([
                'user_id' => $data['user_id'],
                'order_type' => $data['order_type'],
                'dine_capacity' => isset($data['dine_capacity']) ? $data['dine_capacity'] : null,
                'notes' => isset($data['notes']) ? $data['notes'] : null,
                'payment_method' => $data['payment_method'],
                'total_amount' => $data['total_amount']
            ]);

            $order_id = $this->conn->lastInsertId();

            // 2. Simpan item produk yang dibeli ke tabel order_items
            // (Mendukung pembelian langsung 1 produk atau dari keranjang)
            $queryItem = "INSERT INTO " . $this->table_items . " (order_id, product_id, quantity, price, subtotal) 
                          VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
            $stmtItem = $this->conn->prepare($queryItem);
            
            foreach ($data['items'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $stmtItem->execute([
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal
                ]);
            }

            // Commit transaksi jika semua berhasil
            $this->conn->commit();
            return [
                "status" => true,
                "order_id" => $order_id
            ];

        } catch (Exception $e) {
            // Rollback jika terjadi error
            $this->conn->rollBack();
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}
?>