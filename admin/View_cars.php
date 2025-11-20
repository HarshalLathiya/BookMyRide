<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}
include 'db.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM cars WHERE car_id = $delete_id");
    header("Location: View_cars.php");
    exit;
}

// Handle status toggle
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    $select_stmt = $conn->prepare("SELECT status FROM cars WHERE car_id = ?");
    $select_stmt->bind_param("i", $toggle_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ($result->num_rows > 0) {
        $current = $result->fetch_assoc()['status'];
        $new_status = $current == 'available' ? 'booked' : 'available';
        $update_stmt = $conn->prepare("UPDATE cars SET status = ? WHERE car_id = ?");
        $update_stmt->bind_param("si", $new_status, $toggle_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
    $select_stmt->close();
    header("Location: View_cars.php");
    exit;
}

$result = $conn->query("SELECT * FROM cars ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Cars - Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-container">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>BookMyRide</h2>
      <p>Admin Panel</p>
    </div>

    <ul class="nav-links">
      <li><a href="dashboard_admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="View_cars.php" class="active"><i class="fas fa-car"></i> Cars</a></li>
      <li><a href="all_bookings.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
      <li><a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
      <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h1>Manage Cars</h1>
      <div class="user-info">
        <div class="user-avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
        <div><?php echo $_SESSION['user_name']; ?></div>
      </div>
    </div>

    <div class="content-section">
      <div class="section-header">
        <h2>All Added Cars</h2>
        <a href="Add_car.php" class="btn btn-primary">Add New Car</a>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price per Day</th>
              <th>Status</th>
              <th>Added On</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($car = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $car['car_id']; ?></td>
                <td><img src="../assets/images/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>" width="100" style="border-radius: 8px;"></td>
                <td><?php echo htmlspecialchars($car['name']); ?></td>
                <td><?php echo $car['category']; ?></td>
                <td>₹<?php echo number_format($car['price_per_day'], 2); ?></td>
                <td>
                  <span class="badge <?php echo $car['status'] == 'available' ? 'badge-success' : 'badge-danger'; ?>">
                    <?php echo $car['status']; ?>
                  </span>
                </td>
                <td><?php echo date('d M Y, h:i A', strtotime($car['created_at'])); ?></td>
                <td>
                  <a href="Edit_car.php?car_id=<?php echo $car['car_id']; ?>">
                    <button class="action-btn edit-btn">Edit</button>
                  </a>
                  <a href="View_cars.php?toggle=<?php echo $car['car_id']; ?>" onclick="return confirm('Are you sure you want to toggle the status of this car?');">
                    <button class="action-btn toggle-btn">Toggle Status</button>
                  </a>
                  <a href="View_cars.php?delete=<?php echo $car['car_id']; ?>" onclick="return confirm('Are you sure you want to delete this car?');">
                    <button class="action-btn delete-btn">Delete</button>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
