<?php
$mysqli = new mysqli("localhost", "root", "", "baby_store");

if ($mysqli->connect_error) {
  die("Gagal koneksi: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $password);

  if ($stmt->execute()) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Gagal daftar: email sudah terdaftar.'); window.location.href='index.php';</script>";
  }
}
?>
