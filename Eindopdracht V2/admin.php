<?php

require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

$staffCount = 0;
$customerCount = 0;
$carCount = 0;
$locationCount = 0;
$staffCount = $user->countStaff();
$customerCount = $user->countCustomers();
$carCount = $user->countcars();
$locationCount = $user->countLocations();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <div class="sidebar">
        <a class="active" href="admin.php">Dasboard</a>
        <a href="admin_customers.php">Customers</a>
        <a href="admin_staff.php">Employees</a>
        <a href="admin_cars.php">Cars</a>
        <a href="admin_locations.php">Locations</a>
    </div>
    <main>
        <section>
            <div class="live-info" onclick="window.location.href='admin_customers.php'">
                <h3>Total Registered Customers: </h3>
                <p><?php echo $customerCount ?></p>
            </div>

            <div class="live-info" onclick="window.location.href='admin_staff.php'">
                <h3>Total Employees: </h3>
                <p><?php echo $staffCount; ?></p>
            </div>

            <div class="live-info" onclick="window.location.href='admin_cars.php'">
                <h3>Total Cars: </h3>
                <p><?php echo $carCount; ?></p>
            </div>

            <div class="live-info" onclick="window.location.href='admin_locations.php'">
                <h3>Total Locations: </h3>
                <p><?php echo $locationCount; ?></p>
            </div>
        </section>
    </main>
</body>
</html>