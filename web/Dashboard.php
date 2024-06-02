<?php
// Include header and database connection file
include('header.php');
include('dbcon.php');

// Start session and redirect user to home page
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: LoginPage.php");
    exit();
}
?>

<div class="box1">
    <h2>Listings</h2>
    <div class="buttons">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addListingModal"> Add Listing </button>
        <!-- Logout Button -->
    </div>
</div>

<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>Livestock</th>
            <th>Sex</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Description</th>
            <th>Update</th>
            <th>Archive</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM listings";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($connection));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo ($row['livestock_id'] == 1) ? 'Chicken' : 'Cattle'; ?></td>
                    <td><?php echo ($row['sex'] == 1) ? 'Male' : 'Female'; ?></td>
                    <td><?php echo $row['breed']; ?></td>
                    <td><?php echo $row['age']; ?> years</td>
                    <td><?php echo $row['description']; ?></td>
                    <td><a href="update_listing.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Update</a></td>
                    <td><button class="archive-button btn btn-danger" data-listing-id="<?php echo $row['id']; ?>">Archive</button></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

<?php
if (isset($_GET['message'])) {
    echo "<h6>" . $_GET['message'] . "</h6>";
}
?>
<?php
if (isset($_GET['insert_msg'])) {
    $message = html_entity_decode($_GET['insert_msg']);
    echo "<h6>" . $message . "</h6>";
}
?>
<?php
if (isset($_GET['update_msg'])) {
    echo "<h6>" . $_GET['update_msg'] . "</h6>";
}
?>
<?php
if (isset($_GET['archive_msg'])) {
    echo "<h6>" . $_GET['archive_msg'] . "</h6>";
}
?>

<!-- Modal for Adding Listing -->
<form action="insert_listing.php" method="post">
    <div class="modal fade" id="addListingModal" tabindex="-1" role="dialog" aria-labelledby="addListingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addListingModalLabel">Add Listing</h5>
                </div>
                <div class="modal-body">
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
                        <input type="text" name="breed" class="form-control" placeholder="Enter breed">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" class="form-control" placeholder="Enter age">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                    <input type="submit" class="btn btn-success" name="add_listing" value="ADD">
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('.archive-button').click(function() {
        var listingId = $(this).data('listing-id');

        // Ask for confirmation before archiving the listing
        var confirmArchive = confirm("Are you sure you want to archive this listing?");
        if (confirmArchive) {
            // Make AJAX request to archive the listing
            $.ajax({
                url: 'archive_listing.php',
                type: 'POST',
                data: { id: listingId },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error archiving listing');
                }
            });
        }
    });

    function closeModal() {
        $('#addListingModal').modal('hide');
    }

    // Add event listener for close button
    document.getElementById('closeModal').addEventListener('click', function() {
        closeModal();
    });
});
</script>

<?php include('footer.php'); ?>
