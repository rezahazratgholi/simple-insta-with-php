<?php
include 'assets/php/connection.php';
$query1 = "SELECT * FROM likes WHERE userid='".$_COOKIE['userid']."' AND postid= '".$_GET['likeid']."' ";
$query1 = mysqli_query($connection,$query1);
//print_r(mysqli_num_rows($query1));
//die();
if (mysqli_num_rows($query1)==1){
    $query2 = "DELETE FROM `likes` WHERE userid='".$_COOKIE['userid']."' AND postid= '".$_GET['likeid']."' ";
    $query2 = mysqli_query($connection,$query2);
    $back = $_GET['likeid'];
    $redirect = "Location: comment.php?id=$back";
    header($redirect);
}
else {
    $now = date("y/n/d - H:i");
    $query = "INSERT INTO likes( postid , userid , `date` ) VALUES ('" . $_GET['likeid'] . "' , '" . $_COOKIE['userid'] . "' , '" . $now . "' ) ";
    if (mysqli_query($connection, $query)) {
        $back = $_GET['likeid'];
        $redirect = "Location: comment.php?id=$back";
        header($redirect);
    }
}


?>