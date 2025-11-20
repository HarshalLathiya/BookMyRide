<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection

$response = ['status' => 'error', 'message' => 'Something went wrong!'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required.';
        echo json_encode($response);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address.';
        echo json_encode($response);
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $response['message'] = 'No user found with this email.';
        echo json_encode($response);
        exit;
    }

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password in the database
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $hashedPassword, $email);
    $updateStmt->execute();

    $response['status'] = 'success';
    $response['message'] = 'Password updated successfully!';
    echo json_encode($response);
    exit;
} else {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}
?>
