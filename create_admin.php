<?php

$conn = new mysqli(
    "127.0.0.1",
    "root",
    "",
    "user_management_db",
    6666
);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$name = "Administrator";
$email = "admin@example.com";

$password = "Admin@123";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$role = "ADMIN";
$status = "ACTIVE";

$sql = "INSERT INTO users (name, email, password, role, status)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssss",
    $name,
    $email,
    $hashed_password,
    $role,
    $status
);

if ($stmt->execute()) {
    echo "ADMIN account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>