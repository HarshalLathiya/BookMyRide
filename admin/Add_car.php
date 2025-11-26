<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}

include 'db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Basic fields
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price_per_km'];
    $fuel = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $seats = $_POST['seating_capacity'];
    $mileage = $_POST['mileage'];
    $engine = $_POST['engine'];
    $description = $_POST['description'];

    // --- IMAGE UPLOAD ---
    $image = "";
    if (!empty($_FILES['image']['name'])) {

        $targetDir = "../assets/images/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        $allowed = ['jpg', 'jpeg', 'png', 'webp','avif'];
        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "❌ Only JPG, JPEG, PNG, WEBP allowed.";
        } else {
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
            $image = $fileName;
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("
            INSERT INTO cars 
            (name, category, price_per_km, fuel_type, transmission, seating_capacity, mileage, engine, description, image, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')
        ");

        $stmt->bind_param("ssdssissss", 
            $name, $category, $price, $fuel, $transmission, $seats, $mileage, $engine, $description, $image
        );

        if ($stmt->execute()) {
            $success = "✅ Car added successfully!";
        } else {
            $error = "Database Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Car - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/add_car.css">
</head>

<body>
<div class="page-back-wrap">
    <a href="View_cars.php" class="btn back-btn">← Back</a>
</div>


    <div class="admin-container">
    <div class="main-content">
        <div class="content-section">
            <div class="section-header">
                <h2>Add New Car</h2>
            </div>

            <?php if ($success): ?>
                <div class="message message-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="message message-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="form-container">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Car Name</label>
                        <input class="form-control" type="text" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" required>
                            <option value="">-- Select Category --</option>
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="7-seater">7-Seater</option>
                            <option value="luxury">Luxury</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price Per Km (₹)</label>
                        <input class="form-control" type="number" name="price_per_km" required>
                    </div>

                    <div class="form-group">
                        <label>Fuel Type</label>
                        <select class="form-control" name="fuel_type" required>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="CNG">CNG</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Transmission</label>
                        <select class="form-control" name="transmission" required>
                            <option value="Manual">Manual</option>
                            <option value="Automatic">Automatic</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Seats</label>
                        <input class="form-control" type="number" name="seating_capacity" required>
                    </div>

                    <div class="form-group">
                        <label>Mileage (km/l)</label>
                        <input class="form-control" type="text" name="mileage">
                    </div>

                    <div class="form-group">
                        <label>Engine</label>
                        <input class="form-control" type="text" name="engine">
                    </div>

                    <div class="form-group full-width">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label>Car Image</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Add Car</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
