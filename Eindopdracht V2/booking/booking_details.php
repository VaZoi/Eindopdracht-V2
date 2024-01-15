<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

$bookingId = $_GET['booking_id'];

$bookingInfo = $user->firstbooking($bookingId);
$customerInfo = $user->firstuser($bookingInfo['customer_id']);
$carInfo = $user->firstcar($bookingInfo['car_id']);
$pickupLocationInfo = $user->firstlocation($bookingInfo['pickup_location']);
$returnLocationInfo = $user->firstlocation($bookingInfo['return_location']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="../Customer_pages/booking_confirmation.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
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
        <h4><a href="admin_bookings.php">Go back to bookings</a></h4>
    </main>
</body>
</html>