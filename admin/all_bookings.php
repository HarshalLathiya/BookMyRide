<?php
session_start();

// Admin Protection
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit;
}

include 'db.php';

// Fetch All Bookings with car details
$bookings = mysqli_query($conn, "SELECT b.*, c.name AS car_name, c.price_per_km FROM bookings b LEFT JOIN cars c ON b.car_id = c.car_id ORDER BY b.booking_id DESC");

// Calculate summary statistics
$summary_sql = "SELECT
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_bookings,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_bookings,
    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_bookings
    FROM bookings";

$summary_result = mysqli_query($conn, $summary_sql);
$summary = mysqli_fetch_assoc($summary_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Bookings - Admin Panel</title>

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

    /* Tabs */
    .tabs {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .tab {
        padding: 12px 24px;
        background: #e9e9f4;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        color: #444;
        transition: all 0.3s ease;
    }

    .tab:hover {
        background: #d0d0e0;
    }

    .tab.active {
        background: #5d5d81;
        color: white;
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
        min-width: 1200px;
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

    /* Status Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: capitalize;
        display: inline-block;
    }
    .badge-pending { background: #fff8e1; color: #ffc107; }
    .badge-completed { background: #e8f5e9; color: #28a745; }
    .badge-cancelled { background: #ffebee; color: #dc3545; }
    .badge-default { background: #f3e5f5; color: #6f42c1; }
    .badge-cash { background: #e8f5e9; color: #28a745; }
    .badge-online { background: #e3f2fd; color: #17a2b8; }
    .badge-credit { background: #fff8e1; color: #ffc107; }

    .hidden { display: none; }

    /* Responsive */
    @media (max-width: 768px) {
        .summary-dashboard {
            grid-template-columns: 1fr;
        }
        .tabs {
            justify-content: center;
        }
        table {
            min-width: 800px;
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
            <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
            <h3><?php echo $summary['total_bookings'] ?? 0; ?></h3>
            <p>Total Bookings</p>
        </div>
        <div class="summary-card">
            <div class="card-icon"><i class="fas fa-clock"></i></div>
            <h3><?php echo $summary['pending_bookings'] ?? 0; ?></h3>
            <p>Pending</p>
        </div>
        <div class="summary-card">
            <div class="card-icon"><i class="fas fa-check-circle"></i></div>
            <h3><?php echo $summary['completed_bookings'] ?? 0; ?></h3>
            <p>Completed</p>
        </div>
        <div class="summary-card">
            <div class="card-icon"><i class="fas fa-times-circle"></i></div>
            <h3><?php echo $summary['cancelled_bookings'] ?? 0; ?></h3>
            <p>Cancelled</p>
        </div>
    </div>

    <div class="container">

        <div class="header-section">
            <h1><i class="fas fa-calendar-alt"></i> All Bookings</h1>
        </div>

        <!-- TABS -->
        <div class="tabs">
            <div class="tab active" data-status="all">All Bookings</div>
            <div class="tab" data-status="Pending">Pending</div>
            <div class="tab" data-status="Completed">Completed</div>
            <div class="tab" data-status="Cancelled">Cancelled</div>
        </div>

    <!-- BOOKINGS TABLE -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user"></i> Customer</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-phone"></i> Phone</th>
                    <th><i class="fas fa-car"></i> Car</th>
                    <th><i class="fas fa-calendar-plus"></i> Pickup</th>
                    <th><i class="fas fa-calendar-minus"></i> Drop</th>
                    <th><i class="fas fa-map-marker-alt"></i> Pickup Location</th>
                    <th><i class="fas fa-map-marker-alt"></i> Drop Location</th>
                    <th><i class="fas fa-credit-card"></i> Payment</th>
                    <th><i class="fas fa-info-circle"></i> Status</th>
                </tr>
            </thead>

            <tbody>
            <?php while($row = mysqli_fetch_assoc($bookings)): ?>
                <tr data-status="<?= $row['status']; ?>">
                    <td><?= $row['booking_id']; ?></td>
                    <td><?= htmlspecialchars($row['full_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['car_name'] ?? $row['car_type']); ?></td>
                    <td><?= $row['pickup_date']; ?></td>
                    <td><?= $row['drop_date']; ?></td>
                    <td><?= htmlspecialchars($row['pickup_location']); ?></td>
                    <td><?= htmlspecialchars($row['drop_location']); ?></td>
                    <td><span class='badge badge-<?= strtolower($row['payment_method']); ?>'><?= htmlspecialchars($row['payment_method']); ?></span></td>

                    <td>
                        <select class="status-select" data-booking-id="<?= $row['booking_id']; ?>" onchange="updateStatus(this)">
                            <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="Cancelled" <?= $row['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </td>

                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>


<!-- FILTER JS -->
<script>
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {

        // Switch Active Class
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        let status = tab.getAttribute('data-status');

        // Filter Rows
        document.querySelectorAll('tbody tr').forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });

    });
});

// Update booking status
function updateStatus(selectElement) {
    const bookingId = selectElement.getAttribute('data-booking-id');
    const newStatus = selectElement.value;

    // Update the row's data-status attribute for filtering
    selectElement.closest('tr').setAttribute('data-status', newStatus);

    // Send AJAX request to update status in database
    fetch('update_booking_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `booking_id=${bookingId}&status=${newStatus}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Status updated successfully!', 'success');
            // Update summary statistics
            updateSummaryStats();
        } else {
            showNotification('Failed to update status.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating status.', 'error');
    });
}

// Show notification
function showNotification(message, type) {
    // Remove existing notification
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Style notification
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '12px 20px';
    notification.style.borderRadius = '8px';
    notification.style.fontWeight = '500';
    notification.style.zIndex = '1000';
    notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';

    if (type === 'success') {
        notification.style.background = '#d4edda';
        notification.style.color = '#155724';
        notification.style.border = '1px solid #c3e6cb';
    } else {
        notification.style.background = '#f8d7da';
        notification.style.color = '#721c24';
        notification.style.border = '1px solid #f5c6cb';
    }

    // Add to page
    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Update summary statistics
function updateSummaryStats() {
    fetch('get_booking_stats.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector('.summary-card:nth-child(1) h3').textContent = data.total_bookings;
            document.querySelector('.summary-card:nth-child(2) h3').textContent = data.pending_bookings;
            document.querySelector('.summary-card:nth-child(3) h3').textContent = data.completed_bookings;
            document.querySelector('.summary-card:nth-child(4) h3').textContent = data.cancelled_bookings;
        }
    })
    .catch(error => {
        console.error('Error updating stats:', error);
    });
}
</script>

</body>
</html>
