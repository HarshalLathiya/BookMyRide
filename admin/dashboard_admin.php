<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}

include 'db.php'; // DB connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BookMyRide</title>

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
            <li><a href="dashboard_admin.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="View_cars.php"><i class="fas fa-car"></i> Cars</a></li>
            <li><a href="all_bookings.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
            <li><a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">

        <div class="header">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
                <div><?php echo $_SESSION['user_name']; ?></div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="dashboard-cards">

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>
                    <?php 
                    $car_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM cars");
                    echo mysqli_fetch_assoc($car_count)['count'];
                    ?>
                </h3>
                <p>Total Cars</p>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>
                    <?php 
                    $booking_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings");
                    echo mysqli_fetch_assoc($booking_count)['count'];
                    ?>
                </h3>
                <p>Total Bookings</p>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>
                    <?php 
                    $user_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
                    echo mysqli_fetch_assoc($user_count)['count'];
                    ?>
                </h3>
                <p>Total Users</p>
            </div>

        </div>

    </div>
</div>

</body>
</html>
