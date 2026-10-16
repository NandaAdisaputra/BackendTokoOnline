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
            $this->conn->beginTransaction();

            // Hitung sisa kekurangan pembayaran
            $total_amount = $data['total_amount'];
            $down_payment = isset($data['down_payment']) ? floatval($data['down_payment']) : 0.00;
            $remaining_amount = $total_amount - $down_payment;
            if ($remaining_amount < 0) $remaining_amount = 0.00;

            // 1. Simpan ke tabel orders dengan data lengkap pengambilan & pembayaran
            $queryOrder = "INSERT INTO " . $this->table_orders . " 
                           (user_id, order_type, dine_capacity, notes, payment_method, total_amount, 
                            pickup_time_type, pickup_time_value, pickup_location, account_name, down_payment, remaining_amount, status) 
                           VALUES 
                           (:user_id, :order_type, :dine_capacity, :notes, :payment_method, :total_amount, 
                            :pickup_time_type, :pickup_time_value, :pickup_location, :account_name, :down_payment, :remaining_amount, 'Diproses')";
            
            $stmtOrder = $this->conn->prepare($queryOrder);
            $stmtOrder->execute([
                'user_id' => $data['user_id'],
                'order_type' => $data['order_type'],
                'dine_capacity' => isset($data['dine_capacity']) ? $data['dine_capacity'] : null,
                'notes' => isset($data['notes']) ? $data['notes'] : null,
                'payment_method' => $data['payment_method'],
                'total_amount' => $total_amount,
                'pickup_time_type' => $data['pickup_time_type'],
                'pickup_time_value' => $data['pickup_time_value'],
                'pickup_location' => $data['pickup_location'],
                'account_name' => $data['account_name'],
                'down_payment' => $down_payment,
                'remaining_amount' => $remaining_amount
            ]);

            $order_id = $this->conn->lastInsertId();

            // 2. Simpan item produk ke order_items
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

            $this->conn->commit();
            return [
                "status" => true,
                "order_id" => $order_id,
                "remaining_amount" => $remaining_amount
            ];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function getReceiptById($order_id) {
        $query = "SELECT * FROM " . $this->table_orders . " WHERE id = :order_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['order_id' => $order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) return null;

        return [
            "message" => "Transaksi Anda Berhasil",
            "date" => date("d F Y", strtotime($order['created_at'])),
            "nomor_antrian" => "2024" . str_pad($order['id'], 4, '0', STR_PAD_LEFT),
            "metode_pembayaran" => $order['payment_method'],
            "atas_nama" => $order['account_name'],
            "uang_muka" => "Rp. " . number_format($order['down_payment'], 0, ',', '.'),
            "kekurangan" => "Rp. " . number_format($order['remaining_amount'], 0, ',', '.'),
            "total_bayar" => "Rp. " . number_format($order['total_amount'], 0, ',', '.'),
            "pengambilan" => [
                "tipe" => $order['pickup_time_type'],
                "waktu" => $order['pickup_time_value'] ?? 'Secepatnya (± 15 menit)',
                "lokasi" => $order['pickup_location']
            ]
        ];
    }
}
?>