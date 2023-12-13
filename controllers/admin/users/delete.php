<?php
include __DIR__ . '/../../../connexion/connexion.php';
$id = $_GET['id'];
$query = "DELETE FROM user where id=$id";
$result = mysqli_query($conn, $query);
$query_role = "DELETE FROM user_role where id=$id";
$result_role = mysqli_query($conn, $query_role);


if($result){
    header("Location:../../../views/admin/dashboard.php");

}
