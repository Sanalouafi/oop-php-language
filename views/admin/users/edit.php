<?php include __DIR__ . '/../../layouts/header.php';
include __DIR__ . '/../../../connexion/connexion.php';
$id=$_GET['id'];

$query_role = "SELECT * from role ";
$result_role= mysqli_query($conn, $query_role);


$query = "SELECT * from user as u INNER JOIN user_role as ur on u.id=ur.user_id INNER JOIN role as r on ur.role_id=r.id where u.id=$id";
$result = mysqli_query($conn, $query);
$row=mysqli_fetch_assoc($result);
?>

<h2>Edit User</h2>

<form method="post" action="../../../controllers/admin/users/edit.php">
    <!-- TODO: Add input fields for name and email -->
    <div class="form-group">
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <label for="fullname">fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname " value="<?=$row['fullname']?>"required>
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="username" class="form-control" name="username" id="username" value="<?=$row['username']?>" required>
    </div>

    <div class="form-group">
        <select name="role" id="role">
            <option default value="<?=$row['role_id']?>"><?=$row['name']?></option>
            <?php
            while ($rows= mysqli_fetch_assoc($result_role)) {
            ?>
                <option value="<?php echo $rows['id'] ?>"><?php echo $rows['name'] ?></option>

            <?php
            } ?>

        </select>
    </div>

    <!-- TODO: Add submit button -->
    <button type="submit" name="submit" class="btn btn-primary">Add Employee</button>
</form>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>