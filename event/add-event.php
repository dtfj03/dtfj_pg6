<?php
session_start();
include('../config.php');

class AddEventController { 
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($inputData) {
        $event_name = $inputData['event_name'];
        $event_date = $inputData['event_date'];
        $event_venue = $inputData['event_venue'];
        $event_timestart = $inputData['event_timestart'];
        $event_timeend = $inputData['event_timeend'];
        $org_id = $inputData['org_id'];


        $query = "INSERT INTO event (event_name, event_date, event_venue, event_timestart, event_timeend, org_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $event_name, $event_date, $event_venue, $event_timestart, $event_timeend, $org_id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result; // Return true if successful, false otherwise
    }
}

if(isset($_POST['submit'])) {
    if(!empty($_POST['event_name']) && !empty($_POST['event_date']) && !empty($_POST['event_venue']) && !empty($_POST['event_timestart']) && !empty($_POST['event_timeend']) && !empty($_POST['org_id'])) {
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $event_venue = $_POST['event_venue'];
        $event_timestart = $_POST['event_timestart'];
        $event_timeend = $_POST['event_timeend'];
        $org_id = $_POST['org_id'];

        $addEvent = new AddEventController($conn);

        $inputData = [
            'event_name' => $event_name,
            'event_date' => $event_date,
            'event_venue' => $event_venue,
            'event_timestart' => $event_timestart,
            'event_timeend' => $event_timeend,
            'org_id' => $org_id
        ];

        $result = $addEvent->create($inputData);

        if($result) {
            $_SESSION['message'] = "Event added successfully";
            header("Location: ../dashboard/index.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to add Event";
            header("Location: ../dashboard/add-event.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Fill up required details";
        header("Location: ../dashboard/add-event.php");
        exit;
    }
}
?>
