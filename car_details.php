<?php
// car_details.php
// Full premium car details page (responsive, gallery, specs, price card)
// Requires: db.php (mysqli $conn), includes/header.php, includes/footer.php

include 'db.php';
include 'includes/header.php';

if (!isset($_GET['car_id']) || !is_numeric($_GET['car_id'])) {
    http_response_code(400);
    echo "<p style='padding:40px;font-family:Arial;'>Bad request: car_id required.</p>";
    exit;
}

$car_id = (int)$_GET['car_id'];

// Fetch car record
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ? LIMIT 1");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    http_response_code(404);
    echo "<p style='padding:40px;font-family:Arial;'>Car not found.</p>";
    exit;
}

if (!empty($car['images'])) {
    // If images stored as comma-separated filenames (e.g. "fort1.jpg,fort2.jpg")
    $imgs = explode(',', $car['images']);
    foreach ($imgs as $im) {
        $im = trim($im);
        if ($im !== '') $images_array[] = "assets/images/{$im}";
    }
}
if (empty($images_array) && !empty($car['image'])) {
    $images_array[] = "assets/images/" . trim($car['image']);
}

// Fallback local uploaded image path (from your uploaded file)
$fallback_local = "/mnt/data/af82de73-90e5-4c7c-af3f-51c66908373d.png";
if (empty($images_array)) {
    $images_array[] = $fallback_local;
}

// Safe helpers
function esc($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
$status = strtolower($car['status'] ?? 'unavailable');
$available = ($status === 'available');

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?= esc($car['name']) ?> — BookMyRide</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/car_details.css" />
</head>
<body>

<div class="wrap">
  <div class="card">

    <!-- Car Image (One Medium Sized) -->
<div class="car-image-container">
    <img src="assets/images/<?= htmlspecialchars($car['image']); ?>" 
         alt="<?= htmlspecialchars($car['name']); ?>" 
         class="car-main-image">
</div>


    <div class="content">

      <!-- LEFT: details -->
      <div class="left" style="padding:0 28px 28px 28px;">
        <h1><?= esc($car['name']) ?></h1>

        <div class="meta">
          <div class="tag"><i class="fas fa-tag" style="margin-right:8px"></i> <?= esc($car['category']) ?></div>
          <div class="tag"><i class="fas fa-calendar-alt" style="margin-right:8px"></i> <?= esc(substr($car['created_at'] ?? '',0,10) ?: '—') ?></div>
          <div class="tag"><i class="fas fa-user" style="margin-right:8px"></i> Seats: <?= esc($car['seating_capacity'] ?? $car['seats'] ?? '—') ?></div>
        </div>

        <div class="spec-grid">
          <div class="spec">
            <i class="fas fa-car-side"></i>
            <div class="label">Category</div>
            <div class="val"><?= esc($car['category']) ?></div>
          </div>

          <div class="spec">
            <i class="fas fa-gas-pump"></i>
            <div class="label">Fuel</div>
            <div class="val"><?= esc($car['fuel_type'] ?? 'Petrol') ?></div>
          </div>

          <div class="spec">
            <i class="fas fa-cogs"></i>
            <div class="label">Transmission</div>
            <div class="val"><?= esc($car['transmission'] ?? 'Manual') ?></div>
          </div>

          <div class="spec">
            <i class="fas fa-users"></i>
            <div class="label">Seats</div>
            <div class="val"><?= esc($car['seating_capacity'] ?? $car['seats'] ?? '5') ?></div>
          </div>

          <div class="spec">
            <i class="fas fa-tachometer-alt"></i>
            <div class="label">Mileage</div>
            <div class="val"><?= esc($car['mileage'] ?? '—') ?></div>
          </div>

          <div class="spec">
            <i class="fas fa-cog"></i>
            <div class="label">Engine</div>
            <div class="val"><?= esc($car['engine'] ?? '—') ?></div>
          </div>
        </div>

        <div class="desc">
          <h3 style="margin:14px 0 8px;color:#333;font-size:18px;">Description</h3>
          <p><?= nl2br(esc($car['description'] ?? 'No description available.')) ?></p>
        </div>

        <div class="info-row">
          <div class="item"><i class="fas fa-calendar-check" style="color:var(--muted)"></i> <span>Added: <?= esc(substr($car['created_at'] ?? '',0,10) ?: '—') ?></span></div>
          <div class="item"><i class="fas fa-info-circle" style="color:var(--muted)"></i> <span>Status: <strong><?= esc(ucfirst($car['status'] ?? 'unavailable')) ?></strong></span></div>
        </div>

        <div style="margin-top:22px;" class="features">
          <?php
            $features = [];
            if(!empty($car['abs'])) $features[] = 'ABS';
            if(!empty($car['ac'])) $features[] = 'Air Conditioning';
            if(!empty($car['music'])) $features[] = 'Music System';
            if(!empty($car['gps'])) $features[] = 'GPS';
            if(!empty($car['child_seat'])) $features[] = 'Child Seat';
            // If DB doesn't have these, features may be empty
            if(empty($features)) $features = [$car['category'].' class', 'Well maintained', 'Insurance included'];
            foreach($features as $f) echo "<div class='feature-pill'>".esc($f)."</div>";
          ?>
        </div>
      </div>

      <!-- RIGHT: price & booking -->
      <div style="padding:28px;">
        <div class="price-card">
          <h3>Rent this car</h3>
          <div class="price">₹ <?= esc($car['price_per_day'] ?? '0') ?></div>
          <div class="per">per day</div>

          <?php if($available): ?>
            <a class="book-btn" href="booking.php?car=<?= urlencode($car['name']) ?>"><i class="fas fa-calendar-plus" style="margin-right:8px"></i> Book Now</a>
            <div class="status available">Available — Book instantly</div>
          <?php else: ?>
            <div class="book-btn" style="background:#ddd;color:#666;cursor:not-allowed">Already Booked</div>
            <div class="status booked">Not available right now</div>
          <?php endif; ?>

          <div style="height:1px;margin:16px 0;background:rgba(255,255,255,0.12)"></div>

          <!-- Extra contact / note -->
          <div style="font-size:14px;opacity:0.95;">
            <div style="margin-bottom:8px;"><i class="fas fa-phone" style="margin-right:8px"></i> Need help with booking? Call: <strong>+91-8401953920</strong></div>
            <div style="margin-bottom:8px;"><i class="fas fa-shield-alt" style="margin-right:8px"></i> Insurance & taxes included</div>
            <div><i class="fas fa-map-marker-alt" style="margin-right:8px"></i> Pickup: Amreli (on request)</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
