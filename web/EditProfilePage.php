<?php
session_start();
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['valid'])) {
    header('Location: LoginPage.php');
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user details
$userResult = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
$userRow = mysqli_fetch_assoc($userResult);

if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Verify old password
    $old_hashed_password = SHA1($old_password);
    $old_password_query = mysqli_query($conn, "SELECT password FROM users WHERE user_id='$user_id'");
    $old_password_row = mysqli_fetch_assoc($old_password_query);
    if ($old_hashed_password != $old_password_row['password']) {
        echo "<div class='message'>
                <p>Old password is incorrect.</p>
              </div>";
        exit(); // Stop execution if old password is incorrect
    }

    if (!empty($new_password)) {
        if ($new_password != $confirm_password) {
            echo "<div class='message'>
                    <p>Password and confirm password do not match.</p>
                  </div>";
            exit(); // Stop execution if passwords do not match
        }
        $hash_password = SHA1($new_password);
        $updateQuery = "UPDATE users SET username='$username', email='$email', number='$number', user_type='$user_type', password='$hash_password' WHERE user_id='$user_id'";
    } else {
        $updateQuery = "UPDATE users SET username='$username', email='$email', number='$number', user_type='$user_type' WHERE user_id='$user_id'";
    }

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['valid'] = $username;
        echo "<div class='message'>
                <p>Profile updated successfully.</p>
              </div>";
    } else {
        echo "<div class='message'>
                <p>Error updating profile: " . mysqli_error($conn) . "</p>
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
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Edit Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $userRow['username']; ?>" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $userRow['email']; ?>" required>
                </div>
                <div class="field input">
                    <label for="number">Phone Number</label>
                    <input type="text" name="number" id="number" value="<?php echo $userRow['number']; ?>" required>
                </div>
                <div class="field input">
                    <label for="user_type">User Type</label>
                    <select name="user_type" id="user_type" class="form-control" required>
                        <option value="1" <?php echo ($userRow['user_type'] == 1) ? 'selected' : ''; ?>>Buyer</option>
                        <option value="2" <?php echo ($userRow['user_type'] == 2) ? 'selected' : ''; ?>>Seller</option>
                        <option value="3" <?php echo ($userRow['user_type'] == 3) ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" id="old_password" required>
                </div>
                <div class="field input">
                    <label for="new_password">New Password (leave blank to keep current password)</label>
                    <input type="password" name="new_password" id="new_password">
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </div>
                <div class="field">
                    <input type="submit" name="update" class="btn btn-primary" value="Update Profile">
                </div>
                <div class="links">
                    <a href="Dashboard.php">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
