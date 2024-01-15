<?php

require 'user.php';

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VZ Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
</head>
<body>
    <header>
    <nav class="desktop-nav">
            <ul>
                <li><a class="active" href="home.php"><img src="images/logo.png" alt="logo" width="50px"></a></li>
                <li><a href="Customer_pages/RentCar.php"> Rent A Car</a></li>
                <li><a href="Customer_pages/Cars.php"> Cars</a></li>
                <li><a href="Customer_pages/services.php"> Locations</a></li>
                <li><a href="Customer_pages/booked.php"> Bookings</a></li>
                <?php
                    if ($user->isLoggedInAsAdmin()) {
                        echo '<li><a href="admin.php">Admin Page</a></a>';
                    }
                ?>
                <li><a href="logout.php"> Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="maintext">
            <h2>RENT A BRAND NEW CAR</h2>
            <h1>VZ Rent</h1>
            <p>Welcome to our website! Here you can find the best cars for rent in
                various cities of The Netherlands. We offer a wide range of 4
                wheel drive cars. Our aim is to provide customers with
                high quality service at an affordable price. If you are looking for a car that suits your needs, we invite you to explore our catalogue.
            </p>
            <h3><a class="checkcars" href="Customer_pages/Cars.php">Check Cars</a></h3>
        </div>
        <div class="mainimage">
            <img src="images/car_rental.avif" alt="car rental image" height="600px">
            <div class="cardetails">
                <h3>&euro; 30 / day</h3>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <h2>Contact Us:</h2>
            <p><i class="fa fa-phone"></i> +020 8888 88 8888</p>
            <p><i class="fa fa-envelope"></i> info@vzcar.com</p>
            <div class="social-media">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/>
                </svg></a>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                </svg></a>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                </svg></a>
            </div>
        </div>
    </footer>
</body>
</html>