<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Ambil input JSON atau FormData
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

$action   = $_POST['action'] ?? ($data['action'] ?? '');
$username = $_POST['username'] ?? ($data['username'] ?? '');
$password = $_POST['password'] ?? ($data['password'] ?? '');

if (empty($action)) {
    echo json_encode(["error" => "Aksi tidak valid"]);
    exit;
}

if ($action === 'login') {
    if (empty($username) || empty($password)) {
        echo json_encode(['error' => 'Semua field wajib diisi']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(['error' => 'Username tidak ditemukan']);
        exit;
    }

    $user = $res->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        echo json_encode(['error' => 'Password salah']);
        exit;
    }

    $token = bin2hex(random_bytes(32));
    $update = $conn->prepare("UPDATE users SET token=? WHERE id=?");
    $update->bind_param("si", $token, $user['id']);
    $update->execute();

    echo json_encode([
        "success" => true,
        "message" => "Login berhasil",
        "user" => [
            "id" => $user['id'],
            "username" => $user['username']
        ],
        "token" => $token
    ]);
    exit;
}

if ($action === 'register') {
    if (empty($username) || empty($password)) {
        echo json_encode(['error' => 'Semua field wajib diisi']);
        exit;
    }

    $check = $conn->prepare("SELECT id FROM users WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;

    if ($exists) {
        echo json_encode(['error' => 'Username sudah digunakan']);
        exit;
    }

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $insert->bind_param("ss", $username, $hashed);
    $insert->execute();

    echo json_encode(["success" => true, "message" => "Registrasi berhasil"]);
    exit;
}

// Jika tidak ada aksi yang cocok
echo json_encode(['error' => 'Aksi tidak valid']);
exit;
?>