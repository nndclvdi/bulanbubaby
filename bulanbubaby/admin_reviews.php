<?php
// Simple admin panel for managing reviews
// In production, add proper authentication and security measures

// Database configuration
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda  
$dbname = "baby_store";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && isset($_POST['review_id'])) {
            $review_id = intval($_POST['review_id']);
            
            if ($_POST['action'] == 'approve') {
                $stmt = $conn->prepare("UPDATE reviews SET is_approved = TRUE WHERE id = ?");
                $stmt->execute([$review_id]);
                $message = "Ulasan berhasil disetujui.";
            } elseif ($_POST['action'] == 'reject') {
                $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
                $stmt->execute([$review_id]);
                $message = "Ulasan berhasil dihapus.";
            }
        }
    }

    // Get pending reviews
    $pending_sql = "SELECT * FROM reviews WHERE is_approved = FALSE ORDER BY created_at DESC";
    $pending_stmt = $conn->prepare($pending_sql);
    $pending_stmt->execute();
    $pending_reviews = $pending_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get approved reviews
    $approved_sql = "SELECT * FROM reviews WHERE is_approved = TRUE ORDER BY created_at DESC LIMIT 20";
    $approved_stmt = $conn->prepare($approved_sql);
    $approved_stmt->execute();
    $approved_reviews = $approved_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kelola Ulasan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .admin-header {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .review-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .rating {
            color: #ffc107;
        }
        .btn-approve {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-approve:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-reject {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-reject:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .pending-badge {
            background-color: #ffc107;
            color: #212529;
        }
        .approved-badge {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container">
            <h1><i class="fas fa-star me-2"></i>Admin Panel - Kelola Ulasan</h1>
            <p class="mb-0">Bulanbu Baby Store</p>
        </div>
    </div>

    <div class="container">
        <?php if (isset($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Pending Reviews -->
        <div class="row">
            <div class="col-12">
                <h2><i class="fas fa-clock me-2"></i>Ulasan Menunggu Persetujuan (<?php echo count($pending_reviews); ?>)</h2>
                
                <?php if (empty($pending_reviews)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Tidak ada ulasan yang menunggu persetujuan.
                    </div>
                <?php else: ?>
                    <?php foreach ($pending_reviews as $review): ?>
                        <div class="review-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5><?php echo htmlspecialchars($review['name']); ?>
                                        <span class="badge pending-badge ms-2">Pending</span>
                                    </h5>
                                    <small class="text-muted"><?php echo htmlspecialchars($review['email']); ?></small>
                                    <br>
                                    <small class="text-muted">
                                        <?php echo date('d M Y H:i', strtotime($review['created_at'])); ?>
                                        <?php if ($review['product_category']): ?>
                                            | <?php echo htmlspecialchars($review['product_category']); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i <= $review['rating'] ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <h6><?php echo htmlspecialchars($review['review_title']); ?></h6>
                            <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                            
                            <div class="d-flex gap-2">
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                    <input type                                     <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-approve">
                                        <i class="fas fa-check me-1"></i>Setujui
                                    </button>
                                </form>

                                <form method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');">
                                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-reject">
                                        <i class="fas fa-trash-alt me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approved Reviews -->
        <div class="row mt-5">
            <div class="col-12">
                <h2><i class="fas fa-check-circle me-2"></i>Ulasan Disetujui</h2>

                <?php if (empty($approved_reviews)): ?>
                    <div class="alert alert-secondary">
                        <i class="fas fa-info-circle me-2"></i>Belum ada ulasan yang disetujui.
                    </div>
                <?php else: ?>
                    <?php foreach ($approved_reviews as $review): ?>
                        <div class="review-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5><?php echo htmlspecialchars($review['name']); ?>
                                        <span class="badge approved-badge ms-2">Disetujui</span>
                                    </h5>
                                    <small class="text-muted"><?php echo htmlspecialchars($review['email']); ?></small>
                                    <br>
                                    <small class="text-muted">
                                        <?php echo date('d M Y H:i', strtotime($review['created_at'])); ?>
                                        <?php if ($review['product_category']): ?>
                                            | <?php echo htmlspecialchars($review['product_category']); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i <= $review['rating'] ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <h6><?php echo htmlspecialchars($review['review_title']); ?></h6>
                            <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>