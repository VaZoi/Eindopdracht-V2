<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['location_id'])) {
    echo "Location ID not provided.";
    exit();
}

$location_id = intval($_GET['location_id']);

try {
    $locationInfo = $user->firstlocation($location_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($locationInfo)) {
    echo "Location not found.";
    exit();
}


try {

    $user->deletelocation($location_id);

    header("Location: admin_locations.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

