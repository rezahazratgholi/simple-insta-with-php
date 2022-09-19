<?php
include 'assets/php/connection.php';
include 'assets/php/check_login.php';
$querydelete = "DELETE FROM `post` WHERE postid='".$_GET['id']."' AND userid='".$_COOKIE['userid']."'";
$querydelete = mysqli_query($connection,$querydelete);
header("Location: home.php");
?>

