<?php
include("includes/header.php");
include 'db.php';

// CATEGORY MAP
$category_map = [
    'sedan' => 'verna',
    '7seater' => 'ertiga',
    'suv' => 'fortuner',
    'thar' => 'thar'
];

$category = $_GET['category'] ?? '';
$db_category = $category_map[$category] ?? '';

// Fetch Cars
if ($db_category) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE category = ? ORDER BY status ASC");
    $stmt->bind_param("s", $db_category);
} else {
    $stmt = $conn->prepare("SELECT * FROM cars ORDER BY status ASC");
}
$stmt->execute();
$cars = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>BookMyRide - Cars</title>
    <link rel="stylesheet" href="assets/css/cars.css"/>
</head>

<body>

<h1>
    <?php echo $category ? ucfirst($category) . " Cars" : "Available Cars"; ?>
</h1>

<div class="cars-container">
    <?php while ($car = $cars->fetch_assoc()): ?>
        <div class="car-card">

            <div class="car-image"
                 style="background-image: url('assets/images/<?php echo htmlspecialchars($car['image']); ?>');">
            </div>

            <div class="car-body">
                <h5><?php echo htmlspecialchars($car['name']); ?></h5>

                <!--<p class="car-price">₹ <?php echo $car['price_per_day']; ?> / day</p>-->
                <p class="car-price">₹ <?php echo $car['price_per_km']; ?> / km</p>

                

                <p class="status">
                    Status:
                    <span style="color:<?php echo $car['status'] == 'available' ? 'green' : 'red'; ?>">
                        <?php echo ucfirst($car['status']); ?>
                    </span>
                </p>

                <?php if ($car['status'] === 'available'): ?>
                    <a href="car_details.php?car_id=<?php echo $car['car_id']; ?>" class="btn-book">View Details</a>
                <?php else: ?>
                    <span class="btn-book btn-disabled">Booked</span>
                <?php endif; ?>
            </div>

        </div>
    <?php endwhile; ?>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
