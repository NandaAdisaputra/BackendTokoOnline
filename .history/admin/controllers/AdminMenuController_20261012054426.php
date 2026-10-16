<?php
class AdminMenuController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hitung ringkasan stok
        $totalMenu = count($products);
        $stokTersedia = 0;
        $stokHabis = 0;
        foreach ($products as $p) {
            if ($p['is_available'] == 1) $stokTersedia++;
            else $stokHabis++;
        }

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat daftar menu admin",
            "summary" => [
                "total_menu" => $totalMenu,
                "stok_tersedia" => $stokTersedia,
                "stok_habis" => $stokHabis
            ],
            "data" => $products
        ]);
    }

    public function detail() {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (!empty($product_id)) {
            $query = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Berhasil memuat detail menu", "data" => $product]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Menu tidak ditemukan."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "product_id wajib diisi."]);
        }
    }

    public function create() {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $is_best_seller = isset($_POST['is_best_seller']) ? $_POST['is_best_seller'] : 0;
        
        $imageName = null;

        if (!empty($category_id) && !empty($name) && !empty($price)) {
            // Handle upload foto menu jika ada
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowed)) {
                    $newFileName = 'menu_' . time() . '.' . $fileExtension;
                    $uploadDir = __DIR__ . '/../../uploads/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    
                    if (move_uploaded_file($fileTmpPath, $uploadDir . $newFileName)) {
                        $imageName = 'uploads/' . $newFileName;
                    }
                }
            }

            $query = "INSERT INTO products (category_id, name, price, description, image, is_best_seller, is_available) 
                      VALUES (:cat, :name, :price, :desc, :img, :bs, 1)";
            $stmt = $this->conn->prepare($query);
            $executed = $stmt->execute([
                'cat' => $category_id,
                'name' => $name,
                'price' => $price,
                'desc' => $description,
                'img' => $imageName,
                'bs' => $is_best_seller
            ]);

            if ($executed) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Menu berhasil ditambahkan."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menyimpan menu."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data wajib (category_id, name, price) tidak lengkap."]);
        }
    }

    public function toggleStock() {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $is_available = isset($_POST['is_available']) ? $_POST['is_available'] : '';

        if (!empty($product_id) && $is_available !== '') {
            $query = "UPDATE products SET is_available = :avail WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(['avail' => $is_available, 'id' => $product_id])) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Status stok berhasil diperbarui."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal memperbarui status stok."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "product_id dan is_available wajib diisi."]);
        }
    }

    public function delete() {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (!empty($product_id)) {
            $query = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(['id' => $product_id])) {
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Menu berhasil dihapus."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menghapus menu."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "product_id wajib diisi."]);
        }
    }
}
?>