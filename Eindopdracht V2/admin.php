<?php

require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

$staffCount = 0;
$customerCount = 0;
$carCount = 0;
$getreservedcars = 0;
$locationCount = 0;
$activebookingsCount = 0;
$totalbookingsCount = 0;

$staffCount = $user->countStaff();
$customerCount = $user->countCustomers();
$carCount = $user->countcars();
$getreservedcars = $user->getReservedCars();
$locationCount = $user->countLocations();
$activebookingsCount = $user->getActiveBookingCount();
$totalbookingsCount = $user->gettotalbookings();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
</head>
<body>
    <div class="sidebar">
        <a class="active" href="admin.php">Dashboard</a>
        <a href="booking/admin_bookings.php">Bookings</a>
        <a href="customers/admin_customers.php">Customers</a>
        <a href="employees/admin_staff.php">Employees</a>
        <a href="cars/admin_cars.php">Cars</a>
        <a href="locations/admin_locations.php">Locations</a>
        <a href="home.php">Home Page</a>
        <a href="logout.php">Logout</a>
    </div>
    <main>
        <section>
            <div class="live-info" onclick="window.location.href='bookings/admin_booking.php'">
                <h3>Total Active Bookings: </h3>
                <h2><?php echo $activebookingsCount; ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='bookings/admin_booking.php'">
                <h3>Total Bookings: </h3>
                <h2><?php echo $totalbookingsCount; ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='customers/admin_customers.php'">
                <h3>Total Registered Customers: </h3>
                <h2><?php echo $customerCount ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='employees/admin_staff.php'">
                <h3>Total Employees: </h3>
                <h2><?php echo $staffCount; ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='cars/admin_cars.php'">
                <h3>Total Cars: </h3>
                <h2><?php echo $carCount; ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='cars/admin_cars.php'">
                <h3>Total Reserved Cars: </h3>
                <h2><?php echo $getreservedcars; ?></h2>
            </div>

            <div class="live-info" onclick="window.location.href='locations/admin_locations.php'">
                <h3>Total Locations: </h3>
                <h2><?php echo $locationCount; ?></h2>
            </div>
        </section>
    </main>
</body>
</html>