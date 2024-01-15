<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
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

        header("Location: admin_customers.php");
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
    <link rel="stylesheet" href="admin_edit.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a href="../booking/admin_bookings.php">Bookings</a>
        <a class="active" href="admin_customers.php">Customers</a>
        <a href="../employees/admin_staff.php">Employees</a>
        <a href="../cars/admin_cars.php">Cars</a>
        <a href="../locations/admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>

    <main>
    <h2>Edit User</h2>
    
    <form method="POST">
        <input type="text" name="firstname" value="<?php echo $userInfo['firstname']; ?>" required><br>
        <input type="text" name="lastname" value="<?php echo $userInfo['lastname']; ?>" required><br>
        <input type="date" name="dateofbirth" value="<?php echo $userInfo['date_of_birth']; ?>" required
               max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"><br>
        <input type="email" name="email" value="<?php echo $userInfo['email']; ?>" required><br>
        <input type="tel" name="phonenumber" value="<?php echo $userInfo['phonenumber']; ?>" required><br>
        <input type="text" name="postalcode" value="<?php echo $userInfo['postalcode']; ?>" required><br>
        <select id="country" name="country" required>
        <option value="<?php $car['country']; ?>"></option>
                <?php
                $countries = [
                    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria",
                    "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan",
                    "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Côte d'Ivoire", "Cabo Verde",
                    "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)",
                    "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia (Czech Republic)", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic",
                    "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (fmr. 'Swaziland')", "Ethiopia", "Fiji", "Finland",
                    "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea",
                    "Guinea-Bissau", "Guyana", "Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran",
                    "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
                    "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania",
                    "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius",
                    "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar (formerly Burma)", "Namibia",
                    "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway",
                    "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
                    "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino",
                    "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands",
                    "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
                    "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
                    "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu",
                    "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                ];
                
                foreach ($countries as $country) {
                    $value = strtolower(str_replace(' ', '_', $country));
                    echo "<option value=\"$value\">$country</option>";
                }
                ?>
                </select><br>
        <input type="text" name="city" value="<?php echo $userInfo['city']; ?>" required><br>
        <input type="text" name="street" value="<?php echo $userInfo['street']; ?>" required><br>
        <input type="number" name="housenumber" value="<?php echo $userInfo['housenumber']; ?>" required><br>
        <input type="password" name="password" placeholder="Enter new password"><br>

        <input class="submit" type="submit" value="Save Changes">
    </form>

    </main>
    
</body>
</html>