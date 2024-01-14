<?php
require 'user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $dateofbirth = htmlspecialchars($_POST['dateofbirth']);
    $email = htmlspecialchars($_POST['email']);
    $phonenumber = htmlspecialchars($_POST['phonenumber']);
    $postalcode = htmlspecialchars($_POST['postalcode']);
    $country = htmlspecialchars($_POST['country']);
    $city = htmlspecialchars($_POST['city']);
    $street = htmlspecialchars($_POST['street']);
    $housenumber = htmlspecialchars($_POST['housenumber']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $lastUserId = $user->adduser($firstname, $lastname, $dateofbirth, $email, $phonenumber, $postalcode, $country, $city, $street, $housenumber, $password);

        header("Location: admin_customers.php");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: admin_customers.php");
    exit();
}
?>
