<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    public function getAll() {
        $products = $this->productModel->getAll();
        http_response_code(200);
        echo json_encode(["status" => true, "message" => "Berhasil memuat data menu", "data" => $products]);
    }

    public function getBestSellers() {
        $products = $this->productModel->getBestSellers();
        http_response_code(200);
        echo json_encode(["status" => true, "message" => "Berhasil memuat produk Best Seller", "data" => $products]);
    }

    // Endpoint khusus halaman Rekomendasi Makanan (Best Seller & Harga Terjangkau)
    public function getRecommendations() {
        $bestSellers = $this->productModel->getBestSellers();
        $affordable = $this->productModel->getAffordableProducts();

        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Berhasil memuat data halaman rekomendasi",
            "data" => [
                "best_seller" => $bestSellers,
                "harga_terjangkau" => $affordable
            ]
        ]);
    }
    public function search() {
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $products = $this->productModel->search($keyword);
        
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Hasil pencarian menu",
            "data" => $products
        ]);
    }
    public function create() {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $is_best_seller = isset($_POST['is_best_seller']) ? $_POST['is_best_seller'] : 0;
        
        $imageName = null;

        if (!empty($category_id) && !empty($name) && !empty($price)) {
            // Handle upload file gambar jika dikirim di form-data Postman (tipe file)
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadFileDir = __DIR__ . '/../uploads/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        $imageName = 'uploads/' . $newFileName;
                    }
                }
            }

            $this->productModel->category_id = $category_id;
            $this->productModel->name = $name;
            $this->productModel->price = $price;
            $this->productModel->image = $imageName;
            $this->productModel->is_best_seller = $is_best_seller;

            if ($this->productModel->create()) {
                http_response_code(201);
                echo json_encode(["status" => true, "message" => "Menu berhasil ditambahkan."]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => false, "message" => "Gagal menyimpan menu."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Data tidak lengkap (category_id, name, price wajib diisi)."]);
        }
    }
}
?>