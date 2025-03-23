<?php
include('../config.php');
include('../organizer/verify-org.php');

if (!isset($_SESSION['org_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

// Fetch events from the database
$query = "SELECT event_name, event_date, event_venue FROM events WHERE org_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $org_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <ul>
                <li><a href="add-event.php"><i class="fas fa-calendar-plus"></i> Add Event</a></li>
                <li><a href="../organizer/edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                <li><a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <div class="dashboard-content">
            <h1 class="title">Event Dashboard</h1>
            <div class="event-list">
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['event_venue']); ?></td>
                                    <td>
                                        <button class="qr-btn">Show QR</button>
                                        <button class="edit-btn">Edit</button>
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No events found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
