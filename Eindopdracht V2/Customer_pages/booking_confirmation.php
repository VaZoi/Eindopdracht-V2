<?php
require '../user.php';

if (!$user->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['booking_id']) || empty($_GET['booking_id'])) {
    echo "Booking ID is missing or invalid.";
    exit();
}

$bookingId = $_GET['booking_id'];

try {
    $bookingInfo = $user->firstbooking($bookingId);
    if (!$bookingInfo) {
        echo "Booking not found.";
        exit();
    }

    $customerInfo = $user->firstuser($bookingInfo['customer_id']);
    $carInfo = $user->firstcar($bookingInfo['car_id']);
    $pickupLocationInfo = $user->firstlocation($bookingInfo['pickup_location']);
    $returnLocationInfo = $user->firstlocation($bookingInfo['return_location']);
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
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="booking_confirmation.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <header>
        <nav class="desktop-nav">
            <ul>
                <li><a href="../home.php"><img src="../images/logo.png" alt="logo" width="50px"></a></li>
                <li><a href="RentCar.php"> Rent A Car</a></li>
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
        <div class="orderconfirmation">
            <h1>Booking Confirmation</h1>

            <h2>User Information</h2>
            <p>Name: <?php echo $customerInfo['firstname'] . ' ' . $customerInfo['lastname']; ?></p>
            <p>Email: <?php echo $customerInfo['email']; ?></p>
            <p>Date of Birth: <?php echo $customerInfo['date_of_birth']; ?></p>
            <p>Phone Number: <?php echo $customerInfo['phonenumber']; ?></p>
            <p>Address: <?php echo $customerInfo['street'] . ', ' . $customerInfo['housenumber'] . ', ' . $customerInfo['city'] . ', ' . $customerInfo['country']; ?></p>

            <h2>Car Information</h2>
            <p>Car ID: <?php echo $carInfo['car_id']; ?></p>
            <p>Brand: <?php echo $carInfo['brand']; ?></p>
            <p>Model: <?php echo $carInfo['model']; ?></p>
            <p>License Plate: <?php echo $carInfo['licence_plate']; ?></p>
            <p>Year: <?php echo $carInfo['year']; ?></p>
            <p>Color: <?php echo $carInfo['color']; ?></p>
            <p>Fuel Type: <?php echo $carInfo['fueltype']; ?></p>
            <?php
                $imagePath = "../cars/uploads/" . $carInfo['image'];
                echo "<img src='$imagePath' alt='Car Image' style='max-width: 100px; max-height: 100px;'>";
            ?>

            <h2>Booking Information</h2>
            <p>Pickup Date: <?php echo $bookingInfo['pickup_date']; ?></p>
            <p>Return Date: <?php echo $bookingInfo['return_date']; ?></p>
            <p>Total Cost: $<?php echo $bookingInfo['total_cost']; ?></p>
            <p>Status: <?php echo $bookingInfo['status']; ?></p>

            <h2>Pickup Location Information</h2>
            <p>Name: <?php echo $pickupLocationInfo['location_name']; ?></p>
            <p>Address: <?php echo $pickupLocationInfo['street'] . ', ' . $pickupLocationInfo['housenumber'] . ', ' . $pickupLocationInfo['city'] . ', ' . $pickupLocationInfo['country']; ?></p>
            <p>Phone Number: <?php echo $pickupLocationInfo['phonenumber']; ?></p>
            <p>Email: <?php echo $pickupLocationInfo['email']; ?></p>

            <h2>Return Location Information</h2>
            <p>Name: <?php echo $returnLocationInfo['location_name']; ?></p>
            <p>Address: <?php echo $returnLocationInfo['street'] . ', ' . $returnLocationInfo['housenumber'] . ', ' . $returnLocationInfo['city'] . ', ' . $returnLocationInfo['country']; ?></p>
            <p>Phone Number: <?php echo $returnLocationInfo['phonenumber']; ?></p>
            <p>Email: <?php echo $returnLocationInfo['email']; ?></p>
        </div>
        <h4><a href="booked.php">Go to bookings</a></h4>
    </main>
</body>
</html>