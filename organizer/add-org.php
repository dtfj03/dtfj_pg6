<?php
session_start();
include('../config.php');

class AddOrganizerController { 
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($inputData) {
        $org_name = $inputData['org_name'];
        $org_email = $inputData['org_email'];
        $org_phone = $inputData['org_phone'];
        $org_pass = password_hash($inputData['org_pass'], PASSWORD_DEFAULT); // Hash the password

        $query = "INSERT INTO organizer (org_name, org_email, org_phone, org_pass) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $org_name, $org_email, $org_phone, $org_pass);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result; // Return true if successful, false otherwise
    }
}

if(isset($_POST['submit'])) {
    if(!empty($_POST['org_name']) && !empty($_POST['org_email']) && !empty($_POST['org_phone']) && !empty($_POST['org_pass']) && !empty($_POST['confirm_password'])) {
        $org_name = $_POST['org_name'];
        $org_email = $_POST['org_email'];
        $org_phone = $_POST['org_phone'];
        $org_pass = $_POST['org_pass'];
        $confirm_password = $_POST['confirm_password'];

        // Check if passwords match
        if ($org_pass !== $confirm_password) {
            $_SESSION['message'] = "Passwords do not match!";
            header("Location: ../login/register.php"); // Redirect back to registration
            exit;
        }

        $registerOrganizer = new AddOrganizerController($conn);

        $inputData = [
            'org_name' => $org_name,
            'org_email' => $org_email,
            'org_phone' => $org_phone,
            'org_pass' => $org_pass
        ];

        $result = $registerOrganizer->create($inputData);

        if($result) {
            $_SESSION['message'] = "Account added successfully";
            header("Location: ../login/login.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to add account";
            header("Location: ../register.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Fill up required details";
        header("Location: ../register.php");
        exit;
    }
}
?>
