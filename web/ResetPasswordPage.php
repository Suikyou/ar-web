<?php
session_start();
include("config.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is provided and not empty
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        // Escape the email input
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        // Check if escaping was successful
        if($email === FALSE) {
            echo "Error escaping email: " . mysqli_error($conn);
            // Handle the error appropriately
        } else {
            // Check if the database connection is established
            if ($conn) {
                echo "Database connection successful"; // Debugging statement

                // Check if the email exists in the database
                $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

                echo "Check 1"; // Debugging statement
                
                if ($result) {
                    if(mysqli_num_rows($result) == 1) {
                        // Email exists in the database
                        echo "Check 1"; // Debugging statement
                        $_SESSION['reset_email'] = $email; // Store the email in the session
                        $row = mysqli_fetch_assoc($result);
                        $security_question = $row['security_question'];
                        $correct_security_answer = $row['security_answer'];
                        echo "Check 1"; // Debugging statement
                        echo "Done 1"; // Debugging statement
                        
                        // Prompt the user with the security question
                        // Prompt the user with the security question
                        echo "<script>
                        var email = '" . addslashes($email) . "'; // Store the email in a JavaScript variable
                        var securityAnswer = prompt('Please answer the following security question: " . addslashes($security_question) . "');
                        if (securityAnswer !== null) {
                            // Check if the provided security answer matches the correct one
                            if (securityAnswer === '" . addslashes($correct_security_answer) . "') {
                                // Redirect to reset confirm page with email
                                window.location.href = 'reset_password_confirm.php?email=' + encodeURIComponent(email);
                            } else {
                                alert('Incorrect security answer. Please try again.');
                                window.location.href = 'ResetPasswordPage.php';
                            }
                        } else {
                            // User cancelled or dismissed the prompt box, redirect back to password reset page
                            window.location.href = 'ResetPasswordPage.php';
                        }
                        </script>";
                              echo "Check 1"; // Debugging statement
                        exit();
                    } else {
                        // Email does not exist
                        echo "<script>alert('Email does not exist. Please try again.');</script>";
                    }
                } else {
                    // Error in database query
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                // Handle the case where the database connection is not established
                echo "Database connection error.";
            }
        }
    } else {
        echo "Email not provided or empty";
        // Handle the case where email is not provided
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Add your custom styles here -->
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<div class="container">
    <div class="box form-box">
        <header>Password Reset</header>
        <form method="POST" action="">
            <div class="field input">
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" autocomplete="off" placeholder="Enter your email" required>
            </div>
            <div class="field">
                <button type="submit" name="submit" class="btn">Submit</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
