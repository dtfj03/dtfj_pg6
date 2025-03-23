<?php
include('../config.php');


class UpdateProfileController { 
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($inputData) {
        $org_id = $inputData['org_id'];
        $org_name = $inputData['org_name'];
        $org_email = $inputData['org_email'];
        $org_phone = $inputData['org_phone'];

        $query = "UPDATE organizer SET org_name=?, org_email=?, org_phone=? WHERE org_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $org_name, $org_email, $org_phone, $org_id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result; // Return true if successful, false otherwise
    }
}

if(isset($_POST['submit'])) {
    if(!empty($_POST['org_name']) && !empty($_POST['org_email']) && !empty($_POST['org_pass']) && !empty($_POST['org_id']))
        $org_name = $_POST['org_name'];
        $org_email = $_POST['org_email'];
        $org_phone = $_POST['org_phone'];
        $org_id = $_POST['org_id'];
        

        $addEvent = new UpdateProfileController($conn);

        $inputData = [
            'org_name' => $org_name,
            'org_email' => $org_email,
            'org_phone' => $org_phone,
            'org_id' => $org_id
        ];

        $result = $addEvent->create($inputData);

        if($result) {
            $_SESSION['message'] = "Profile updated successfully";
            header("Location: ../dashboard/index.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to upadte profile";
            header("Location: ../organizer/edit-profile");
            exit;
        }
    } else {
        $_SESSION['message'] = "Fill up required details";
        header("Location: ../organizer/edit-profile");
        exit;
    }

// Change Password

class ChangePasswordController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updatePassword($inputData) {
        $org_id = $inputData['org_id'];
        $old_password = $inputData['old_password'];
        $new_password = password_hash($inputData['new_password'], PASSWORD_BCRYPT);
        $stored_password = "";

        // Check if old password matches
        $query = "SELECT org_pass FROM organizer WHERE org_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $org_id);
        $stmt->execute();
        
        // Bind the result to a variable
        $stmt->bind_result($stored_password);
        
        // Fetch the result
        if ($stmt->fetch()) {
            if (password_verify($old_password, $stored_password)) {
                // Update password
                $update_query = "UPDATE organizer SET org_pass=? WHERE org_id=?";
                $update_stmt = $this->conn->prepare($update_query);
                $update_stmt->bind_param("ss", $new_password, $org_id);
                $result = $update_stmt->execute();
                $update_stmt->close();
                return $result; // Return true if successful, false otherwise
            } else {
                return false; // Incorrect old password
            }
        }
        
        return false; // User not found
    }
}

if(isset($_POST['change_password'])) {
    if(!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password']) && !empty($_POST['org_id'])) {
        $org_id = $_POST['org_id'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($new_password !== $confirm_password) {
            $_SESSION['message'] = "New passwords do not match";
            header("Location: ../organizer/edit-profile.php");
            exit;
        }

        $changePassword = new ChangePasswordController($conn);
        $inputData = [
            'org_id' => $org_id,
            'old_password' => $old_password,
            'new_password' => $new_password
        ];

        $result = $changePassword->updatePassword($inputData);

        if($result) {
            $_SESSION['message'] = "Password updated successfully";
            header("Location: ../dashboard/index.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to update password. Check your old password.";
            header("Location: ../organizer/edit-profile.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Fill up required details";
        header("Location: ../organizer/edit-profile.php");
        exit;
    }
}
?>
