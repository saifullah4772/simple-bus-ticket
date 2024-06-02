<?php
    require '../_functions.php';
    $conn = db_connect();

    if(!$conn)
        die("Oh Shoot!! Connection Failed");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `customers` WHERE email='$email';";
        $result = mysqli_query($conn, $sql);
        $error = "Invalid Credentials";
        if(!mysqli_num_rows($result)){
            header("location: ../../../login.php?error=1");
            exit;
        }
        if($row = mysqli_fetch_assoc($result)){
            $hash = $row['password'];
            if(password_verify($password, $hash))
            {
                // Login Sucessfull
                session_start();
                $_SESSION["customer_loggedIn"] = true;
                $_SESSION["customer_id"] = $row["customer_id"];
                $_SESSION["customer_email"] = $row["email"];

                header("location: ../../../index.php");
                exit;
            }else{
                header("location: ../../../login.php?error=2");
            }
        }
    }
?>