<?php
session_start();
// After session_start(), add debugging output
//var_dump($_SESSION['reset_email']);

// Include the database conn file
include("config.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the new password and confirm password fields are set
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if the new password and confirm password match
        if ($new_password === $confirm_password) {
            // Retrieve the user's email from the session
            if (isset($_SESSION['reset_email'])) {
                $email = $_SESSION['reset_email'];

                // Hash the new password before updating the database
                $hashed_password = sha1($new_password);

                // Perform the password update query
                $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";

                if (mysqli_query($conn, $update_query)) {
                    // Password updated successfully
                    echo "<script>
                            alert('Password reset successful.');
                            window.location.href = 'LoginPage.php'; // Redirect to your success page
                          </script>";
                }  else {
                    // Error updating password
                    echo "<script>alert('Error resetting password: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                // Email not found in session
                echo "<script>alert('Email not found.');</script>";
            }
        } else {
            // Passwords don't match
            echo "<script>alert('Passwords do not match. Please try again.');</script>";
        }
    } else {
        // New password or confirm password fields not set
        echo "<script>alert('New password or confirm password fields are not set.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Confirmation</title>
    <!-- Add your custom styles here -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Password Reset</header>
            <form method="POST" action="">
                <div class="field input">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" autocomplete="off" placeholder="Enter your new password" required>
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="off" placeholder="Confirm your new password" required>
                </div>
                <div class="field">
                    <button type="submit" name="submit" class="btn">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
