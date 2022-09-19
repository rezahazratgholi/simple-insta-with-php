<?php
    $exp = time() - 10;
    setcookie("userid", 0, $exp, "/");

    Header("Location: index.php");
?>