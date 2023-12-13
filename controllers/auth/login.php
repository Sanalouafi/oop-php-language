<?php
include __DIR__ . "/../../models/user/User.php";
session_start();



if (isset($_POST['submit'])) {
    $user = new User($conn, $_POST['username'], $_POST['fullname'], $_POST['password']);
    $user->loginUser();
}
