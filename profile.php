<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

include 'db.php';

// Fetch user details
$stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE id = ?");
if (!$stmt) {
  die("User query failed: " . $conn->error);
}
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

// Fetch bookings
$bookings = [];
$bookStmt = $conn->prepare("SELECT car_type, pickup_date, drop_date, pickup_location, drop_location FROM bookings WHERE email = ?");
if (!$bookStmt) {
  die("Booking query failed: " . $conn->error);
}
$bookStmt->bind_param("s", $user['email']);
$bookStmt->execute();
$bookingsResult = $bookStmt->get_result();
while ($row = $bookingsResult->fetch_assoc()) {
  $bookings[] = $row;
}

// Handle logout
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit;
}

// Handle profile update
$updateMsg = "";
$redirectNow = false;

if (isset($_POST['save'])) {
  $newUsername = $_POST['username'];
  $newEmail = $_POST['email'];
  $newPassword = $_POST['password'];

  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

  $updateStmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
  if (!$updateStmt) {
    $updateMsg = "Update failed: " . $conn->error;
  } else {
    $updateStmt->bind_param("sssi", $newUsername, $newEmail, $hashedPassword, $_SESSION['user_id']);
    if ($updateStmt->execute()) {
      $updateMsg = "Profile updated successfully. Redirecting...";
      $user['username'] = $newUsername;
      $user['email'] = $newEmail;
      $user['password'] = $hashedPassword;
      $redirectNow = true;
    } else {
      $updateMsg = "Update failed.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Profile - BookMyRide</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #141313, #2b2b2b);
      color: #fff;
      padding: 40px;
    }
    .profile-box {
      max-width: 800px;
      margin: auto;
      background: rgba(255, 255, 255, 0.05);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.4);
    }
    h2 {
      font-size: 26px;
      margin-bottom: 20px;
      color: #f0f0f0;
    }
    p, label {
      font-size: 16px;
      margin: 8px 0;
      color: #ccc;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 6px;
      border: none;
      background: rgba(255,255,255,0.1);
      color: #fff;
    }
    table {
      width: 100%;
      margin-top: 30px;
      border-collapse: collapse;
      background: rgba(255,255,255,0.03);
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
      text-align: left;
      color: #eee;
    }
    th {
      background: rgba(255,255,255,0.1);
    }
    .btn {
      margin-top: 10px;
      padding: 10px 20px;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }
    .btn:hover {
      background: #333;
    }
    .message {
      color: #0f0;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="profile-box">
    <h2>My Profile</h2>

    <?php if (!isset($_GET['edit'])): ?>
      <p><strong>ID:</strong> <?= $user['id'] ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Password:</strong> ********</p>
      <form method="post" style="display:inline;">
        <button type="submit" name="logout" class="btn">Logout</button>
      </form>
      <a href="?edit=1" class="btn">Edit Profile</a>
    <?php else: ?>
      <form method="post">
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <label>New Password (optional):</label>
<input type="password" name="password" placeholder="Leave blank to keep current">

       <button type="submit" name="save" class="btn">Save</button>
<a href="profile.php" class="btn">Back</a>

        <?php if ($updateMsg): ?>
          <div class="message"><?= $updateMsg ?></div>
        <?php endif; ?>
      </form>
    <?php endif; ?>	
	

    <h2>Your Bookings</h2>
    <?php if (count($bookings) > 0): ?>
      <table>
        <tr>
          <th>Car Type</th>
          <th>Pickup Date</th>
          <th>Drop Date</th>
          <th>Pickup Location</th>
          <th>Drop Location</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
          <tr>
            <td><?= htmlspecialchars($booking['car_type']) ?></td>
            <td><?= htmlspecialchars($booking['pickup_date']) ?></td>
            <td><?= htmlspecialchars($booking['drop_date']) ?></td>
            <td><?= htmlspecialchars($booking['pickup_location']) ?></td>
            <td><?= htmlspecialchars($booking['drop_location']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php else: ?>
      <p>No bookings found.</p>
    <?php endif; ?>
	<a href="index.php" class="btn">Back to Dashboard</a>

  </div>
  
  


  <?php if ($redirectNow): ?>
    <script>
      setTimeout(function() {
        window.location.href = "profile.php";
      }, 2000);
    </script>
  <?php endif; ?>
</body>
</html>
