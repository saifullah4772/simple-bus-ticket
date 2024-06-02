<?php
    require '_functions.php';

    $conn = db_connect();

    if(!$conn)
        die("Oh Shoot!! Connection Failed");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"]))
    {

        $fullName = $_POST["fname"] . " " . $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"]; 
        // Check if the username already exists
        $user_exists = exist_user($conn, $email);
        if($user_exists){
            header("location: ../../admin/signup.php?user_exists=$user_exists&signup=0");
        }

        if(!$user_exists)
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`fullname`, `user_name`, `user_password`, `user_created`) VALUES ('$fullName', '$email', '$hash' ,current_timestamp());";

            $result = mysqli_query($conn, $sql);
            if($result){
                header("location: ../../admin/index.php");
            }
        }
    }

?>