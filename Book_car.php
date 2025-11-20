<?php
include("includes/header.php");
// Include the database connection
include 'db.php';

// Ensure car_id is passed via GET
if (!isset($_GET['car_id'])) {
    die("❌ Car ID not provided.");
}

$car_id = $_GET['car_id'];

// Prepare SELECT query to get car details
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
if (!$stmt) {
    die("❌ SQL Prepare Error (SELECT): " . $conn->error);
}

$stmt->bind_param("i", $car_id);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die("❌ SQL Execute Error (SELECT): " . $stmt->error);
}

$car = $result->fetch_assoc();
$stmt->close();

// Check if the car exists and is available
if (!$car || $car['status'] !== 'available') {
    die("🚫 This car is already booked or unavailable.");
}

$success = "";
$error = "";

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $car_type = trim($_POST['car_type'] ?? '');
    $pickup_date = trim($_POST['pickup_date'] ?? '');
    $drop_date = trim($_POST['drop_date'] ?? '');
    $pickup_location = trim($_POST['pickup_location'] ?? '');
    $drop_location = trim($_POST['drop_location'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? ''); // new

    // Validation
    if ($pickup_date > $drop_date) {
        $error = "❌ Drop date must be after pickup date.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Invalid email format.";
    } elseif (empty($payment_method)) {
        $error = "❌ Please select a payment method.";
    } else {
        // Insert booking with payment_method
        $stmt = $conn->prepare("INSERT INTO bookings 
            (car_id, full_name, email, phone, car_type, pickup_date, drop_date, pickup_location, drop_location, payment_method) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) die("❌ SQL Prepare Error (INSERT): " . $conn->error);

        $stmt->bind_param("isssssssss", $car_id, $full_name, $email, $phone, $car_type, $pickup_date, $drop_date, $pickup_location, $drop_location, $payment_method);

        if (!$stmt->execute()) {
            die("❌ SQL Execute Error (INSERT): " . $stmt->error);
        }

        $booking_id = $stmt->insert_id; // get booking id
        $stmt->close();

        // Insert payment record
        $stmt = $conn->prepare("INSERT INTO payments (booking_id, amount, method, status) VALUES (?, ?, ?, ?)");
        if (!$stmt) die("❌ SQL Prepare Error (INSERT PAYMENT): " . $conn->error);

        // Calculate amount based on days and price
        $days = (strtotime($drop_date) - strtotime($pickup_date)) / (60 * 60 * 24) + 1;
        $amount = $days * $car['price_per_day'];

        $status = 'pending';
        $stmt->bind_param("idss", $booking_id, $amount, $payment_method, $status);

        if (!$stmt->execute()) {
            die("❌ SQL Execute Error (INSERT PAYMENT): " . $stmt->error);
        }
        $stmt->close();

        // Update car status to booked
        $stmt = $conn->prepare("UPDATE cars SET status = 'booked' WHERE car_id = ?");
        if (!$stmt) die("❌ SQL Prepare Error (UPDATE CAR): " . $conn->error);

        $stmt->bind_param("i", $car_id);
        if (!$stmt->execute()) {
            die("❌ SQL Execute Error (UPDATE CAR): " . $stmt->error);
        }
        $stmt->close();

        $success = "✅ Booking confirmed! Thank you for choosing BookMyRide.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?= htmlspecialchars($car['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .booking-form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 7px rgba(0,0,0,0.1);
        }
        .booking-form h2 {
            margin-bottom: 20px;
            color: #1a5f7a;
        }
        .booking-form label {
            font-weight: 600;
            margin-top: 10px;
        }
        .booking-form input, .booking-form select {
            width: 100%;
            padding: 8px 12px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .booking-form button {
            margin-top: 20px;
            background-color: #1a5f7a;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .booking-form button:hover {
            background-color: #159895;
        }
        .error-msg {
            color: #dc3545;
            margin-top: 10px;
            font-weight: 600;
        }
        .success-msg {
            color: #28a745;
            margin-top: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="booking-form">
        <h2>Book <?= htmlspecialchars($car['name']) ?></h2>
        <form method="POST">
            <label>Your Full Name:</label>
            <input type="text" name="full_name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">

            <label>Email:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label>Phone Number:</label>
            <input type="text" name="phone" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

            <label>Car Type:</label>
            <input type="text" name="car_type" required value="<?= htmlspecialchars($car['name']) ?>" readonly>

            <label>Pickup Date:</label>
            <input type="date" name="pickup_date" required value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>">

            <label>Drop Date:</label>
            <input type="date" name="drop_date" required value="<?= htmlspecialchars($_POST['drop_date'] ?? '') ?>">

            <label>Pickup Location:</label>
            <input type="text" name="pickup_location" required value="<?= htmlspecialchars($_POST['pickup_location'] ?? '') ?>">

            <label>Drop Location:</label>
            <input type="text" name="drop_location" required value="<?= htmlspecialchars($_POST['drop_location'] ?? '') ?>">

            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="UPI" <?= (($_POST['payment_method'] ?? '')=='UPI'?'selected':'') ?>>UPI</option>
                <option value="Debit/Credit Card" <?= (($_POST['payment_method'] ?? '')=='Debit/Credit Card'?'selected':'') ?>>Debit/Credit Card</option>
                <option value="Cash on Drop" <?= (($_POST['payment_method'] ?? '')=='Cash on Drop'?'selected':'') ?>>Cash on Drop</option>
            </select>

            <button type="submit">Confirm Booking</button>

            <?php if ($error): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php elseif ($success): ?>
                <p class="success-msg"><?= $success ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
