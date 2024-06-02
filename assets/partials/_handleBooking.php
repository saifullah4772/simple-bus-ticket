<?php 
    require '_functions.php';
    $conn = db_connect();    
    session_start();
    if(!$conn) 
        die("Connection Failed");

    if(!$_SERVER["REQUEST_METHOD"] == "POST" || !isset($_POST["book"]))
    {
        header("location: ../../index.php");
        exit;
    }

    // $customer_name = ucfirst($_POST["firstName"]) . " " . ucfirst($_POST["lastName"]);
    // $customer_phone = $_POST["phone"];
    $customer_id = $_SESSION["customer_id"];
    $customer_seat = $_POST["seat_selected"];
    $route_id = $_POST["route_id"];
    $booked_amount = $_POST["booking_amount"];
    $customer_route = $_POST["source"] . "," . $_POST["destination"];
    $bus_no = $_POST["bus_no"];
    // Now Book the seat
    $booking_added = false;
    $booking_id = false;
        // Route is unique, proceed
        $sql = "INSERT INTO `bookings` (`customer_id`, `route_id`, `bus_no`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES ('$customer_id', '$route_id', '$bus_no','$customer_route', '$booked_amount', '$customer_seat', current_timestamp());";
        echo $sql;

        $result = mysqli_query($conn, $sql);
        // Gives back the Auto Increment id
        $autoInc_id = mysqli_insert_id($conn);
        // If the id exists then, 
        if($autoInc_id)
        {
            $key = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $code = "";
            for($i = 0; $i < 5; ++$i)
                $code .= $key[rand(0,strlen($key) - 1)];
                        
            // Generates the unique bookingid
            $booking_id = $code.$autoInc_id;
                        
            $query = "UPDATE `bookings` SET `booking_id` = '$booking_id' WHERE `bookings`.`id` = $autoInc_id;";
            
            $queryResult = mysqli_query($conn, $query);

            if(!$queryResult)
                echo "Not Working";
        }

        if($result)
            $booking_added = true;
    
    
    // // Update the Seats table
        if($booking_added)
        {
            $bus_no = get_from_table($conn, "routes", "route_id", $route_id, "bus_no");
            $seats = get_from_table($conn, "seats", "bus_no", $bus_no, "seat_booked");

            if($seats)
            {
                $seats .= "," . $customer_seat;
            }
            else 
                $seats = $customer_seat;

            $updateSeatSql = "UPDATE `seats` SET `seat_booked` = '$seats' WHERE `seats`.`bus_no` = '$bus_no';";
            mysqli_query($conn, $updateSeatSql);
        }


    header("location: ../../ticketinfo.php?booking_added=$booking_added&booking_id=$booking_id");
    exit();
?>