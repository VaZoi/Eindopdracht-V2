<?php

require '../user.php';

if (!$user->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$csrfToken = $user->generateCsrfToken();

$loggedInUserId = $_SESSION['user_id'];

$bookings = $user->getCustomerBookings($loggedInUserId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent A VZ Car</title>
    <link rel="stylesheet" href="rentcar.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <header>
        <nav class="desktop-nav">
            <ul>
                <li><a href="../home.php"><img src="../images/logo.png" alt="logo" width="50px"></a></li>
                <li><a class="active" href="RentCar.php"> Rent A Car</a></li>
                <li><a href="Cars.php"> Cars</a></li>
                <li><a href="services.php"> Locations</a></li>
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
        <div class="rentacar">
            <h2>Book A Car</h2>
            <form action="process_booking.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="customer_id" value="<?php echo $loggedInUserId; ?>">
                <label for="car_id">Car ID:</label>
                <select name="car_id" required>
                <?php
                $cars = $user->getallcars();
                
                foreach ($cars as $car) {
                    echo "<option value='" . htmlspecialchars($car['car_id']) . "'>" . htmlspecialchars($car['car_id']) . "</option>";
                }
                ?>
                </select><br>

                <label for="pickupdate">Pickup Date:</label>
                <input type="date" name="pickup_date" min="<?php echo date('Y-m-d'); ?>" required><br>

                <label for="returndate">Return Date:</label>
                <input type="date" name="return_date" min="<?php echo date('Y-m-d'); ?>" required><br>

                <label for="pickup_location">Pickup Location:</label>
                <select name="pickup_location" required>
                    <?php
                    $locations = $user->getalllocations();

                    foreach ($locations as $location) {
                        echo "<option value='" . htmlspecialchars($location['location_id']) . "'>" . htmlspecialchars($location['location_name']) . "</option>";
                    }
                    ?>
                </select><br>

                <label for="return_location">Return Location:</label>
                <select name="return_location" required>
                    <?php
                    foreach ($locations as $location) {
                        echo "<option value='" . htmlspecialchars($location['location_id']) . "'>" . htmlspecialchars($location['location_name']) . "</option>";
                    }
                    ?>
                </select><br>

                <button type="submit">Book Car</button>
            </form>
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