<?php
class Order {
    private $conn;
    private $table_orders = "orders";
    private $table_items = "order_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi Checkout sebelumnya...
    public function createCheckout($data) { /* ... */ }

    // Mengambil Riwayat Pesanan Berdasarkan User
    public function getHistoryByUser($user_id) {
        $query = "SELECT o.id as order_id, o.total_amount, o.status, o.created_at, 
                         (SELECT GROUP_CONCAT(CONCAT(p.name, ' x', oi.quantity) SEPARATOR ', ') 
                          FROM " . $this->table_items . " oi 
                          JOIN products p ON oi.product_id = p.id 
                          WHERE oi.order_id = o.id) as items_summary
                  FROM " . $this->table_orders . " o
                  WHERE o.user_id = :user_id
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil Detail Pesanan & Pelacakan Status
    public function getDetailById($order_id) {
        $queryOrder = "SELECT * FROM " . $this->table_orders . " WHERE id = :order_id LIMIT 1";
        $stmtOrder = $this->conn->prepare($queryOrder);
        $stmtOrder->execute(['order_id' => $order_id]);
        $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

        if (!$order) return null;

        $queryItems = "SELECT oi.product_id, oi.quantity, oi.price, oi.subtotal, p.name as product_name, p.image 
                       FROM " . $this->table_items . " oi 
                       JOIN products p ON oi.product_id = p.id 
                       WHERE oi.order_id = :order_id";
        $stmtItems = $this->conn->prepare($queryItems);
        $stmtItems->execute(['order_id' => $order_id]);
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return [
            "order_no" => "Antrian 2024" . str_pad($order['id'], 4, '0', STR_PAD_LEFT),
            "status" => $order['status'], // Diproses, Siap, Selesai
            "created_at" => $order['created_at'],
            "order_type" => $order['order_type'],
            "dine_capacity" => $order['dine_capacity'],
            "notes" => $order['notes'],
            "payment" => [
                "method" => $order['payment_method'],
                "total_amount" => $order['total_amount']
            ],
            "items" => $items
        ];
    }
}
?>