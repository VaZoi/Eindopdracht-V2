<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['booking_id'])) {
    echo "Booking ID not provided.";
    exit();
}

$booking_id = intval($_GET['booking_id']);

try {
    $bookingInfo = $user->firstbooking($booking_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($bookingInfo)) {
    echo "Booking not found.";
    exit();
}


try {

    $user->deletebooking($booking_id);

    header("Location: admin_bookings.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

