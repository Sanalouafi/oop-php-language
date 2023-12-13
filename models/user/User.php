<?php
include __DIR__ . "/../../connexion/connexion.php";
session_start();

class User
{
    public $username;
    public $fullname;
    public $password;
    private $conn;

    public function __construct($conn, $username, $fullname, $password)
    {
        $this->conn = $conn;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
    }

    public function registerUser()
    {
        $username = mysqli_real_escape_string($this->conn, $this->username);
        $fullname = mysqli_real_escape_string($this->conn, $this->fullname);
        $password = mysqli_real_escape_string($this->conn, $this->password);

        // Validation
        $username_error = $this->validateUsername($username);
        $password_error = $this->validatePassword($password);
        $fullname_error = $this->validateFullname($fullname);

        if (empty($username_error) && empty($fullname_error) && empty($password_error)) {
            $hashpassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user (username, fullname, password) VALUES ('$username','$fullname','$hashpassword')";
            $result = mysqli_query($this->conn, $query);

            if ($result) {
                $last_id = mysqli_insert_id($this->conn);
                $query_role = "INSERT INTO user_role (user_id, role_id) VALUES ($last_id, 2)";
                $result_role = mysqli_query($this->conn, $query_role);

                if ($result_role) {
                    header("Location:../../views/auth/login.php");
                    exit();
                } else {
                    echo "Error adding user role";
                }
            } else {
                echo "Error adding user";
            }
        }
    }

    public function loginUser()
    {
        $username = mysqli_real_escape_string($this->conn, $this->username);
        $password = mysqli_real_escape_string($this->conn, $this->password);
        $username_error = '';
        $password_error = '';

        // Validation
        if (empty($username)) {
            $username_error = 'Username is required';
        }
        $query_check = "SELECT * FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id WHERE username='$username'";
        $result_check = mysqli_query($this->conn, $query_check);
        $rows = mysqli_fetch_assoc($result_check);

        if (empty($username_error) && empty($password_error)) {
            if (password_verify($password, $rows['password'])) {
                $_SESSION['role'] = $rows['role_id'];

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

    private function validateUsername($username)
    {
        if (empty($username)) {
            return 'Username is required';
        }

        $query_check = "SELECT * FROM user WHERE username='$username'";
        $result_check = mysqli_query($this->conn, $query_check);

        if (mysqli_num_rows($result_check) > 0) {
            return 'Username is invalid';
        }

        return '';
    }

    private function validatePassword($password)
    {
        return empty($password) ? 'Password is required' : '';
    }

    private function validateFullname($fullname)
    {
        return empty($fullname) ? 'Fullname is required' : '';
    }
}

