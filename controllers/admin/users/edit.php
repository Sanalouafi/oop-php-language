<?php
include __DIR__ . '/../../../connexion/connexion.php';

class UserEditor
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function editUser($id, $username, $fullname, $role)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $username = mysqli_real_escape_string($this->conn, $username);
        $fullname = mysqli_real_escape_string($this->conn, $fullname);
        $role = mysqli_real_escape_string($this->conn, $role);

        $query = "UPDATE user SET username='$username', fullname='$fullname' WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            $query_role = "UPDATE user_role SET role_id=$role WHERE user_id=$id";
            $result_role = mysqli_query($this->conn, $query_role);

            if ($result_role) {
                header("Location:../../../views/admin/dashboard.php");
                exit();
            } else {
                echo "Error updating user role";
            }
        } else {
            echo "Error updating user data";
        }
    }
}

if (isset($_POST['submit'])) {
    $userEditor = new UserEditor($conn);
    $userEditor->editUser($_POST['id'], $_POST['username'], $_POST['fullname'], $_POST['role']);
}
?>
