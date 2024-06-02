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
       if(isset($_SESSION["customer_loggedIn"]) || $_SESSION["customer_loggedIn"])
       {
          header("location: index.php");
       }
        require 'assets/styles/styles.php'
    ?>
</head>
<body>
    <?php require 'assets/partials/_header.php'; ?>
    <section class="vh-100 d-flex justify-content-center">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="./assets/img/login.webp"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="./assets/partials/user/_handleSignup.php" method="post">
                    <div class="form-outline mb-4">
                        <?php   
                            if(isset($_GET["user_exists"]) == 1){

                                echo '<div class="my-0 p-3 alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> User Already Exist
                                    </div>';
                            }
                        ?>
                    </div>
                <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="fname">First Name:</label>
                        <input type="text" id="fname" name="fname" class="form-control form-control-lg"
                        placeholder="Enter first name" required />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="lname">Last Name:</label>
                        <input type="text" id="lname" name="lname" class="form-control form-control-lg"
                        placeholder="Enter last name" required />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email Address:</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                        placeholder="Enter a valid email address" required />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="phone">Phone Number:</label>
                        <input type="number" id="phone" name="phone" class="form-control form-control-lg"
                        placeholder="Enter phone number" required />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                        placeholder="Enter password" required />
                    </div>
                    <!-- <div class="form-outline mb-3">
                        <label class="form-label" for="cpassword">Confirm Password:</label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control form-control-lg"
                        placeholder="Enter password" required />
                    </div> -->
                    <div class="form-outline mt-3">
                        <label class="form-label" for="male">Gender:</label>
                        <div class="d-flex" style="gap:10px">
                            <div class="d-flex" style="gap:10px">
                                <label for="male">Male: </label>
                                <input type="radio" name="gender" id="male" value="male" checked/>
                            </div>
                            <div class="d-flex" style="gap:10px">
                                <label for="female">Female: </label>
                                <input type="radio" name="gender" id="female" value="female" />
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                        style="padding-left: 2.5rem; padding-right: 2.5rem;" name="signup">Signup</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php"
                            class="link-danger">Login</a></p>
                    </div>

                </form>
            </div>
            </div>
        </div>
    </section>
</body>
</html>