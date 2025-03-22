<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/login-style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Register Your Organization</h1>
        <form method="POST" action="../organizer/add-org.php">
            <label for="org_name">Organization Name</label>
            <input type="text" id="org_name" name="org_name" class="input" required>
            
            <label for="org_email">Email Address</label>
            <input type="email" id="org_email" name="org_email" class="input" required>
            
            <label for="org_phone">Phone Number</label>
            <input type="tel" id="org_phone" name="org_phone" class="input" required>
            
            <label for="org_pass">Password</label>
            <input type="password" id="org_pass" name="org_pass" class="input" required>
            
            <label for="confirm_password">Re-enter Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="input" required>
            
            <input type="submit" name="submit" value="Register">
        </form>
        <span class="note">Already have an account? <a href="login.php">Login here</a></span>
    </div>
</body>
</html>