<?php include __DIR__ . '/../../layouts/header.php';
include __DIR__ . '/../../../connexion/connexion.php';




?>

<h2>Add User</h2>

<form method="post" action="../../../controllers/admin/users/add.php">
    <!-- TODO: Add input fields for name and email -->
    <div class="form-group">
        <label for="fullname">fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname" required>
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="username" class="form-control" name="username" id="username" required>
    </div>

    

    <!-- TODO: Add submit button -->
    <button type="submit" name="submit" class="btn btn-primary">Add Employee</button>
</form>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>