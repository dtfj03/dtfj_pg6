<?php
session_start();
include('../config.php');
include('../organizer/verify-org.php');

// Ensure user is logged in
if (!isset($_SESSION['org_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Retrieve session org_id
$org_id = $_SESSION['org_id'];

// Debug: Check if database connection is valid
if (!$conn || $conn->connect_error) {
    die("Database connection failed: " . ($conn ? $conn->connect_error : "Invalid connection object"));
}

// Prepare the SQL statement
$sql = "SELECT org_name, org_email, org_phone FROM organizer WHERE org_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare Failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("s", $org_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data if exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['org_name'];
    $email = $row['org_email'];
    $phone = $row['org_phone'];
} else {
    die("Error: Organizer not found.");
}

// Close the statement
$stmt->close();
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <ul>
                <li><a href="add-event.php"><i class="fas fa-calendar-plus"></i> Add Event</a></li>
                <li><a href="edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                <li><a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <div class="dashboard-content">
            <h1 class="title">Edit Profile</h1>
            <div class="profile-form">
                <form method="POST" action="update-profile.php">
                    <input type="hidden" id="org_id" name="org_id" value="<?php echo $org_id; ?>">    

                    <label for="name">Name</label>
                    <input type="text" id="org_name" name="org_name" class="input" value="<?php echo $name; ?>" required>
                    
                    <label for="email">Email</label>
                    <input type="email" id="org_email" name="org_email" class="input" value="<?php echo $email; ?>"required>
                    
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="org_phone" name="org_phone" class="input" value="<?php echo $phone; ?>" required>
                    
                    <input type="submit" name="submit" value="Update Profile">
                    
                    <h2 class="title">Change Password</h2>
                    
                    <label for="old_password">Old Password</label>
                    <input type="password" id="old_password" name="old_password" class="input" required>
                    
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="input" required>
                    
                    <label for="confirm_password">Re-enter New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="input" required>
                    
                    <input type="submit" name="change_password" value="Change Password">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
