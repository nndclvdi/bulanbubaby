<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "baby_store");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form
$nama      = $_POST['name'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$subject   = $_POST['subject'];
$baby_age  = $_POST['babyAge'];
$urgency   = $_POST['urgency'];
$message   = $_POST['message'];
$terms     = isset($_POST['terms']) ? 1 : 0;
$newsletter = isset($_POST['newsletter']) ? 1 : 0;

// SQL sesuai kolom di database kamu
$sql = "INSERT INTO kontak (nama, email, phone, subject, baby_age, urgency, message, terms_accepted, subscribe_newsletter) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    die("Query gagal: " . $koneksi->error);
}

$stmt->bind_param("sssssssii", $nama, $email, $phone, $subject, $baby_age, $urgency, $message, $terms, $newsletter);

if ($stmt->execute()) {
    echo "<script>
        alert('Pesan berhasil dikirim!');
        window.location.href = 'kontak.html';
    </script>";
} else {
    echo "Gagal simpan: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>
