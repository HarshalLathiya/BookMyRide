<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: register.php");
    exit();
}
include("includes/header.php");
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BookMyRide - Home</title>
<link rel="stylesheet" href="assets/css/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- BANNER -->
<section class="banner">
  <img src="assets/images/banner.png" alt="Banner Image" class="banner-image">

  <div class="hero-content">
    <h1>Welcome to BookMyRide</h1>
    <p>Experience the freedom of the open road with our premium car rental service. Choose from our wide range of vehicles and embark on your next adventure.</p>
    <a href="booking.php" class="btn btn-primary">Book Your Ride</a>
  </div>
</section>


<!-- CHOOSE CARS -->
<section class="section">
<h2>Choose Cars</h2>

<div class="car-grid">
<?php
function getStatus($conn, $carName) {
    $stmt = $conn->prepare("SELECT car_id, status FROM cars WHERE name = ? LIMIT 1");
    $stmt->bind_param("s",$carName);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ?: ['car_id'=>null,'status'=>'unavailable'];
}

$carData = [
    'ertiga' => 'assets/images/ertiga.jpg',
    'Innova' => 'assets/images/innova.jpg',
    'swift'  => 'assets/images/swift.jpg',
    'Scorpio' => 'assets/images/Scorpio.avif',
    'Fortuner' => 'assets/images/fortuner.avif',
    'Thar'   => 'assets/images/thar_roxx.avif'
];

foreach($carData as $car => $image){
    $status = getStatus($conn,$car);

    echo '<div class="car-card">
            <img src="'.$image.'" alt="'.$car.'">
            <div class="info">
              <h3>'.$car.'</h3>
              <p>Drive with style and unmatched comfort.</p>';

    if($status['status'] === 'available'){
        echo '<a href="booking.php?car_id='.$status['car_id'].'">
                <button class="btn">Book Now</button>
              </a>';
    } else {
        echo '<div class="unavailable">🚫 Already Booked</div>';
    }

    echo '</div></div>';
}
?>
</div>
</section>


<!-- WHY CHOOSE -->
<section class="section why-choose">
<h2>Why Choose BookMyRide</h2>

<div class="features-grid">

    <div class="feature-card">
      <i class="fas fa-shield-alt"></i>
      <h3>Safe & Reliable</h3>
      <p>Well-maintained vehicles with comprehensive insurance coverage for your peace of mind.</p>
    </div>

    <div class="feature-card">
      <i class="fas fa-rupee-sign"></i>
      <h3>Affordable Pricing</h3>
      <p>Competitive rates with transparent pricing and no hidden charges.</p>
    </div>

    <div class="feature-card">
      <i class="fas fa-clock"></i>
      <h3>24/7 Support</h3>
      <p>Round-the-clock customer support to assist you anytime, anywhere.</p>
    </div>

    <div class="feature-card">
      <i class="fas fa-car"></i>
      <h3>Wide Range</h3>
      <p>Choose from our diverse fleet of cars to suit your needs and preferences.</p>
    </div>

    <div class="feature-card">
      <i class="fas fa-map-marker-alt"></i>
      <h3>Flexible Locations</h3>
      <p>Pickup and drop-off at convenient locations across the city.</p>
    </div>

    <div class="feature-card">
      <i class="fas fa-star"></i>
      <h3>Quality Service</h3>
      <p>Committed to providing exceptional service and memorable experiences.</p>
    </div>

</div>
</section>

<?php include("includes/footer.php"); ?>
</body>
</html>
