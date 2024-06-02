<?php
    session_start();

    if(!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"])
    {
        header("location: ../admin/index.php");
    }

    $loggedIn = true;
?>