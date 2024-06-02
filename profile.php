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
        
        if(!isset($_SESSION["customer_loggedIn"]) || !$_SESSION["customer_loggedIn"])
        {
            header("location: login.php");
        }
        require 'assets/styles/styles.php'
            
    ?>
</head>
<body>
    <?php require 'assets/partials/_header.php'; ?>
    <?php
        if(isset($_GET["message"])){
            $message = $_GET["message"];
            $messageStatus = $_GET["status"];
            echo "<div class='alert alert-$messageStatus alert-dismissible fade show' role='alert'>
            <strong>$messageStatus!</strong> $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    ?>
    <section class="profile">
    
        <div class="container">
            <?php 
                    require 'assets/partials/_functions.php';
                    $conn = db_connect();
                    $email = $_SESSION["customer_email"];
                    $sql = "SELECT * FROM `customers` WHERE email='$email';";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<h3>Welcome: ".$row['name']."</h3>";
                                echo "<p>Email: ".$row['email']."</p>";
                                echo "<p>Phone: ".$row['phone']."</p>";
                        }
                    }
            ?>
            <h4>Your Bookings</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Bus #</th>
                    <th scope="col">Seat #</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // $conn = db_connect();
                    $customer_id = $_SESSION["customer_id"];
                    $sql = "SELECT * FROM `bookings` WHERE customer_id='$customer_id';";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                            echo "<th scope='row'>1</th>";
                            echo "<td>".$row['booking_id']."</td>";
                            echo "<td>".$row['customer_id']."</td>";
                            echo "<td>".explode(",",$row['customer_route'])[0]."</td>";
                            echo "<td>".explode(",",$row['customer_route'])[1]."</td>";
                            echo "<td>".$row['route_id']."</td>";
                            echo "<td>".$row['booked_seat']."</td>";
                            echo "<td>".$row['booking_created']."</td>";
                            echo "<td>
                            <a href='ticketinfo.php?booking_id=".$row['booking_id']."' class='btn btn-info btn-sm'>View Ticket</a>
                            <form action='assets/partials/_handleBookingDelete.php' id='delete-form'  method='POST' style='display:inline;'>
                                <input id='id' type='hidden' name='id' value='".$row['booking_id']."'>
                                <input id='booked_seat' type='hidden' name='booked_seat' value='".$row['booked_seat']."'>
                                <input id='bus' type='hidden' name='bus' value='".$row['bus_no']."'>
                                <button type='submit' class='btn btn-danger btn-sm' name='deleteBtn'>Cancel</button>
                            </form>
                            </td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "<tr>";
                        echo "<td colspan='4'>No Bookings Found</td>";
                        echo "</tr>";
                    }
    
                ?>
            </tbody>
        </table>
        <p><strong>Note:</strong> 20% payment will be deducted from whole payment on ticket cancellation.</p>
</div>
    </section>
    <footer>
        <p>
            <i class="far fa-copyright"></i> <?php echo date('Y');?> - Simple Bus Ticket Booking System
        </p>
    </footer>
         <!-- Option 1: Bootstrap Bundle with Popper -->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- External JS -->
    <script src="assets/scripts/main.js"></script>
</body>
</html>