<?php

include __DIR__ . "/../../models/user/User.php";

class UserController
{
    public function registerUser($username, $fullname, $password)
    {
        $user = new User($username, $fullname, $password);

        if ($user->createUser()) {
            $this->redirectUser(2);
        } else {
            echo "Error adding user";
        }
    }

    public function loginUser($username, $password)
    {
        $user = new User($username, '', $password);

        if ($user->getByUserName()) {
            $this->redirectUser($_SESSION['role']);
        } else {
            echo "Incorrect username or password";
        }
    }

    private function redirectUser($role)
    {
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
    }
}

// Usage example
if (isset($_POST['submit'])) {
    $userController = new UserController();
    $userController->registerUser($_POST['username'], $_POST['fullname'], $_POST['password']);
}
