<?php

include __DIR__ . "/../../connexion/connexion.php";
session_start();
class User
{
    private $username;
    private $fullname;
    private $password;
    private $conn;

    public function __construct($username, $fullname, $password)
    {
        $this->conn = DbHandler::connect();
        $this->setUsername($username);
        $this->setFullname($fullname);
        $this->setPassword($password);
    }

    public function createUser()
    {
        $username = $this->getUsername();
        $fullname = $this->getFullname();
        $password = $this->getPassword();

        $usernameError = $this->validateUsername($username);
        $fullnameError = $this->validateFullname($fullname);
        $passwordError = $this->validatePassword($password);

        if (!empty($usernameError) || !empty($fullnameError) || !empty($passwordError)) {
            echo "Validation error: $usernameError $fullnameError $passwordError";
            return false;
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (username, fullname, password) VALUES ('$username','$fullname','$hashPassword')";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            $lastId = mysqli_insert_id($this->conn);
            $queryRole = "INSERT INTO user_role (user_id, role_id) VALUES ($lastId, 2)";
            $resultRole = mysqli_query($this->conn, $queryRole);

            if ($resultRole) {
                return true;
            } else {
                echo "Error adding user role";
            }

            return false;
        } else {
            echo "Error adding user";
        }

        return false;
    }


    private function validateUsername($username)
    {
        if (empty($username)) {
            return 'Username is required';
        }

        $queryCheck = "SELECT * FROM user WHERE username='$username'";
        $resultCheck = mysqli_query($this->conn, $queryCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            return 'Username is already taken';
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

    public function getAllUsers()
    {
        $query = "SELECT u.*, r.name FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return $result;
        }
    }




    public function getByUserName()
    {
        $username = $this->getUsername();
        $password = $this->getPassword();

        // Basic validation
        $passwordError = $this->validatePassword($password);

        if (!empty($passwordError)) {
            // Validation failed
            echo "Validation error: $passwordError";
            return false;
        }

        $query = "SELECT u.*, ur.role_id, r.name FROM user AS u INNER JOIN user_role AS ur ON u.id = ur.user_id INNER JOIN role AS r ON ur.role_id = r.id WHERE username='$username'";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error retrieving user: " . mysqli_error($this->conn);
            return false;
        }

        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "User not found";
            return false;
        }

        if (password_verify($password, $row['password'])) {
            $_SESSION['role'] = $row['role_id'];

            return true;
        } else {
            echo "Incorrect password";
            return false;
        }
    }



    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = mysqli_real_escape_string($this->conn, $username);
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = mysqli_real_escape_string($this->conn, $fullname);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = mysqli_real_escape_string($this->conn, $password);
    }
}
