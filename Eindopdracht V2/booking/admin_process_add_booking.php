<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }
 
    $customerid = htmlspecialchars($_POST['customer_id']);
    $carid = htmlspecialchars($_POST['car_id']);
    $pickupdate = htmlspecialchars($_POST['pickup_date']);
    $returndate = htmlspecialchars($_POST['return_date']);
    $pickuplocation = htmlspecialchars($_POST['pickup_location']);
    $returnlocation = htmlspecialchars($_POST['return_location']);

    $pickupDate = new DateTime($pickupdate);
    $returnDate = new DateTime($returndate);
    if ($pickupDate == $returnDate) {
        $totalCost = 30;
    } else {
        $interval = $pickupDate->diff($returnDate);
        $totalDays = $interval->days;
        $totalCost = $totalDays * 30;
    }

    try {
        $booking = $user->addbooking($customerid, $carid, $pickupdate, $returndate, $pickuplocation, $returnlocation, $totalCost);
        
        header("Location: admin_bookings.php");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

header("Location: admin_bookings.php");
exit();
