<?php
session_start();
require '../user.php';

if (!$user->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

try {
    // Get all locations
    $locations = $user->getalllocations();
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
    <title>Services | Locations</title>
    <link rel="stylesheet" href="services.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <header>
        <nav class="desktop-nav">
            <ul>
                <li><a href="../home.php"><img src="../images/logo.png" alt="logo" width="50px"></a></li>
                <li><a href="RentCar.php"> Rent A Car</a></li>
                <li><a href="Cars.php"> Cars</a></li>
                <li><a class="active" href="services.php"> Locations</a></li>
                <li><a href="booked.php"> Bookings</a></li>
                <?php
                    if ($user->isLoggedInAsAdmin()) {
                        echo '<li><a href="admin.php">Admin Page</a></a>';
                    }
                ?>
                <li><a href="../logout.php"> Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="locations">
        <?php foreach($locations as $location): ?>
        <div class="card">
            <?php
                $imagePath = "../locations/uploads/" . $location['image'];
                echo "<img src='$imagePath' alt='Car Image' style='max-width: 200px; max-height: 200px;'>";
            ?>
            <h4>Name: <?php echo $location['location_name']; ?></h4>
            <p>Postal Code: <?php echo $location['postalcode']; ?></p>
            <p>Country: <?php echo $location['country']; ?></p>
            <p>City: <?php echo $location['city']; ?></p>
            <p>Street: <?php echo $location['street']; ?></p>
            <p>HouseNumber: <?php echo $location['housenumber']; ?></p>
            <p>Phonenumber: <?php echo $location['phonenumber']; ?></p>
            <p>Email: <?php echo $location['email']; ?></p>
        </div>
        <?php endforeach; ?>
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