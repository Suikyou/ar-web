<?php
// Include database connection file
include('config.php');

// Start session and redirect user to login page if not logged in
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: LoginPage.php");
    exit();
}

// Check if listing_id is provided
if (isset($_POST['listing_id'])) {
    $listing_id = $_POST['listing_id'];

    // Fetch listing data from database
    $query = "SELECT * FROM listings WHERE listing_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if listing exists
    if ($row) {
        // Listing data found, display edit form
        $livestock_id = $row['livestock_id'];
        $sex = $row['sex'];
        $breed = $row['breed'];
        $age = $row['age'];
        $description = $row['description'];
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Listing</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
        </head>

        <body>
            <div class="container mt-5">
                <h2>Edit Listing</h2>
                <form action="update_listing.php" method="post">
                    <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
                    <div class="form-group">
                        <label for="livestock_id">Livestock:</label>
                        <input type="text" class="form-control" id="livestock_id" name="livestock_id" value="<?php echo $livestock_id; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex:</label>
                        <input type="text" class="form-control" id="sex" name="sex" value="<?php echo $sex; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="breed">Breed:</label>
                        <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $breed; ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Listing</button>
                </form>
            </div>
        </body>

        </html>
<?php
    } else {
        // Listing not found, redirect to dashboard with error message
        header("Location: Dashboard.php?error=Listing not found");
        exit();
    }
} else {
    // Redirect if listing_id is not provided
    header("Location: Dashboard.php");
    exit();
}
?>
