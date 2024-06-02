<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php

        include("config.php");
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $password = $_POST['password'];
            $user_type = $_POST['user_type'];

            // Assuming 1 is for Buyer, 2 is for Seller, and 3 is for Admin
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
                    // Handle the case where an invalid user type is submitted
                    // For example, you might set a default value or display an error message
                    break;
            }

            // Verifying the unique email
            $sql = "SELECT email FROM users WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                echo "<div class='message'>
                        <p>Email address is already taken, please try again.</p>
                    </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
            } elseif ($_POST['password'] !== $_POST['confirm_password']) {
                echo "<div class='message'>
                        <p>Passwords do not match. Please try again.</p>
                    </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
            } else {
                try { 
                    $userSql = "INSERT INTO users (username, email, password, number, user_type) VALUES (?,?,?,?,?)";
                    $stmt = $conn->prepare($userSql);
                    $hashedPassword = sha1($password);
                    $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $number, $user_type_db);
                    $user = $stmt->execute();

                    if($user) {
                        // Registration successful
                        echo "<div class='message'>
                                <p>Registration successful! Redirecting you to the login page.</p>
                            </div> <br>";
                        header("refresh:2; url=LoginPage.php"); // Redirect to login page after 2 seconds
                    }

                } catch(Exception $e) {
                    echo "<div class='message'>
                            <p>An error occurred, please try again.</p>
                        </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                }
            }
        } else {

        ?>
            <header>Register</header>
            <form action="" method="post" id="registrationForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input class="form-control" type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="number">Number</label>
                    <input class="form-control" type="text" name="number" id="number" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select class="form-control" name="user_type" id="user_type" required>
                        <option value="">Select User Type</option>
                        <option value="1">Buyer</option>
                        <option value="2">Seller</option>
                        <option value="3">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary submit" type="submit" name="submit" value="Submit">
                </div>
                <div class="link">
                    Already have an account? <a href="LoginPage.php">Login Now</a>
                </div>
            </form>
        <?php } ?>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
