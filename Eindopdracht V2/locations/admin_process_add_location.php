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

    try {
        // Process form data
        $image = $_FILES["image"]["name"];
        $name = htmlspecialchars($_POST['location_name']);
        $postalcode = htmlspecialchars($_POST['postalcode']);
        $country = htmlspecialchars($_POST['country']);
        $city = htmlspecialchars($_POST['city']);
        $street = htmlspecialchars($_POST['street']);
        $housenumber = htmlspecialchars($_POST['housenumber']);
        $phonenumber = htmlspecialchars($_POST['phonenumber']);
        $email = htmlspecialchars($_POST['email']);

        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($image);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $user->addLocation($image, $name, $postalcode, $country, $city, $street, $housenumber, $phonenumber, $email);

        header("Location: admin_locations.php");
        exit();
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: admin_locations.php");
    exit();
}