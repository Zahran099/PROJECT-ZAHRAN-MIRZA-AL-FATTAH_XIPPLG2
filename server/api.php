<?php
require_once "config.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// ✅ Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ========================
// 🔐 Validasi Token
// ========================
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';
$token = str_replace('Bearer ', '', $authHeader);

// Jika tidak kirim token → tolak semua kecuali GET public
if (!$token) {
    http_response_code(401);
    echo json_encode(["error" => "Token wajib dikirim"]);
    exit;
}

// Cek token di database
$stmt = $conn->prepare("SELECT id, username FROM users WHERE token=? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    http_response_code(401);
    echo json_encode(["error" => "Token tidak valid atau sudah kedaluwarsa"]);
    exit;
}

// ========================
// 🔧 Fungsi bantu
// ========================
function getInput() {
    return json_decode(file_get_contents("php://input"), true);
}

$method = $_SERVER['REQUEST_METHOD'];

// ========================
// 🧠 API Logika Utama
// ========================
switch ($method) {
    case 'GET':
        // Ambil semua post milik user login
        $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id=? ORDER BY id DESC");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["success" => true, "posts" => $data]);
        $stmt->close();
        break;

    case 'POST':
        $input = getInput();
        $title = trim($input['title'] ?? '');
        $body  = trim($input['body'] ?? '');

        if ($title === '' || $body === '') {
            http_response_code(400);
            echo json_encode(["error" => "Judul dan isi wajib diisi"]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO posts (title, body, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $body, $user['id']);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Post berhasil ditambahkan"]);
        $stmt->close();
        break;

    case 'PUT':
        // Pastikan ID dikirim via query string ?id=
        $id = intval($_GET['id'] ?? 0);
        $input = getInput();
        $title = trim($input['title'] ?? '');
        $body  = trim($input['body'] ?? '');

        if ($id <= 0 || $title === '' || $body === '') {
            http_response_code(400);
            echo json_encode(["error" => "Data tidak lengkap"]);
            exit;
        }

        $stmt = $conn->prepare("UPDATE posts SET title=?, body=? WHERE id=? AND user_id=?");
        $stmt->bind_param("ssii", $title, $body, $id, $user['id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Post berhasil diperbarui"]);
        } else {
            echo json_encode(["error" => "Gagal memperbarui post"]);
        }

        $stmt->close();
        break;

    case 'DELETE':
        $id = intval($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "ID tidak valid"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM posts WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $id, $user['id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Post dihapus"]);
        } else {
            echo json_encode(["error" => "Post tidak ditemukan atau bukan milik Anda"]);
        }

        $stmt->close();
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metode tidak didukung"]);
        break;
}

$conn->close();
?>