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
        if(isset($_SESSION["customer_loggedIn"]))
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
                <form method="post" action="./assets/partials/user/_handleLogin.php">
                <div class="form-outline mb-4">
                    <?php   
                        if(isset($_GET["error"]) == 1){

                            echo '<div class="my-0 p-3 alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> Invalid Credentials 
                                </div>';
                        }
                    ?>
                    </div>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                    placeholder="Enter a valid email address" required/>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg"
                    placeholder="Enter password" required/>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <!-- Checkbox -->
                    
                    <a href="#!" class="text-body">Forgot password?</a>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="signup.php"
                        class="link-danger">Register</a></p>
                </div>

                </form>
            </div>
            </div>
        </div>
    </section>
</body>
</html>