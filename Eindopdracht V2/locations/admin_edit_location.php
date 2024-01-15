<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

$location_id = intval($_GET['location_id']);

try {
    $location = $user->firstlocation($location_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($location)) {
    echo "Location not found.";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    $updatedimage = $_FILES["image"]["name"];
    $updatedname = htmlspecialchars($_POST['location_name']);
    $updatedpostalcode = htmlspecialchars($_POST['postalcode']);
    $updatedcountry = htmlspecialchars($_POST['country']);
    $updatedcity = htmlspecialchars($_POST['city']);
    $updatedstreet = htmlspecialchars($_POST['street']);
    $updatedhousenumber = htmlspecialchars($_POST['housenumber']);
    $updatedphonenumber = htmlspecialchars($_POST['phonenumber']);
    $updatedemail = htmlspecialchars($_POST['email']);

    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($updatedimage);

    try {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $user->editlocation($updatedimage, $updatedname, $updatedpostalcode, $updatedcountry, $updatedcity, $updatedstreet, $updatedhousenumber, $updatedphonenumber, $updatedemail, $location_id);
            header("Location: admin_locations.php");
            exit();
        }
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
    <title>Admin - Edit location</title>
    <link rel="stylesheet" href="admin_edit.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
<div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a href="../booking/admin_bookings.php">Bookings</a>
        <a href="../customers/admin_customers.php">Customers</a>
        <a href="../employees/admin_staff.php">Employees</a>
        <a href="../cars/admin_cars.php">Cars</a>
        <a class="active" href="admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>
    
    <main>
        <div class="editlocation">
            <h2>Edit Location</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <input type="file" name="image" value="<?php echo $location['image']; ?>" required><br>
                <input type="text" name="location_name" value="<?php echo $location['location_name']; ?>" required><br>

                <input type="text" name="postalcode" value="<?php echo  $location['postalcode']; ?>" required><br>
                <select name="country" required>
                <option value="<?php echo $location['country']; ?>"></option>
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
                    echo '<option value="' . $value . '">' . $country . '</option>';
                }
                ?>
                </select><br>
                <input type="text" name="city" value="<?php echo $location['city']; ?>" required><br>
                <input type="text" name="street" value="<?php echo $location['street']; ?>" required><br>
                <input type="number" name="housenumber" value="<?php echo $location['housenumber']; ?>" required><br>
                <input type="tel" name="phonenumber" value="<?php echo $location['phonenumber']; ?>" required><br>
                <input type="email" name="email" value="<?php echo $location['email']; ?>" required><br>

                <input type="submit" value="Save Changes">
            </form>
        </div>
    </main>
</body>
</html>