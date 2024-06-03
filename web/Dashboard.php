<?php
include('config.php');

// Start session and redirect user to home page
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user details
$userResult = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
$userRow = mysqli_fetch_assoc($userResult);

// Fetch listings
$query = "SELECT * FROM listings";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Dashboard content -->
<div class="dashboard-container">
    <h2 class="dashboard-title">Dashboard</h2>
    <!-- Logout button -->
    <a href="Logout.php"><button class="btn">Logout</button></a>
    <!-- Edit Profile Button -->
    <a href="EditProfilePage.php"><button class="btn">Edit Profile</button></a>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postListingModal">
        Add Listing
    </button>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img class="card-img-top" src="images/cow1.png" alt="Livestock Image">
                    <div class="card-body">
                        <h5 class="card-title">Livestock: <?php echo ($row['livestock_id'] == 1) ? 'Chicken' : 'Cattle'; ?></h5>
                        <p class="card-text">Sex: <?php echo ($row['sex'] == 1) ? 'Male' : 'Female'; ?></p>
                        <p class="card-text">Breed: <?php echo $row['breed']; ?></p>
                        <p class="card-text">Age: <?php echo $row['age']; ?> years</p>
                        <p class="card-text">Description: <?php echo $row['description']; ?></p>
                        <p class="card-text">Posted When: <?php echo $row['posted_when']; ?></p>

                        <a href="edit_listing.php?listing_id=<?php echo $row['listing_id']; ?>" class="btn btn-primary">Edit Listing</a>
           
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Modal for Posting Listing -->
<div class="modal fade" id="postListingModal" tabindex="-1" role="dialog" aria-labelledby="postListingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postListingModalLabel">Add Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="insert_listing.php" method="post">
                    <div class="form-group">
                        <label for="livestock_id">Livestock</label>
                        <select class="form-control" id="livestock_id" name="livestock_id">
                            <option value="1">Chicken</option>
                            <option value="2">Cattle</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <select class="form-control" id="sex" name="sex">
                            <option value="1">Male</option>
                            <option value="0">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <input type="text" class="form-control" id="breed" name="breed" placeholder="Enter breed">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter age">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="post_listing">Add Listing</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php include('footer.php'); ?>
