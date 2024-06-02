<header class="bg-white">
        <nav>
            <div>
                    <a href="index.php" class="nav-item nav-logo">SBTBS</a>
                    <!-- <a href="#" class="nav-item">Gallery</a> -->
            </div>
                
            <ul>
                <li><a href="index.php" class="nav-item">Home</a></li>
                <li><a href="about.php" class="nav-item">About</a></li>
                <li><a href="contact.php" class="nav-item">Contact</a></li>
            </ul>
            <div>
                <?php

                if(!isset($_SESSION["customer_loggedIn"]) || !$_SESSION["customer_loggedIn"])
                {
                    echo '<a href="login.php" class="login nav-item"><i class="fas fa-sign-in-alt" style="margin-right: 0.4rem;"></i>Login</a>';
                }else{
                    echo '<a href="profile.php" class="login nav-item"><i class="fas fa-user" style="margin-right: 0.4rem;"></i>Profile</a>';
                    echo '<a href="assets/partials/user/_logout.php" class="login nav-item"><i class="fas fa-sign-out-alt" style="margin-right: 0.4rem;"></i>Logout</a>';
                }
                ?>
            </div>
        </nav>
    </header>