<?php

require '../user.php';

if (!$user->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

try {
    // Get all cars
    $cars = $user->getallcars();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars of VZ Rent</title>
    <link rel="stylesheet" href="cars.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <header>
        <nav class="desktop-nav">
            <ul>
                <li><a href="../home.php"><img src="../images/logo.png" alt="logo" width="50px"></a></li>
                <li><a href="RentCar.php"> Rent A Car</a></li>
                <li><a class="active" href="Cars.php"> Cars</a></li>
                <li><a href="services.php"> Locations</a></li>
                <li><a href="booked.php"> Bookings</a></li>
                <?php
                    if ($user->isLoggedInAsAdmin()) {
                        echo '<li><a href="../admin.php">Admin Page</a></a>';
                    }
                ?>
                <li><a href="../logout.php"> Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php foreach($cars as $car): ?>
        <div class="card">
            <?php
                $imagePath = "../cars/uploads/" . $car['image'];
                echo "<img src='$imagePath' alt='Car Image' style='max-width: 300px; max-height: 300px;'>";
            ?>
            <h4>Car ID: <?php echo $car['car_id']; ?></h4>
            <p>Brand: <?php echo $car['brand']; ?></p>
            <p>Model: <?php echo $car['model']; ?></p>
            <p>Licence Plate: <?php echo $car['licence_plate']; ?></p>
            <p>Year: <?php echo $car['year']; ?></p>
            <p>Color: <?php echo $car['color']; ?></p>
            <p>Fuel Type: <?php echo $car['fueltype']; ?></p>
            <p>Availability: <?php echo $car['availability']; ?></p>
        </div>
        <?php endforeach; ?>
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