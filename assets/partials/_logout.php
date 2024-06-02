<?php

    session_start();
    unset($_SESSION['loggedIn']);
    unset($_SESSION['user_id']);
    
    header("location: ../../admin/index.php");
?>