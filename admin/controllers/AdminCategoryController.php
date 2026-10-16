<?php
class AdminCategoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        $query = "SELECT c.*, (SELECT COUNT(*) FROM products WHERE products.category_id = c.id) as total_menu FROM categories c";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode(["status" => true, "message" => "Berhasil memuat daftar kategori", "data" => $categories]);
    }

    public function create() {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        if (!empty($name)) {
            $query = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(['name' => $name])) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Kategori berhasil ditambahkan."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menambah kategori."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Nama kategori wajib diisi."]);
        }
    }

    public function delete() {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';

        if (!empty($category_id)) {
            // Validasi: Kategori yang masih dipakai menu tidak bisa dihapus
            $check = $this->conn->prepare("SELECT COUNT(*) as total FROM products WHERE category_id = :id");
            $check->execute(['id' => $category_id]);
            $res = $check->fetch(PDO::FETCH_ASSOC);

            if ($res['total'] > 0) {
                http_response_code(400);
                echo json_encode(["status" => false, "message" => "Kategori yang masih dipakai menu tidak bisa dihapus."]);
                return;
            }

            $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
            if ($stmt->execute(['id' => $category_id])) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Kategori berhasil dihapus."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menghapus kategori."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "category_id wajib diisi."]);
        }
    }
}
?>