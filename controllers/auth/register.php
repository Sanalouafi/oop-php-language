<?php
include __DIR__ . "/../../connexion/connexion.php";

class UserRegistration
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($username, $fullname, $password)
    {
        $username = mysqli_real_escape_string($this->conn, $username);
        $fullname = mysqli_real_escape_string($this->conn, $fullname);
        $password = mysqli_real_escape_string($this->conn, $password);

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

if (isset($_POST['submit'])) {
    $userRegistration = new UserRegistration($conn);
    $userRegistration->registerUser($_POST['username'], $_POST['fullname'], $_POST['password']);
}
?>
