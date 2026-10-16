<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi getAll dengan dukungan Pagination
    public function getAll($page = 1, $limit = 10) {
        $page = max(1, (int)$page);
        $limit = max(1, min(100, (int)$limit)); // Batasi maksimal 100 per halaman
        $offset = ($page - 1) * $limit;

        // Hitung total keseluruhan data produk
        $countQuery = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $countStmt = $this->conn->query($countQuery);
        $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalRows / $limit);

        // Ambil data produk dengan LIMIT dan OFFSET
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.is_available, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mengembalikan struktur data beserta informasi pagination
        return [
            "pagination" => [
                "current_page" => $page,
                "per_page" => $limit,
                "total_items" => (int)$totalRows,
                "total_pages" => (int)$totalPages
            ],
            "data" => $products
        ];
    }

    public function getBestSellers() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.is_available, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.is_best_seller = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAffordableProducts() {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.is_available, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.price <= 10000 
                  ORDER BY p.price ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($category_id) {
        $catQuery = "SELECT id, name FROM categories WHERE id = :category_id LIMIT 1";
        $catStmt = $this->conn->prepare($catQuery);
        $catStmt->execute(['category_id' => $category_id]);
        $category = $catStmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            return null;
        }

        $prodQuery = "SELECT id, category_id, name, price, image, is_best_seller, is_available 
                      FROM " . $this->table_name . " 
                      WHERE category_id = :category_id";
        $prodStmt = $this->conn->prepare($prodQuery);
        $prodStmt->execute(['category_id' => $category_id]);
        $products = $prodStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "category_info" => [
                "id" => $category['id'],
                "name" => $category['name'],
                "banner_title" => "Home / " . $category['name'],
            ],
            "products" => $products
        ];
    }

    public function search($keyword) {
        $query = "SELECT p.id, p.category_id, c.name as category_name, p.name, p.price, p.image, p.is_best_seller, p.is_available, p.created_at 
                  FROM " . $this->table_name . " p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.name LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (category_id, name, price, image, is_best_seller, is_available) 
                  VALUES (:category_id, :name, :price, :image, :is_best_seller, :is_available)";
        $stmt = $this->conn->prepare($query);
        
        $is_available = isset($_POST['is_available']) ? $_POST['is_available'] : 1;

        return $stmt->execute([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image,
            'is_best_seller' => $this->is_best_seller,
            'is_available' => $is_available
        ]);
    }

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