<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/OrderController.php';
require_once 'controllers/ReviewController.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/Database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/OrderController.php';

$database = new Database();
$db = $database->getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', trim($uri, '/'));

$endpoint = isset($uriSegments[1]) ? $uriSegments[1] : '';
$action = isset($uriSegments[2]) ? $uriSegments[2] : '';

switch ($endpoint) {
    case 'auth':
        $authController = new AuthController($db);
        if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } elseif ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            notFoundResponse();
        }
        break;

    case 'products':
        $productController = new ProductController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($action === 'best-seller') {
                $productController->getBestSellers();
            } else {
                $productController->getAll();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'create') {
                $productController->create();
            } elseif ($action === 'search') {
                $productController->search();
            } elseif ($action === 'recommendations') {
                $productController->getRecommendations();
            } elseif ($action === 'category') {
                $productController->getByCategory(); // Endpoint Produk Berdasarkan Kategori / Promo Spesial[cite: 9]
            } else {
                notFoundResponse();
            }
        } else {
            notFoundResponse();
        }
        break;

    case 'cart':
        $cartController = new CartController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'add') {
                $cartController->add();
            } elseif ($action === 'list') {
                $cartController->getList();
            } else {
                notFoundResponse();
            }
        } else {
            notFoundResponse();
        }
        break;

    case 'order':
        $orderController = new OrderController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'checkout') {
                $orderController->checkout();
            } else {
                notFoundResponse();
            }
        } else {
            notFoundResponse();
        }
        break;

    default:
        notFoundResponse();
        break;
}

function notFoundResponse() {
    http_response_code(404);
    echo json_encode([
        "status" => false,
        "message" => "API Endpoint tidak ditemukan."
    ]);
}
?>