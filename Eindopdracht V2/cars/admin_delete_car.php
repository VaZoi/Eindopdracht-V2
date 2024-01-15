<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['car_id'])) {
    echo "Car ID not provided.";
    exit();
}

$car_id = intval($_GET['car_id']);

try {
    $carInfo = $user->firstcar($car_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($carInfo)) {
    echo "Car not found.";
    exit();
}


try {

    $user->deletecar($car_id);

    header("Location: admin_cars.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

