<?php
include __DIR__ . '/../../../connexion/connexion.php';

class UserCreator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createUser($username, $fullname)
    {
        $username = mysqli_real_escape_string($this->conn, $username);
        $fullname = mysqli_real_escape_string($this->conn, $fullname);

        $defaultPassword = '12345678';

        $query = "INSERT INTO user (username,fullname,password) VALUES ('$username','$fullname','$defaultPassword')";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            $last_id = mysqli_insert_id($this->conn);
            $query1 = "INSERT INTO user_role (user_id,role_id) VALUES ($last_id,2)";
            $result1 = mysqli_query($this->conn, $query1);

            if ($result1) {
                header("Location:../../../views/admin/dashboard.php");
                exit();
            } else {
                echo "Error assigning user role";
            }
        } else {
            echo "Error creating user";
        }
    }
}

if (isset($_POST['submit'])) {
    $userCreator = new UserCreator($conn);
    $userCreator->createUser($_POST['username'], $_POST['fullname']);
}
?>
