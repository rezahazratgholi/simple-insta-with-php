<?php
    //check if the user is logged in
    if( !isset($_COOKIE['userid']) ){
        Header("Location: index.php");
    }
?>