<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/controllers/AdminAuthController.php';
require_once __DIR__ . '/controllers/AdminMenuController.php';
require_once __DIR__ . '/controllers/AdminCategoryController.php';
require_once __DIR__ . '/controllers/AdminOrderController.php';
require_once __DIR__ . '/controllers/AdminReportController.php';
require_once __DIR__ . '/controllers/AdminProfileController.php';

$database = new Database();
$db = $database->getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', trim($uri, '/'));

// Karena di dalam folder admin, sesuaikan posisi segment endpoint
$endpointKey = array_search('admin', $uriSegments);
$endpoint = isset($uriSegments[$endpointKey + 1]) ? $uriSegments[$endpointKey + 1] : '';
$action = isset($uriSegments[$endpointKey + 2]) ? $uriSegments[$endpointKey + 2] : '';

switch ($endpoint) {
    case 'auth':
        $ctrl = new AdminAuthController($db);
        if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') $ctrl->login();
        else notFoundResponse();
        break;

    case 'menu':
        $ctrl = new AdminMenuController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'list') $ctrl->list();
            elseif ($action === 'detail') $ctrl->detail();
            elseif ($action === 'create') $ctrl->create();
            elseif ($action === 'toggle-stock') $ctrl->toggleStock();
            elseif ($action === 'delete') $ctrl->delete();
            else notFoundResponse();
        } else notFoundResponse();
        break;

    case 'category':
        $ctrl = new AdminCategoryController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'list') $ctrl->list();
            elseif ($action === 'create') $ctrl->create();
            elseif ($action === 'delete') $ctrl->delete();
            else notFoundResponse();
        } else notFoundResponse();
        break;

    case 'order':
        $ctrl = new AdminOrderController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'list') $ctrl->list();
            elseif ($action === 'detail') $ctrl->detail();
            elseif ($action === 'update-status') $ctrl->updateStatus();
            else notFoundResponse();
        } else notFoundResponse();
        break;

    case 'report':
        $ctrl = new AdminReportController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'summary') $ctrl->summary();
        else notFoundResponse();
        break;

    case 'profile':
        $ctrl = new AdminProfileController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'get') $ctrl->get();
            elseif ($action === 'update') $ctrl->update();
            else notFoundResponse();
        } else notFoundResponse();
        break;

    default:
        notFoundResponse();
        break;
}

function notFoundResponse() {
    http_response_code(404);
    echo json_encode(["status" => false, "message" => "Admin API Endpoint tidak ditemukan."]);
}
?>