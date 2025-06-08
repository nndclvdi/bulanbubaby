<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda  
$dbname = "baby_store";

$response = array();

try {
    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $rating = intval($_POST['rating'] ?? 0);
        $product_category = trim($_POST['product_category'] ?? '');
        $review_title = trim($_POST['review_title'] ?? '');
        $review_text = trim($_POST['review_text'] ?? '');

        // Validation
        $errors = array();

        if (empty($name) || strlen($name) < 2) {
            $errors[] = "Nama harus diisi minimal 2 karakter";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid";
        }

        if ($rating < 1 || $rating > 5) {
            $errors[] = "Rating harus antara 1-5";
        }

        if (empty($review_title) || strlen($review_title) < 5) {
            $errors[] = "Judul ulasan harus diisi minimal 5 karakter";
        }

        if (empty($review_text) || strlen($review_text) < 10) {
            $errors[] = "Ulasan harus diisi minimal 10 karakter";
        }

        // Check if email already exists for recent reviews (prevent spam)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reviews WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $stmt->execute([$email]);
        $recent_reviews = $stmt->fetchColumn();

        if ($recent_reviews > 0) {
            $errors[] = "Anda sudah memberikan ulasan dalam 24 jam terakhir";
        }

        if (!empty($errors)) {
            $response['success'] = false;
            $response['message'] = implode(', ', $errors);
        } else {
            // Insert review into database
            $sql = "INSERT INTO reviews (name, email, rating, product_category, review_title, review_text, created_at, is_approved) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), FALSE)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $email, $rating, $product_category, $review_title, $review_text]);

            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Terima kasih! Ulasan Anda telah berhasil dikirim dan akan ditampilkan setelah diverifikasi.';
                
                // Send notification email (optional)
                $subject = "Ulasan Baru dari " . $name;
                $message = "Ulasan baru telah diterima:\n\n";
                $message .= "Nama: " . $name . "\n";
                $message .= "Email: " . $email . "\n";
                $message .= "Rating: " . $rating . "/5\n";
                $message .= "Kategori: " . $product_category . "\n";
                $message .= "Judul: " . $review_title . "\n";
                $message .= "Ulasan: " . $review_text . "\n\n";
                $message .= "Silakan login ke admin panel untuk menyetujui ulasan ini.";
                
                // Uncomment line below if you want to send email notifications
                // mail("admin@bulanbu.com", $subject, $message);
                
            } else {
                $response['success'] = false;
                $response['message'] = 'Terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.';
            }
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Method tidak diizinkan';
    }

} catch(PDOException $e) {
    $response['success'] = false;
    $response['message'] = 'Koneksi database gagal: ' . $e->getMessage();
} catch(Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
}

// Close connection
$conn = null;

// Return JSON response
echo json_encode($response);
?>