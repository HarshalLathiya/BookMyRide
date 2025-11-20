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
    $price = $_POST['price_per_day'];
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
            (name, category, price_per_day, fuel_type, transmission, seating_capacity, mileage, engine, description, image, status) 
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
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #f1f2f6;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 2px solid #ddd;
            font-size: 15px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #5d5d81;
            outline: none;
            box-shadow: 0 0 4px rgba(93, 93, 129, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #5d5d81, #8a8aac);
            color: white;
            font-size: 17px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .msg {
            padding: 12px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .success {
            background: #2ecc71;
            color: white;
        }

        .error {
            background: #e74c3c;
            color: white;
        }

        .image-preview img {
            width: 120px;
            margin-top: 10px;
            border-radius: 10px;
            display: none;
        }
    </style>
</head>

<body>
<button onclick="window.history.back()" 
style="
    background:#444;
    color:#fff;
    width:80px;
    padding:6px 0;
    font-size:14px;
    border:none;
    border-radius:4px;
    cursor:pointer;
    text-align:center;
">
    ← Back
</button>

    <div class="container">
        <h2>Add New Car</h2>

        <?php if ($success): ?>
            <div class="msg success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="msg error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Car Name</label>
            <input type="text" name="name" required>

            <label>Category</label>
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <option value="sedan">Sedan</option>
                <option value="suv">SUV</option>
                <option value="7-seater">7-Seater</option>
                <option value="luxury">Luxury</option>
            </select>

            <label>Price Per Day (₹)</label>
            <input type="number" name="price_per_day" required>

            <label>Fuel Type</label>
            <select name="fuel_type" required>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
                <option value="CNG">CNG</option>
            </select>

            <label>Transmission</label>
            <select name="transmission" required>
                <option value="Manual">Manual</option>
                <option value="Automatic">Automatic</option>
            </select>

            <label>Seats</label>
            <input type="number" name="seating_capacity" required>

            <label>Mileage (km/l)</label>
            <input type="text" name="mileage">

            <label>Engine</label>
            <input type="text" name="engine">

            <label>Description</label>
            <textarea name="description" rows="4"></textarea>

            <label>Car Image</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Car</button>
        </form>
    </div>

</body>

</html>
