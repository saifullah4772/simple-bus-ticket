<?php
    require '../_functions.php';

    $conn = db_connect();

    if(!$conn)
        die("Oh Shoot!! Connection Failed");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"]))
    {
        $fullName = $_POST["fname"] . " " . $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"]; 
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $customer_id = "CUST-".rand(1000000, 9999999);
        echo $fullName;
        // Check if the username already exists
        $user_exists = exist_customers($conn, $email);
        if($user_exists){
            header("location: ../../../signup.php?user_exists=$user_exists");
        }

        if(!$user_exists)
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `customers` (`customer_id`, `name`, `email`, `gender`, `phone`, `password`, `customer_created`) VALUES ('$customer_id', '$fullName', '$email', '$gender', '$phone', '$hash' ,current_timestamp());";

            $result = mysqli_query($conn, $sql);
            if($result){
                header("location: ../../../index.php");
            }
        }
    }

?>