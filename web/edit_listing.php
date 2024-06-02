<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include header and database connection file
include('config.php');

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: LoginPage.php");
    exit();
}

// Get the listing ID from the URL
if (!isset($_GET['listing_id'])) {
    die("Listing ID not provided.");
}

$listing_id = $_GET['listing_id'];

// Fetch listing details
$query = "SELECT * FROM listings WHERE listing_id='$listing_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$listing = mysqli_fetch_assoc($result);

if (!$listing) {
    die("Listing not found.");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $livestock_id = $_POST['livestock_id'];
    $sex = $_POST['sex'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];

    // Update the listing in the database
    $update_query = "UPDATE listings SET 
                     livestock_id='$livestock_id', 
                     sex='$sex', 
                     breed='$breed', 
                     age='$age', 
                     description='$description' 
                     WHERE listing_id='$listing_id'";

    if (mysqli_query($conn, $update_query)) {
        // Redirect to dashboard after update
        header("Location: Dashboard.php");
    } else {
        die("Database update failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Listing</h2>
    <form action="edit_listing.php?listing_id=<?php echo $listing_id; ?>" method="post">
        <div class="form-group">
            <label for="livestock_id">Livestock</label>
            <select class="form-control" id="livestock_id" name="livestock_id">
                <option value="1" <?php echo ($listing['livestock_id'] == 1) ? 'selected' : ''; ?>>Chicken</option>
                <option value="2" <?php echo ($listing['livestock_id'] == 2) ? 'selected' : ''; ?>>Cattle</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sex">Sex</label>
            <select class="form-control" id="sex" name="sex">
                <option value="1" <?php echo ($listing['sex'] == 1) ? 'selected' : ''; ?>>Male</option>
                <option value="0" <?php echo ($listing['sex'] == 0) ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="breed">Breed</label>
            <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $listing['breed']; ?>" placeholder="Enter breed">
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo $listing['age']; ?>" placeholder="Enter age">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"><?php echo $listing['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Listing</button>
    </form>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
