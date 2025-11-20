<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered."]);
    } else {
        // Insert user
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $password);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registered successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Registration failed."]);
        }
    }
}
?>
