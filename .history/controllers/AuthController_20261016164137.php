<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    
public function register() {
    header("Content-Type: application/json; charset=UTF-8");

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $no_tlp = trim($_POST['no_tlp'] ?? '');

    if ($username === '' || $email === '' || $password === '' || $no_tlp === '') {
        http_response_code(400);
        echo json_encode([
            "status" => false,
            "message" => "Semua field wajib diisi."
        ]);
        return;
    }

    $this->userModel->username = $username;
    $this->userModel->email = $email;

    if ($this->userModel->isExists()) {
        http_response_code(400);
        echo json_encode([
            "status" => false,
            "message" => "Username atau Email sudah terdaftar."
        ]);
        return;
    }

    $this->userModel->password = $password;
    $this->userModel->no_tlp = $no_tlp;

    if ($this->userModel->create()) {
        http_response_code(201);

        echo json_encode([
            "status" => true,
            "message" => "Registrasi berhasil.",
            "data" => [
                "username" => $username,
                "email" => $email,
                "no_tlp" => $no_tlp
            ]
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "message" => "Gagal melakukan registrasi."
        ], JSON_PRETTY_PRINT);
    }
}


   
public function login() {
    header("Content-Type: application/json; charset=UTF-8");

    // Mengambil data dari form-data Postman
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        http_response_code(400);

        echo json_encode([
            "status" => false,
            "message" => "Username dan Password wajib diisi."
        ], JSON_PRETTY_PRINT);
        return;
    }

    // Mencari pengguna berdasarkan username atau email
    $user = $this->userModel->findByUsernameOrEmail($username);

    if ($user && password_verify($password, $user['password'])) {
        http_response_code(200);

        echo json_encode([
            "status" => true,
            "message" => "Login berhasil.",
            "data" => [
                "id" => $user['id'],
                "username" => $user['username'],
                "email" => $user['email'],
                "no_tlp" => $user['no_tlp']
            ]
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(401);

        echo json_encode([
            "status" => false,
            "message" => "Username atau Password salah."
        ], JSON_PRETTY_PRINT);
    }
}
}
?>