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
</head>
<body>
    <header>
    <nav class="desktop-nav">
            <ul>
                <li><a href="home.php"><img src="logo.png" alt="logo" width="50px"></a></li>
                <li><a href="RentCar.php"> Rent A Car</a></li>
                <li><a href="Cars.php"> Cars</a></li>
                <li><a href="services.php"> Services | Locations</a></li>
                <li><a href="booked.php"> Bookings</a></li>
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
            <h3><a href="Cars.html">Check Cars</a><h3>
        </div>
        <div class="mainimage">
            <img src="car_rental.avif" alt="car rental image" height="600px">
            <div class="cardetails">
                <h4>&euro; 30 / day</h4>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <h2>Contact Us:</h2>
            <p><i class="fa fa-phone"></i> +020 8888 88 8888</p>
            <p><i class="fa fa-envelope"></i> info@vzcar.com</p>
            <div class="social-media">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-google-plus-g"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>