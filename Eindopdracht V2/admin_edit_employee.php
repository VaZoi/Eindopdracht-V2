<?php
require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'];

try {
    $employee = $user->firstuser($user_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedFirstName = htmlspecialchars($_POST['firstname']);
    $updatedLastName = htmlspecialchars($_POST['lastname']);
    $updatedDateOfBirth = htmlspecialchars($_POST['dateofbirth']);
    $updatedWorkEmail = htmlspecialchars($_POST['work_email']);
    $updatedPrivateEmail = htmlspecialchars($_POST['private_email']);
    $updatedPhoneNumber = htmlspecialchars($_POST['phonenumber']);
    $updatedSalary = htmlspecialchars($_POST['salary']);
    $updatedDepartment = htmlspecialchars($_POST['department']);
    $updatedFunction = htmlspecialchars($_POST['function']);
    $updatedPostalCode = htmlspecialchars($_POST['postalcode']);
    $updatedCountry = htmlspecialchars($_POST['country']);
    $updatedCity = htmlspecialchars($_POST['city']);
    $updatedStreet = htmlspecialchars($_POST['street']);
    $updatedHouseNumber = htmlspecialchars($_POST['housenumber']);
    $updatedPassword = htmlspecialchars($_POST['password']);

    try {
        $user->editemployee($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedWorkEmail, $updatedPrivateEmail, $updatedPhoneNumber, $updatedSalary, $updatedDepartment, $updatedFunction, $updatedPostalCode, $updatedCountry, $updatedCity, $updatedStreet, $updatedHouseNumber, $updatedPassword, $user_id);
        header("Location: admin_staff.php");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <div class="sidebar">
        <a href="admin.php">Dashboard</a>
        <a href="admin_customers.php">Customers</a>
        <a class="active" href="admin_staff.php">Employees</a>
        <a href="admin_cars.php">Cars</a>
        <a href="admin_locations.php">Locations</a>
    </div>
    <main>
        <div class="editstaff">
            <h2>Edit Employee</h2>
            <form action="" method="POST">
                <!-- Include the CSRF token field -->
                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <input type="text" name="firstname" value="<?php echo $employee['firstname']; ?>" required><br>
                <input type="text" name="lastname" value="<?php echo $employee['lastname']; ?>" required><br>
                <input type="date" name="dateofbirth" value="<?php echo $employee['date_of_birth']; ?>" required><br>
                <input type="email" name="work_email" value="<?php echo $employee['work_email']; ?>" required><br>
                <input type="email" name="private_email" value="<?php echo $employee['private_email']; ?>" required><br>
                <input type="tel" name="phonenumber" value="<?php echo $employee['phonenumber']; ?>" required><br>
                <input type="number" name="salary" value="<?php echo $employee['salary']; ?>" required><br>
                <input type="text" name="department" value="<?php echo $employee['department']; ?>" required><br>
                <input type="text" name="function" value="<?php echo $employee['function']; ?>" required><br>
                <input type="text" name="postalcode" value="<?php echo $employee['postalcode']; ?>" required><br>
                <input type="text" name="country" value="<?php echo $employee['country']; ?>" required><br>
                <input type="text" name="city" value="<?php echo $employee['city']; ?>" required><br>
                <input type="text" name="street" value="<?php echo $employee['street']; ?>" required><br>
                <input type="number" name="housenumber" value="<?php echo $employee['housenumber']; ?>" required><br>
                <input type="password" name="password" placeholder="Enter new password"><br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
    </main>
</body>
</html>
