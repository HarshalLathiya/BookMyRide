<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}

include 'db.php';

// Fetch all non-admin customers
$sql = "SELECT id, fullname, email, created_at FROM users WHERE is_admin = 0 ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Calculate summary statistics
$summary_sql = "SELECT COUNT(*) as total_customers FROM users WHERE is_admin = 0";
$summary_result = mysqli_query($conn, $summary_sql);
$summary = mysqli_fetch_assoc($summary_result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Admin Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f1f3f7;
        }

        .main-content {
            padding: 20px;
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

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .header-section h1 {
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: 700;
            color: #5d5d81;
        }

        /* Table */
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
            min-width: 800px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        th {
            background: linear-gradient(135deg, #5d5d81, #a491a9);
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th i {
            margin-right: 8px;
        }

        tr:nth-child(even) td {
            background: #f8f9fa;
        }

        tr:hover td {
            background: #e3f2fd;
            transition: background 0.3s ease;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #8a8a9d;
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .summary-dashboard {
                grid-template-columns: 1fr;
            }
            table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body>

<div class="main-content">

    <!-- Back Button -->
    <a href="dashboard_admin.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

    <!-- Summary Dashboard -->
    <div class="summary-dashboard">
        <div class="summary-card">
            <div class="card-icon"><i class="fas fa-users"></i></div>
            <h3><?php echo $summary['total_customers'] ?? 0; ?></h3>
            <p>Total Customers</p>
        </div>
    </div>

    <div class="container">

        <div class="header-section">
            <h1><i class="fas fa-user-friends"></i> Registered Customers</h1>
        </div>

        <!-- CUSTOMERS TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> Customer ID</th>
                        <th><i class="fas fa-user"></i> Full Name</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-calendar-alt"></i> Joined On</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['fullname']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="no-data"><i class="fas fa-users"></i> No customers found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
