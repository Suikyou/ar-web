<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include('config.php');

// Start session and redirect user to login page if not logged in
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: LoginPage.php");
    exit();
}

// Check if form is submitted
if (isset($_POST['post_listing'])) {
    // Get form data
    $livestock_id = $_POST['livestock_id'];
    $sex = $_POST['sex'];
    $breed = $_POST['breed'];
    $age = (int)$_POST['age'];
    $description = $_POST['description'];
    $posted_when = date('Y-m-d H:i:s'); // Get the current date and time

    // Ensure description is not empty
    if (empty($description)) {
        $description = NULL;
    }

    // Prepare insert query
    $insert_query = "INSERT INTO listings (livestock_id, sex, breed, age, description, posted_when) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);

    // Check if statement preparation was successful
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    if ($description === NULL) {
        $stmt->bind_param("iissss", $livestock_id, $sex, $breed, $age, $description, $posted_when);
    } else {
        $stmt->bind_param("iissss", $livestock_id, $sex, $breed, $age, $description, $posted_when);
    }

    // Execute insert query
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: Dashboard.php?message=Listing added successfully");
        exit();
    } else {
        // Handle error and redirect with error message
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
} else {
    // Redirect if form is not submitted
    header("Location: Dashboard.php");
    exit();
}
?>
