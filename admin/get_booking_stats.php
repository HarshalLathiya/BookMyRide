<?php
session_start();

// Admin Protection
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include 'db.php';

// Calculate summary statistics
$summary_sql = "SELECT
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_bookings,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_bookings,
    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_bookings
    FROM bookings";

$summary_result = mysqli_query($conn, $summary_sql);

if ($summary_result) {
    $summary = mysqli_fetch_assoc($summary_result);
    echo json_encode([
        'success' => true,
        'total_bookings' => $summary['total_bookings'] ?? 0,
        'pending_bookings' => $summary['pending_bookings'] ?? 0,
        'completed_bookings' => $summary['completed_bookings'] ?? 0,
        'cancelled_bookings' => $summary['cancelled_bookings'] ?? 0
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch statistics']);
}
?>
