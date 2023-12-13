<?php include __DIR__.'/../layouts/header.php'; ?>
<?php include __DIR__.'/../../connexion/connexion.php';
$query="SELECT * from user as u INNER JOIN user_role as ur on u.id=ur.user_id INNER JOIN role as r on ur.role_id=r.id ";
$result = mysqli_query($conn, $query);

?>

<h2>Admin Dashboard</h2>


<!-- Add User Button -->
<a href="./users/add.php" class="btn btn-primary mb-3">Add User</a>


<!-- TODO: Display a table of users with options to edit or delete -->
<!-- Use Bootstrap table classes -->
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
        // TODO: Fetch and display users in the table
        $i=0;
        while ($row =mysqli_fetch_assoc($result)) {
            $i++;
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['fullname']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>";
            // TODO: Add edit and delete links with appropriate href values
            echo "<a href='users/edit.php?id={$row['user_id']}' class='btn btn-warning'>Edit</a> | <a href='../../controllers/admin/users/delete.php?id={$row['user_id']}' class='btn btn-danger'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php include __DIR__.'/../layouts/footer.php'; ?>
