<?php
session_start();

// Admin Protection
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include 'db.php';

// Get POST data
$booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

$allowed_statuses = ['Pending', 'Completed', 'Cancelled'];

if ($booking_id <= 0 || !in_array($status, $allowed_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Update booking status in database
$stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'DB prepare failed']);
    exit;
}
$stmt->bind_param("si", $status, $booking_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'DB execute failed']);
}
$stmt->close();
?>
