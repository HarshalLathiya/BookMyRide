<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}

include 'db.php';

// Fetch all booking + car details
$sql = "SELECT b.booking_id, b.full_name, b.email, b.phone, 
        c.name AS car_name, c.category, c.price_per_day,
        b.pickup_date, b.drop_date, b.pickup_location, b.drop_location, b.payment_method
        FROM bookings b
        LEFT JOIN cars c ON b.car_id = c.car_id
        ORDER BY b.pickup_date DESC";

$result = mysqli_query($conn, $sql);

// Calculate summary statistics
$summary_sql = "SELECT 
    COUNT(*) as total_bookings,
    SUM(c.price_per_day * DATEDIFF(b.drop_date, b.pickup_date)) as total_revenue,
    COUNT(DISTINCT b.car_id) as unique_cars
    FROM bookings b
    LEFT JOIN cars c ON b.car_id = c.car_id";

$summary_result = mysqli_query($conn, $summary_sql);
$summary = mysqli_fetch_assoc($summary_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Report - Admin Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>
       .main-content {
    margin-left: 0 !important;
    padding-left: 0 !important;
    width: 100%;
}

.report-container {
    max-width: 1200px;
    margin: auto;
}


        /* Summary Dashboard */
        .summary-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .summary-card .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #5d5d81, #a491a9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px;
        }

        .summary-card h3 {
            font-size: 2rem;
            margin-bottom: 5px;
            color: #1f1f1f;
        }

        .summary-card p {
            color: #8a8a9d;
            font-size: 0.95rem;
            margin: 0;
        }

        /* Centering the whole table area */
        .report-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Back button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #5d5d81, #a491a9);
            color: white;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Report Header */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .report-header h1 {
            font-size: 32px;
            font-weight: 600;
            color: #5d5d81;
            margin: 0;
        }

        .report-subtitle {
            font-size: 22px;
            font-weight: 600;
            margin: 25px 0;
            color: #1f1f1f;
        }

        /* Table Styling */
        .table-container {
            width: 100%;
            overflow-x: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(135deg, #5d5d81, #a491a9);
            color: white;
            padding: 16px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        th i {
            margin-right: 8px;
        }

        td {
            padding: 14px 16px;
            text-align: center;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:nth-child(even) td {
            background: #f8f9fa;
        }

        tr:hover td {
            background: #e3f2fd;
            transition: background 0.3s ease;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-block;
        }

        .badge-cash {
            background: #e8f5e9;
            color: #28a745;
        }

        .badge-online {
            background: #e3f2fd;
            color: #17a2b8;
        }

        .badge-credit {
            background: #fff8e1;
            color: #ffc107;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .summary-dashboard {
                grid-template-columns: 1fr;
            }
            .report-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            table {
                min-width: 800px;
            }
        }
    </style>

</head>

<body>

<div class="main-content">

    <div class="report-wrapper">

        <!-- Back Button -->
        <a href="dashboard_admin.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

        <!-- Summary Dashboard -->
        <div class="summary-dashboard">
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                <h3><?php echo $summary['total_bookings'] ?? 0; ?></h3>
                <p>Total Bookings</p>
            </div>
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-rupee-sign"></i></div>
                <h3>₹<?php echo number_format($summary['total_revenue'] ?? 0); ?></h3>
                <p>Total Revenue</p>
            </div>
            <div class="summary-card">
                <div class="card-icon"><i class="fas fa-car"></i></div>
                <h3><?php echo $summary['unique_cars'] ?? 0; ?></h3>
                <p>Cars Booked</p>
            </div>
        </div>

        <div class="report-subtitle">All Booking Records</div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>BOOKING ID</th>
                        <th>FULL NAME</th>
                        <th>EMAIL</th>
                        <th>PHONE</th>
                        <th>CAR NAME</th>
                        <th>CATEGORY</th>
                        <th>PRICE/DAY</th>
                        <th>PICKUP DATE</th>
                        <th>DROP DATE</th>
                        <th>PICKUP LOCATION</th>
                        <th>DROP LOCATION</th>
                        <th>PAYMENT METHOD</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>
                                <td>".$row['booking_id']."</td>
                                <td>".htmlspecialchars($row['full_name'])."</td>
                                <td>".htmlspecialchars($row['email'])."</td>
                                <td>".htmlspecialchars($row['phone'])."</td>
                                <td>".htmlspecialchars($row['car_name'])."</td>
                                <td>".htmlspecialchars($row['category'])."</td>
                                <td>₹".$row['price_per_day']."</td>
                                <td>".$row['pickup_date']."</td>
                                <td>".$row['drop_date']."</td>
                                <td>".htmlspecialchars($row['pickup_location'])."</td>
                                <td>".htmlspecialchars($row['drop_location'])."</td>
                                <td><span class='badge badge-".strtolower($row['payment_method'])."'>".htmlspecialchars($row['payment_method'])."</span></td>
                             </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No bookings found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
