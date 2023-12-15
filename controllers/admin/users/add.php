<?php
include __DIR__ . '/../../../models/user/User.php';

if (isset($_POST['submit'])) {
    $user = new User($_POST['username'], $_POST['fullname'], '12345678');
    $creationStatus = $user->createUser();

    if ($creationStatus) {
        header("Location:../../../views/admin/dashboard.php?msg=hey");
        exit();
    } else {
        echo "Error creating user";
    }
}
?>
