<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include 'db.php';

if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    echo "<p style='padding:20px; font-family:Arial; color:red;'>Invalid booking ID.</p>";
    exit;
}

$booking_id = (int)$_GET['booking_id'];

// Fetch booking info with join to car details
$stmt = $conn->prepare("
    SELECT b.*, c.name as car_name, c.price_per_day 
    FROM bookings b INNER JOIN cars c ON b.car_id = c.car_id 
    WHERE b.booking_id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo "<p style='padding:20px; font-family:Arial; color:red;'>Booking not found.</p>";
    exit;
}
?>

<div class="confirmation-container" style="max-width:600px; margin: 40px auto; font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
    <h2>Booking Confirmed!</h2>
    <p>Thank you for your booking, <strong><?= htmlspecialchars($booking['full_name']) ?></strong>.</p>
    
    <h3>Booking Details:</h3>
    <ul>
        <li><strong>Car:</strong> <?= htmlspecialchars($booking['car_name']) ?></li>
        <li><strong>Estimated Kilometers:</strong> <?= htmlspecialchars($booking['estimated_km'] ?? 'N/A') ?></li>
        <li><strong>Pickup Location:</strong> <?= htmlspecialchars($booking['pickup_location']) ?></li>
        <li><strong>Drop Location:</strong> <?= htmlspecialchars($booking['drop_location']) ?></li>
        <li><strong>Payment Method:</strong> <?= htmlspecialchars($booking['payment_method']) ?></li>
        <li><strong>Amount:</strong> ₹<?= number_format($booking['estimated_km'] * $booking['price_per_day'], 2) ?></li>
        <li><strong>Status:</strong> <?= htmlspecialchars(ucfirst($booking['status'] ?? 'pending')) ?></li>
    </ul>
    
    <p>If you have any questions, please contact our customer support.</p>
</div>

<?php include 'includes/footer.php'; ?>
