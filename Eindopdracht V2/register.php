<?php

require 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                echo "CSRF token validation failed";
                exit();
            }
            
            unset($_SESSION['csrf_token']);

            $lastId = $user->adduser($firstname, $lastname, $dateofbirth, $email, $phonenumber, $postalcode, $country, $city, $street, $housenumber, $password);
            header("location:home.php?process=$lastId");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$csrfToken = $user->generateCsrfToken();
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Systeem</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        Firstname: <input type="text" name="firstname" placeholder="First Name" required><br>
        Lastname: <input type="text" name="lastname" placeholder="Last Name" required><br>
        Date of Birth: <input type="date" name="dateofbirth" placeholder='Date of birth' required
                             max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"><br>
        Email: <input type="email" name="email" placeholder="Email" required><br>
        Phonenumber: <input type="tel" name="phonenumber" placeholder="Phone Number" required><br>
        Postal code: <input type="text" name="postalcode" placeholder="Postal Code"required><br>
        Country: <input type="text" name="country" placeholder="Country" required><br>
        City: <input type="text" name="city" placeholder="City" required><br>
        Street: <input type="text" name="street" placeholder="Street" required><br>
        Housenumber: <input type="number" name="housenumber" placeholder="House Number" required><br>
        Wachtwoord: <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit">
    </form>
</body>
</html>
