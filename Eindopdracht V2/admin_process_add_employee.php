<?php

require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $dateofbirth = htmlspecialchars($_POST['dateofbirth']);
    $work_email = htmlspecialchars($_POST['work_email']);
    $private_email = htmlspecialchars($_POST['private_email']);
    $phonenumber = htmlspecialchars($_POST['phonenumber']);
    $salary = htmlspecialchars($_POST['salary']);
    $department = htmlspecialchars($_POST['department']);
    $function = htmlspecialchars($_POST['function']);
    $postalcode = htmlspecialchars($_POST['postalcode']);
    $country = htmlspecialchars($_POST['country']);
    $city = htmlspecialchars($_POST['city']);
    $street = htmlspecialchars($_POST['street']);
    $housenumber = htmlspecialchars($_POST['housenumber']);
    $password = htmlspecialchars($_POST['password']);

    // Add the employee
    try {
        $lastId = $user->addemployee($firstname, $lastname, $dateofbirth, $work_email, $private_email, $phonenumber, $salary, $department, $function, $postalcode, $country, $city, $street, $housenumber, $password);

        header("Location: admin_staff.php?process=$lastId");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

header("Location: admin_staff.php");
exit();
?>