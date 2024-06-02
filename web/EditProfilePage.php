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
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Update user type logic
    switch ($user_type) {
        case '1':
            $user_type_db = 1; // Buyer
            break;
        case '2':
            $user_type_db = 2; // Seller
            break;
        case '3':
            $user_type_db = 3; // Admin
            break;
        default:
            $user_type_db = $userRow['user_type']; // Keep the original user type if invalid
            break;
    }

    if (!empty($password)) {
        $hash_password = SHA1($password);
        $updateQuery = "UPDATE users SET username='$username', email='$email', number='$number', user_type='$user_type_db', password='$hash_password' WHERE user_id='$user_id'";
    } else {
        $updateQuery = "UPDATE users SET username='$username', email='$email', number='$number', user_type='$user_type_db' WHERE user_id='$user_id'";
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
                    <label for="password">New Password (leave blank to keep current password)</label>
                    <input type="password" name="password" id="password">
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
