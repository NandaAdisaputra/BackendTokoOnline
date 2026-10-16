<?php
class ProductController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        // Ambil parameter page dan limit dari GET (Query Params) atau POST (Form-data)
        $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 10;
        
        $page = max(1, $page);
        $limit = max(1, min(100, $limit)); // Batasi maksimal 100 item per halaman
        $offset = ($page - 1) * $limit;

        // Hitung total data keseluruhan
        $countStmt = $this->conn->query("SELECT COUNT(*) as total FROM products");
        $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalRows / $limit);

        // Ambil data dengan LIMIT dan OFFSET
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format respons JSON dengan metadata pagination standar industri
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat daftar produk",
            "pagination" => [
                "current_page" => $page,
                "per_page" => $limit,
                "total_items" => (int)$totalRows,
                "total_pages" => (int)$totalPages
            ],
            "data" => $products
        ]);
    }
}
?>