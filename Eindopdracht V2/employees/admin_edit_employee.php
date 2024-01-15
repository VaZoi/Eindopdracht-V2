<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['staff_id'])) {
    echo "Employee ID not provided.";
    exit();
}

$employee_id = intval($_GET['staff_id']);

try {
    $employee = $user->firstemployee($employee_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($employee)) {
    echo "Employee not found.";
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
        $user->editemployee($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedWorkEmail, $updatedPrivateEmail, $updatedPhoneNumber, $updatedSalary, $updatedDepartment, $updatedFunction, $updatedPostalCode, $updatedCountry, $updatedCity, $updatedStreet, $updatedHouseNumber, $updatedPassword, $employee_id);
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
    <link rel="stylesheet" href="admin_edit.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a href="../booking/admin_bookings.php">Bookings</a>
        <a href="../customers/admin_customers.php">Customers</a>
        <a class="active" href="admin_staff.php">Employees</a>
        <a href="../cars/admin_cars.php">Cars</a>
        <a href="../locations/admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>
    <main>
        <div class="editstaff">
            <h2>Edit Employee</h2>
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo $employee['firstname']; ?>" required><br>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo $employee['lastname']; ?>" required><br>

                <label for="dateofbirth">Date of Birth:</label>
                <input type="date" name="dateofbirth" id="dateofbirth" value="<?php echo $employee['date_of_birth']; ?>" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required><br>

                <label for="work_email">Work Email:</label>
                <input type="email" name="work_email" id="work_email" value="<?php echo $employee['work_email']; ?>" required><br>

                <label for="private_email">Private Email:</label>
                <input type="email" name="private_email" id="private_email" value="<?php echo $employee['private_email']; ?>" required><br>

                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" id="phonenumber" value="<?php echo $employee['phonenumber']; ?>" required><br>

                <label for="salary">Salary:</label>
                <input type="number" name="salary" id="salary" value="<?php echo $employee['salary']; ?>" required><br>

                <label for="department">Department:</label>
                <input type="text" name="department" id="department" value="<?php echo $employee['department']; ?>" required><br>

                <label for="function">Function:</label>
                <input type="text" name="function" id="function" value="<?php echo $employee['function']; ?>" required><br>

                <label for="postalcode">Postal Code:</label>
                <input type="text" name="postalcode" id="postalcode" value="<?php echo $employee['postalcode']; ?>" required><br>

                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="<?php echo $employee['country']; ?>"><?php echo $employee['country']; ?></option>
                    <?php
                    $countries = [
                        "Afghanistan", "Albania", "Algeria", //... (unchanged)
                    ];

                    foreach ($countries as $country) {
                        $value = strtolower(str_replace(' ', '_', $country));
                        echo "<option value=\"$value\">$country</option>";
                    }
                    ?>
                </select><br>

                <label for="city">City:</label>
                <input type="text" name="city" id="city" value="<?php echo $employee['city']; ?>" required><br>

                <label for="street">Street:</label>
                <input type="text" name="street" id="street" value="<?php echo $employee['street']; ?>" required><br>

                <label for="housenumber">House Number:</label>
                <input type="number" name="housenumber" id="housenumber" value="<?php echo $employee['housenumber']; ?>" required><br>

                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter new password"><br>

                <input type="submit" value="Save Changes">
            </form>
        </div>
    </main>
</body>
</html>
