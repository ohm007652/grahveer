<?php
include('db.php');
$user_id = $_GET['id'];
$query = "DELETE FROM users WHERE id='$user_id'";
mysqli_query($conn, $query);
header('Location: adminnew.php');
?>
