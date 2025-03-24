<?php

include('../config.php');
include('../organizer/verify-org.php');

if(isset($_SESSION['org_id'])) {
    $org_id = $_SESSION['org_id'];
} else {
    header("Location: ../login/login.php");
        exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <ul>
                <li><a href="../dashboard/"></i> Home</a></li>
                <li><a href="add-event.php"><i class="fas fa-calendar-plus"></i> Add Event</a></li>
                <li><a href="../organizer/edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                <li><a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <div class="dashboard-content">
            <h1 class="title">Add Event</h1>
            <div class="event-form">
                <form method="POST" action="../event/add-event.php">
                    <label for="event_name">Event Title</label>
                    <input type="text" id="event_name" name="event_name" class="input" required>
                    
                    <label for="event_date">Date</label>
                    <input type="date" id="event_date" name="event_date" class="input" required>
                    
                    <label for="event_venue">Venue</label>
                    <input type="text" id="event_venue" name="event_venue" class="input" required>
                    
                    <label for="event_timestart">Start Time</label>
                    <input type="time" id="event_timestart" name="event_timestart" class="input" required>
                    
                    <label for="event_timeend">End Time</label>
                    <input type="time" id="event_timeend" name="event_timeend" class="input" required>

                    <input type="hidden" id="org_id" name="org_id" value="<?php echo $org_id; ?>">
                    
                    <input type="submit" name="submit" value="Add Event">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
