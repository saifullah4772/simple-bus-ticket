<?php
    require 'assets/partials/_functions.php';
    $conn = db_connect();    

    if(!$conn) 
        die("Connection Failed");

    if(!$_SERVER["REQUEST_METHOD"] == "POST" || !isset($_POST["search"]))
    {
        header("location: index.php");
        exit;
    }

    $source = strtoupper($_POST["source"]);
    $destination = strtoupper($_POST["destination"]);
    $dep_date = strtotime($_POST["departure"]);
    $new_date = date('Y-m-d', $dep_date);
    $cities = $source . "," . $destination;
    $sql = "SELECT * FROM routes WHERE route_cities='$cities' and route_dep_date='$new_date'";
    $result = mysqli_query($conn, $sql);
    $no_results = mysqli_num_rows($result);

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
    session_start();
    require 'assets/styles/search_routes.php'?>
</head>
<body>
    <?php require 'assets/partials/_header.php'; ?>
    <main id="container">
        <section id="searched-route">
            <ul>
                <li class="searched-route-item" id="">Total Results : <span id="result-num">
                    <?php 
                        echo $no_results;
                    ?>
                </span></li>
                <li class="searched-route-item"><?php echo $source; ?> <span class="arrow">&rarr;</span> <?php echo $destination; ?>
                <li class="searched-route-item" id="date">
                <?php 
                    // Changing format from yyyy-mm-dd to dd-mm-yyyy
                    echo $new_date;

                ?></li>
            </ul>
        </section>
        <section id="searched-results">
        <?php 
            if(!$no_results)
            {?>
                <div class="container mt-4">
                    <div id="noRoutes" class="alert alert-dark " role="alert">
                        <h1 class="alert-heading">No Routes Found!!</h1>
                        <p class="fw-light">
                            Currently there are no services for the specified route
                        </p>
                        <hr>
                        <div id="addCustomerAlert" class="alert alert-success" role="alert">
                                We will soon make this route available for service
                        </div>
                    </div>
                </div>
            <?php }
            while($row = mysqli_fetch_assoc($result))
            {
                $citiesArr = explode(",",$row["route_cities"]);
                
                // Search the tables if we have any routes that matches the form details
                if(!in_array($source, $citiesArr) || !in_array($destination, $citiesArr) || !(array_search($source, $citiesArr) < array_search($destination, $citiesArr)))
                    continue;

                $route_id = $row["route_id"];
                $route_dep_time = $row["route_dep_time"];
                $route_stepCost = $row["route_step_cost"];
                $bus_no = $row["bus_no"];
                $no_available_seats = $row["available_seats"];
                $total_seats = $row["total_seats"];
                $source_idx = array_search($source, $citiesArr);
                $dest_idx = array_search($destination, $citiesArr);

                $viaCities = false;
                if($source_idx + 1 != $dest_idx)
                {
                    $viaCities = implode(",", array_slice($citiesArr, $source_idx + 1, $dest_idx - $source_idx));
                }

                $booking_amount = ($dest_idx - $source_idx) * $route_stepCost;
                
                $booked_seats = get_from_table($conn,"seats", "bus_no", $bus_no, "seat_booked");
                    
                $booked_seatsArr = [];

                if($booked_seats)
                $booked_seatsArr = explode(",", $booked_seats);

                // $no_available_seats = 38 - count($booked_seatsArr);
                ?>
                <div class="searched-container">
                    <div class="searched-result-item">
                        <div class="route-id">
                            <p>
                                <?php echo $route_id; ?>
                            </p>
                        </div>
                        <div class="timing">
                            <p>
                                <?php 
                                    echo $route_dep_time;
                                ?>
                            </p>
                        </div>
                        <div class="route-desc">
                            <p class="main-route">
                                <span class="source-route">
                                    <?php 
                                        echo $source;
                                    ?>
                                </span> 
                                <span class="arrow">&rarr;</span> 
                                <span class="dest-route">
                                    <?php 
                                        echo $destination;
                                    ?>
                                </span>
                            </p>
                            <p class="cities">
                                <?php if($viaCities){ ?>
                                    <span class="via">Via</span> 
                                    <?php 
                                        echo $viaCities;
                                }
                                else{ ?>
                                    <span class="via">Direct</span>
                                <?php }
                                ?>
                            </p>
                        </div>
                        <div class="seats-desc">
                            <div>
                                <span class="num-seats">
                                <!-- Total or taken?? -->
                                <?php 
                                    echo $no_available_seats;
                                ?>
                            </span> seats
                            </div>
                        </div>
                        <div class="booking-desc">
                            <p class="price"><i class="fas fa-rupee-sign"></i> 
                                <?php 
                                    echo $booking_amount;
                                ?></p>

                               <form action="checkout.php" method="post">
                                <input type="hidden" name="route_id" value="<?php echo $route_id; ?>">
                                <input type="hidden" name="source" value="<?php echo $source; ?>">
                                <input type="hidden" name="destination" value="<?php echo $destination; ?>">
                                <input type="hidden" name="bus_no" value="<?php echo $bus_no; ?>">
                                <input type="hidden" name="booking_amount" value="<?php echo $booking_amount; ?>">
                                <input type="hidden" name="booked_seats" value="<?php echo $booked_seats; ?>">
                                <input type="hidden" name="route_dep_time" value="<?php echo $route_dep_time; ?>">
                                <input type="hidden" name="total_seats" value="<?php echo $total_seats; ?>">
                                <input type="hidden" name="no_available_seats" value="<?php echo $no_available_seats; ?>">
                                <input type="submit" value="Book Now" name="book" class="btn btn-primary">
                               </form>             
                            <!-- <button class="book-seat-btn" data-busno="<?php 
                            echo $bus_no;?>" data-seats="<?php echo $booked_seats; ?>" data-routeid="<?php echo $route_id; ?>" data-amount="<?php echo $booking_amount; ?>" data-source="<?php echo $source; ?>" data-destination="<?php echo $destination; ?>">
                                Select Seats
                            </button> -->
                        </div>
                    </div>
                <!-- Book Row -->
                <div class="bookContainer">
                
                </div>
            </div>
        <?php  }?>
        </section>
    </main>
    <script src="assets/scripts/booking.js"></script>
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>