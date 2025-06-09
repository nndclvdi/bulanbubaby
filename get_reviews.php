<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
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

    // Get pagination parameters
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = isset($_GET['limit']) ? min(50, max(1, intval($_GET['limit']))) : 10;
    $offset = ($page - 1) * $limit;

    // Get filter parameters
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $rating = isset($_GET['rating']) ? intval($_GET['rating']) : 0;

    // Build WHERE clause
    $where_conditions = ["is_approved = TRUE"];
    $params = [];

    if (!empty($category)) {
        $where_conditions[] = "product_category = ?";
        $params[] = $category;
    }

    if ($rating > 0 && $rating <= 5) {
        $where_conditions[] = "rating = ?";
        $params[] = $rating;
    }

    $where_clause = implode(" AND ", $where_conditions);

    // Get total count
    $count_sql = "SELECT COUNT(*) FROM reviews WHERE $where_clause";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->execute($params);
    $total_reviews = $count_stmt->fetchColumn();

    // Get reviews
    $sql = "SELECT id, name, email, rating, product_category, review_title, review_text, 
                   created_at, helpful_count
            FROM reviews 
            WHERE $where_clause 
            ORDER BY created_at DESC 
            LIMIT $limit OFFSET $offset";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format reviews for display
    $formatted_reviews = array();
    foreach ($reviews as $review) {
        $formatted_reviews[] = array(
            'id' => $review['id'],
            'name' => htmlspecialchars($review['name']),
            'rating' => intval($review['rating']),
            'product_category' => htmlspecialchars($review['product_category']),
            'review_title' => htmlspecialchars($review['review_title']),
            'review_text' => htmlspecialchars($review['review_text']),
            'created_at' => $review['created_at'],
            'formatted_date' => formatTimeAgo($review['created_at']),
            'helpful_count' => intval($review['helpful_count']),
            'avatar' => strtoupper(substr($review['name'], 0, 1))
        );
    }

    // Get statistics
    $stats_sql = "SELECT 
                    COUNT(*) as total_reviews,
                    AVG(rating) as avg_rating,
                    COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
                    COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
                    COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
                    COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
                    COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
                  FROM reviews WHERE is_approved = TRUE";
    
    $stats_stmt = $conn->prepare($stats_sql);
    $stats_stmt->execute();
    $stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['reviews'] = $formatted_reviews;
    $response['pagination'] = array(
        'current_page' => $page,
        'total_pages' => ceil($total_reviews / $limit),
        'total_reviews' => intval($total_reviews),
        'limit' => $limit
    );
    $response['statistics'] = array(
        'total_reviews' => intval($stats['total_reviews']),
        'avg_rating' => round(floatval($stats['avg_rating']), 1),
        'rating_distribution' => array(
            '5' => intval($stats['five_star']),
            '4' => intval($stats['four_star']),
            '3' => intval($stats['three_star']),
            '2' => intval($stats['two_star']),
            '1' => intval($stats['one_star'])
        )
    );

} catch(PDOException $e) {
    $response['success'] = false;
    $response['message'] = 'Database connection failed: ' . $e->getMessage();
} catch(Exception $e) {
    $response['success'] = false;
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Close connection
$conn = null;

// Return JSON response
echo json_encode($response);

// Helper function to format time ago
function formatTimeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) {
        return 'Baru saja';
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . ' menit yang lalu';
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . ' jam yang lalu';
    } elseif ($time < 2592000) {
        $days = floor($time / 86400);
        return $days . ' hari yang lalu';
    } elseif ($time < 31536000) {
        $months = floor($time / 2592000);
        return $months . ' bulan yang lalu';
    } else {
        $years = floor($time / 31536000);
        return $years . ' tahun yang lalu';
    }
}
?>