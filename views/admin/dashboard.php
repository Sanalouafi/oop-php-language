<?php
include __DIR__.'/../layouts/header.php'; 
include __DIR__.'/../../models/user/User.php';

?>

<h2>Admin Dashboard</h2>

<a href="./users/add.php" class="btn btn-primary mb-3">Add User</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $user = new User('', '', '');
        $result = $user->getAllUsers();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['fullname']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>";
                echo "<a href='users/edit.php?id={$row['id']}' class='btn btn-warning'>Edit</a> | <a href='../../controllers/admin/users/delete.php?id={$row['id']}' class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include __DIR__.'/../layouts/footer.php'; ?>
