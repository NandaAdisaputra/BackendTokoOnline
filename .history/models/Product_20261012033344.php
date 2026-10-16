<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi Pencarian Lanjutan (Screen 07)
    public function searchAdvanced($keyword, $filter = 'Semua') {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.is_available 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.name LIKE :keyword";

        if (strtolower($filter) !== 'semua') {
            if (strtolower($filter) === 'promo') {
                $query .= " AND p.is_best_seller = 1";
            } else {
                $query .= " AND c.name = :filter";
            }
        }

        $stmt = $this->conn->prepare($query);
        if (strtolower($filter) !== 'semua' && strtolower($filter) !== 'promo') {
            $stmt->execute(['keyword' => '%' . $keyword . '%', 'filter' => $filter]);
        } else {
            $stmt->execute(['keyword' => '%' . $keyword . '%']);
        }
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Rekomendasi "Mungkin kamu suka" (Screen 07)
        $recQuery = "SELECT id, category_id, name, price, image, is_best_seller, is_available 
                     FROM " . $this->table_name . " 
                     WHERE name NOT LIKE :keyword 
                     ORDER BY RAND() LIMIT 2";
        $recStmt = $this->conn->prepare($recQuery);
        $recStmt->execute(['keyword' => '%' . $keyword . '%']);
        $mightLike = $recStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "search_results" => $searchResults,
            "might_like" => $mightLike
        ];
    }
}
?>