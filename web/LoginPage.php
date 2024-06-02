<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("config.php");

include("session.php");

if(isset($_SESSION['valid'])){
    header("Location: LoginPage.php");
}

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    $hash_password = SHA1($password);

    // Adjusted query to use user_id if that's the correct column name
    $userResult = mysqli_query($conn, "SELECT user_id, username, user_type FROM users WHERE username='$username' AND password='$hash_password' AND user_type='$user_type'");

    if (!$userResult) {
        echo "Error: " . mysqli_error($conn);
    }

    $userRow = mysqli_fetch_assoc($userResult);

    if(is_array($userRow) && !empty($userRow)){
        $_SESSION['id'] = $userRow['user_id'];
        $_SESSION['valid'] = $userRow['username'];
        $_SESSION['user_type'] = $userRow['user_type'];

        if($userRow['user_type'] == 3) {
            header('location:admin.php');
        } else if($userRow['user_type'] == 1 || $userRow['user_type'] == 2) {
            header('location:Dashboard.php');
        }
    } else {
        echo "<div class='message'>
                <p>Incorrect Username, Password, or User Type. Please try again.</p>
            </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="user_type">User Type</label>
                    <select name="user_type" id="user_type" class="form-control" required>
                        <option value="">Select User Type</option>
                        <option value="1">Buyer</option>
                        <option value="2">Seller</option>
                        <option value="3">Admin</option>
                    </select>
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account yet? <a href="Register.php">Register Now</a> | Go back to <a href="Dashboard.php">home page</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
