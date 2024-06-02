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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routes Search Page</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php 
    require 'assets/styles/search_routes.php'?>
    <?php require 'assets/styles/styles.php'; ?>
</head>
<body>
    <?php require 'assets/partials/_header.php'; ?><input type="hidden" name="route_id" value="<?php echo $route_id; ?>">
    <br>        
    <br>               
    <?php 
        require 'assets/partials/_functions.php';
        $conn = db_connect();    
        $customer_id = $_SESSION["customer_id"];
        $email = $_SESSION["customer_email"];
        $route_id = $_POST["route_id"];
        $source = $_POST["source"];
        $destination = $_POST["destination"];
        $bus_no = $_POST["bus_no"];
        $booking_amount = $_POST["booking_amount"];
        $route_dep_time = $_POST["route_dep_time"];
        $total_seats = $_POST["total_seats"];
        $no_available_seats = $_POST["no_available_seats"];
        $booked_seatsArr=[];
        $booked_seats = get_from_table($conn,"seats", "bus_no", $bus_no, "seat_booked");
        $booked_seatsArr = explode(",", $booked_seats);
    ?>
    <main id="container" class="pt-5">

        <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div>
                <table class="seatsDiagram">
                    <tr>
                    <?php 
                    for($i = 1; $i <= $total_seats; $i++)
                    {   
                        if(in_array($i, $booked_seatsArr)){
                            echo "<td class='notAvailable'>".$i."</td>";
                            continue;
                        }
                        if($i % 8 == 0){
                            echo "<td class='seat_number' data-seatNo='".$i."'>".$i."</td>";
                            echo "</tr>";
                            echo "<tr>";
                        }else{
                            echo "<td class='seat_number' data-seatNo='".$i."'>".$i."</td>";
                        }
                    }
                    ?>
                    </tr>
                </table>
                </div>
            </div>
            <div class="col-md-5">
                <form action="assets/partials/_handleBooking.php" method="post">
                    <input type="hidden" name="route_id" value="<?php echo $route_id; ?>">
                    <input type="hidden" name="source" value="<?php echo $source; ?>">
                    <input type="hidden" name="destination" value="<?php echo $destination; ?>">
                    <input type="hidden" name="bus_no" value="<?php echo $bus_no; ?>">
                    <input type="hidden" name="booking_amount" value="<?php echo $booking_amount; ?>">
                    <input type="hidden" name="booked_seats" value="<?php echo $booked_seats; ?>">
                    <input type="hidden" name="route_dep_time" value="<?php echo $route_dep_time; ?>">
                    <input type="hidden" name="total_seats" value="<?php echo $total_seats; ?>">
                    <input type="hidden" name="no_available_seats" value="<?php echo $no_available_seats; ?>">
                    <!-- <input placeholder="Enter Seat Value"/> -->
                    <div class="form-outline mb-4">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="seat_selected" name="seat_selected" id="email" name="email" class="form-control"
                        placeholder="1" required/>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="email" name="cardName" class="form-control"
                        placeholder="Enter Card Holder Name" required/>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="email" name="cardNumber" class="form-control"
                        placeholder="Enter Card Number" required/>
                    </div>
                    <div data-mdb-input-init class="form-inline mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="email" name="expirt" class="form-control "
                                placeholder="Enter Card Expiry" required/>
                            </div>
                            <div class="col-md-6">
                                <input type="number" id="password" name="cvv" class="form-control "
                                placeholder="Enter Card CVV" required/>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="book">Book Now</button>
                </form>
            </div>
        </div>
        </div>
    </main>
    <script src="assets/scripts/booking.js"></script>
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>