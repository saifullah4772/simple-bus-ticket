<?php 
        session_start(); 
        
        if(!isset($_SESSION["customer_loggedIn"]) || !$_SESSION["customer_loggedIn"])
        {
            header("location: login.php");
        }
            
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Bookings</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font-awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php 
        session_start(); 
        require 'assets/styles/styles.php'
    ?>
    <style>
        .ticket {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background-color: #f8f9fa;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-footer {
            text-align: center;
            margin-top: 20px;
        }
        .ticket-section {
            margin-bottom: 10px;
        }
        .ticket-section h5 {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php require 'assets/partials/_header.php'; ?>
    <section>
        <?php 
        if(isset($_GET["booking_added"]) && $_GET["booking_added"] == 1){
            echo '<div class="my-0 p-3 alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Booking Added Successfully
                </div>';
        }
        ?>
    <?php 
        require 'assets/partials/_functions.php';
        $conn = db_connect();
        $booking_id = $_GET['booking_id'];
        $sql = "SELECT * FROM `bookings` WHERE booking_id='$booking_id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0)
        {   
            while($row = mysqli_fetch_assoc($result))
            {
                $customer_id= $row['customer_id'];
                $customer_name = get_from_table($conn, 'customers', 'customer_id',$customer_id, 'name');
                $customer_gender = get_from_table($conn, 'customers', 'customer_id',$customer_id, 'gender');
                $departureTime = get_from_table($conn, 'routes', 'route_id', $row['route_id'], 'route_dep_time');
                $departureDate = get_from_table($conn, 'routes', 'route_id', $row['route_id'], 'route_dep_date');
                echo '<div class="container mt-5">
                <div class="ticket">
                    <div class="ticket-header">
                        <h2>Bus Ticket</h2>
                        <p>Simple Bus Ticket Booking System</p>
                        <h6>Booking ID: '.$row['booking_id'].'</h6>
                    </div>
                    <div class="ticket-section">
                        <h5>Passenger Information</h5>
                        <p></p>
                        <p><strong>Name:</strong> '.$customer_name.'</p>
                        <p><strong>Gender:</strong> '.$customer_gender.'</p>
                    </div>
                    <hr />
                    <div class="ticket-section">
                        <h5>Trip Details</h5>
                        <p></p>
                        <p><strong>Departure:</strong> '.explode(",",$row['customer_route'])[0].'</p>
                        <p><strong>Destination:</strong> '.explode(",",$row['customer_route'])[1].'</p>
                        <p><strong>Date:</strong> '.$departureDate.'</p>
                        <p><strong>Time:</strong> '.$departureTime.'</p>
                        <p><strong>Seat Number:</strong> '.$row['booked_seat'].'</p>
                    </div>
                    <hr />
                    <div class="ticket-section">
                        <h5>Payment Information</h5>
                        <p></p>
                        <p><strong>Ticket Price:</strong> $'.$row['booked_amount'].'.00</p>
                        <p><strong>Payment Method:</strong> Credit Card</p>
                    </div>
                    <div class="ticket-footer">
                        <p>Thank you for choosing Simple Bus Ticket Booking System!</p>
                    </div>
                </div>
            </div>';
            }
        }else{
            echo '<div class="container mt-5">
            <div class="ticket">
                <div class="ticket-header">
                    <h2>No Ticket Information Found</h2>
                   
                </div>
            </div>
        </div>';
        }
    
    ?>
    
    </section>
    <footer>
        <p>
            <i class="far fa-copyright"></i> <?php echo date('Y');?> - Simple Bus Ticket Booking System
        </p>
    </footer>
</body>
</html>

