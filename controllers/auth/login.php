<?php
include __DIR__ . "/../../connexion/connexion.php";
session_start();

class UserLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($username, $password)
    {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);
        $username_error = '';
        $password_error = '';

        // Validation
        if (empty($username)) {
            $username_error = 'Username is required';
        }

        // Fetch user details for the given username
        $query_check = "SELECT * FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id WHERE username='$username'";
        $result_check = mysqli_query($this->conn, $query_check);
        $rows = mysqli_fetch_assoc($result_check);

        if (empty($username_error) && empty($password_error)) {
            if (password_verify($password, $rows['password'])) {
                // Set session role based on user role
                $_SESSION['role'] = $rows['role_id'];

                // Redirect based on user role
                $this->redirectBasedOnRole($rows['role_id']);
            } else {
                $password_error = 'Incorrect password';
            }
        }
    }

    private function redirectBasedOnRole($role_id)
    {
        switch ($role_id) {
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

if (isset($_POST['submit'])) {
    $userLogin = new UserLogin($conn);
    $userLogin->loginUser($_POST['username'], $_POST['password']);
}
?>
