<?php
session_start(); // Start session
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from the form
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT org_id, org_pass FROM organizer WHERE org_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['org_pass'];

        // Verify password with the hashed version
        if (password_verify($password, $hashed_password)) {
            $_SESSION['org_id'] = $row['org_id']; // Store org_id in session
            
            // Redirect to dashboard
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password!";
        }
    } else {
        $_SESSION['message'] = "User not found!";
    }

    // Redirect back to login page with error
    header("Location: ../login/login.php");
    exit();
}

// Close database connection
$conn->close();
?>
