<?php
session_start();
include('../config.php');

// Ensure user is logged in
if (!isset($_SESSION['org_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

// Check database connection
if (!$conn || $conn->connect_error) {
    die("Database connection failed: " . ($conn ? $conn->connect_error : "Invalid connection object"));
}

// Prepare SQL statement
$sql = "SELECT org_name, org_email, org_phone FROM organizer WHERE org_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare Failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("s", $org_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['org_name'];
    $email = $row['org_email'];
    $phone = $row['org_phone'];
} else {
    die("Error: Organizer not found.");
}

// Close statement
$stmt->close();
?>
