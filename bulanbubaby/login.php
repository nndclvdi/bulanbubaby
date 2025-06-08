<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "baby_store");

if ($mysqli->connect_error) {
  die("Gagal koneksi: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows === 1) {
    $user = $res->fetch_assoc();
    $_SESSION["username"] = $user["username"];
    header("Location: dashboard.php");
    exit;
  } else {
    echo "<script>alert('Email atau password salah!'); window.location.href='index.php';</script>";
  }
}
?>
