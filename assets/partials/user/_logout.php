<?php

    session_start();
    unset($_SESSION['customer_loggedIn']);
    unset($_SESSION['customer_id']);
    
    header("location: ../../../index.php");
?>