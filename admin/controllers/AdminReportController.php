<?php
class AdminReportController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function summary() {
        // Total Pesanan & Pendapatan
        $stmt = $this->conn->query("SELECT COUNT(*) as total_pesanan, SUM(total_amount) as total_pendapatan FROM orders");
        $summary = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalPesanan = $summary['total_pesanan'] ?? 0;
        $totalPendapatan = $summary['total_pendapatan'] ?? 0;
        $rataRata = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Menu Terlaris
        $topMenuQuery = "SELECT p.name, SUM(oi.quantity) as total_terjual, (SUM(oi.quantity) * p.price) as total_pendapatan_menu 
                         FROM order_items oi 
                         JOIN products p ON oi.product_id = p.id 
                         GROUP BY oi.product_id 
                         ORDER BY total_terjual DESC LIMIT 3";
        $topMenuStmt = $this->conn->query($topMenuQuery);
        $topMenus = $topMenuStmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat laporan penjualan",
            "data" => [
                "total_pesanan" => $totalPesanan,
                "total_pendapatan" => "Rp. " . number_format($totalPendapatan, 0, ',', '.'),
                "rata_rata" => "Rp. " . number_format($rataRata, 0, ',', '.'),
                "menu_terlaris" => $topMenus
            ]
        ]);
    }
}
?>