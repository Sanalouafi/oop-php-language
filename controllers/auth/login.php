<?php
include __DIR__ . "/../../models/user/User.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($username, '', $password);

    if ($user->getByUserName()>0) {

        $role = $_SESSION['role'];
        switch ($role) {
            case 1:
                header('Location:../../views/admin/dashboard.php');
                exit();
            case 2:
                header('Location:../../views/user/home.php');
                exit();
            default:
                echo "Unknown role";
                break;
        }
    } else {
        echo "Login failed. Please check your credentials.";
    }
}
?>
