<?php
require 'user.php';

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit();
}

$user_id = intval($_GET['user_id']);

try {
    $userInfo = $user->firstuser($user_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($userInfo)) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedFirstName = htmlspecialchars($_POST['firstname']);
    $updatedLastName = htmlspecialchars($_POST['lastname']);
    $updatedDateOfBirth = htmlspecialchars($_POST['dateofbirth']);
    $updatedEmail = htmlspecialchars($_POST['email']);
    $updatedPhoneNumber = htmlspecialchars($_POST['phonenumber']);
    $updatedPostalCode = htmlspecialchars($_POST['postalcode']);
    $updatedCountry = htmlspecialchars($_POST['country']);
    $updatedCity = htmlspecialchars($_POST['city']);
    $updatedStreet = htmlspecialchars($_POST['street']);
    $updatedHouseNumber = htmlspecialchars($_POST['housenumber']);
    $updatedPassword = htmlspecialchars($_POST['password']);

    try {
        $user->edituser($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedEmail, $updatedPhoneNumber, $updatedPostalCode, $updatedCountry, $updatedCity, $updatedStreet, $updatedHouseNumber, $updatedPassword, $user_id);

        header("Location: user_list.php");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<div class="sidebar">
        <a href="admin.php">Dashboard</a>
        <a class="active" href="admin_customers.php">Customers</a>
        <a href="admin_staff.php">Employees</a>
        <a href="admin_cars.php">Cars</a>
        <a href="admin_locations.php">Locations</a>
    </div>

    <main>
    <h2>Edit User</h2>
    
    <form method="POST">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" value="<?php echo $userInfo['firstname']; ?>" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" value="<?php echo $userInfo['lastname']; ?>" required><br>

        <label for="dateofbirth">Date of Birth:</label>
        <input type="date" name="dateofbirth" value="<?php echo $userInfo['date_of_birth']; ?>" required
               max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $userInfo['email']; ?>" required><br>

        <label for="phonenumber">Phone Number:</label>
        <input type="tel" name="phonenumber" value="<?php echo $userInfo['phonenumber']; ?>" required><br>

        <label for="postalcode">Postal Code:</label>
        <input type="text" name="postalcode" value="<?php echo $userInfo['postalcode']; ?>" required><br>

        <label for="country">Country:</label>
        <input type="text" name="country" value="<?php echo $userInfo['country']; ?>" required><br>

        <label for="city">City:</label>
        <input type="text" name="city" value="<?php echo $userInfo['city']; ?>" required><br>

        <label for="street">Street:</label>
        <input type="text" name="street" value="<?php echo $userInfo['street']; ?>" required><br>

        <label for="housenumber">House Number:</label>
        <input type="number" name="housenumber" value="<?php echo $userInfo['housenumber']; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter new password"><br>

        <input type="submit" value="Update">
    </form>

    </main>
    
</body>
</html>