<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'baby_store';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit();
}

$produk = [];

// Ambil dari baju_bayi
$result = $conn->query("SELECT *, 'baju_bayi' AS kategori FROM baju_bayi");
while ($row = $result->fetch_assoc()) {
    $produk[] = $row;
}

// Ambil dari makanan_bayi
$result = $conn->query("SELECT *, 'makanan_bayi' AS kategori FROM makanan_bayi");
while ($row = $result->fetch_assoc()) {
    $produk[] = $row;
}

// Ambil dari mainan_bayi
$result = $conn->query("SELECT *, 'mainan_bayi' AS kategori FROM mainan_bayi");
while ($row = $result->fetch_assoc()) {
    $produk[] = $row;
}

// Ambil dari mainan_bayi
$result = $conn->query("SELECT *, 'popok_bayi' AS kategori FROM popok_bayi");
while ($row = $result->fetch_assoc()) {
    $produk[] = $row;
}

echo json_encode($produk);
$conn->close();
?>
