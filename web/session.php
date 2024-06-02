<?php

session_start();
include('config.php'); // Ensure 'config.php' is included with the file extension '.php'

// Redirect to HomePage.php if the session is valid
if(isset($_SESSION['valid'])){
    header("Location: HomePage.php");
    exit; // Always add an exit or die after a header redirect
} 

// Check for session timeout
if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > 1800){
    session_unset();
    session_destroy();
    // Redirect to login page or any appropriate page after destroying the session
    header("Location: login.php");
    exit; // Always add an exit or die after a header redirect
}

$_SESSION['LAST_ACTIVITY'] = time();

?>
