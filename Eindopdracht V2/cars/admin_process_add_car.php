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

    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $licence_plate = htmlspecialchars($_POST['licence_plate']);
    $year = htmlspecialchars($_POST['year']);
    $color = htmlspecialchars($_POST['color']);
    $fueltype = htmlspecialchars($_POST['fueltype']);
    $image = $_FILES["image"]["name"];

    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($image);

    try {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $lastCarId = $user->addcars($brand, $model, $licence_plate, $year, $color, $fueltype, $image);

            header("Location: admin_cars.php");
            exit();
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: admin_cars.php");
    exit();
}
