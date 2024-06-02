<?php
    session_start();
    include("config.php");
    //$logs = new UserLogs($conn);
    //$logs->create('Logout Page', 'User Logout', $_SESSION['user_id'] ?? 0, 0);
    session_destroy();
    header("Location: LoginPage.php");
?>