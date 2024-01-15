<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

try {
    // Get all locations
    $locations = $user->getalllocations();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Location</title>
    <link rel="stylesheet" href="admin_all.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a href="../booking/admin_bookings.php">Bookings</a>
        <a href="../customers/admin_customers.php">Customers</a>
        <a href="../employees/admin_staff.php">Employees</a>
        <a href="../cars/admin_cars.php">Cars</a>
        <a class="active"  href="admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>

    <main>
        <div class="addlocations">
            <h2>Add a new location:</h2><br>

            <form action="admin_process_add_location.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <label for="image">Image:</label>
                <input type="file" name="image" required><br>

                <label for="location_name">Location Name:</label>
                <input type="text" name="location_name" required><br>

                <label for="postalcode">Postal Code:</label>
                <input type="text" name="postalcode" required><br>

                <label for="country">Country:</label>
                <select name="country" required>
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

                <label for="city">City:</label>
                <input type="text" name="city" required><br>

                <label for="street">Street:</label>
                <input type="text" name="street" required><br>

                <label for="housenumber">House Number:</label>
                <input type="number" name="housenumber" required><br>

                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <input type="submit" value="Add Location">
            </form>
        </div>

        <div class="showlocations">
            <?php if (!empty($locations)): ?>

                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Postal Code</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>House Number</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>

                        <?php foreach ($locations as $location): ?>
                            <tr>
                                <td><?php echo $location['location_id']; ?></td>
                                <td>
                                    <?php
                                    $imagePath = "uploads/" . $location['image'];
                                    echo "<img src='$imagePath' alt='Location Image' style='max-width: 100px; max-height: 100px;'>";
                                    ?>
                                </td>
                                <td><?php echo $location['location_name']; ?></td>
                                <td><?php echo $location['postalcode']; ?></td>
                                <td><?php echo $location['country']; ?></td>
                                <td><?php echo $location['city']; ?></td>
                                <td><?php echo $location['street']; ?></td>
                                <td><?php echo $location['housenumber']; ?></td>
                                <td><?php echo $location['phonenumber']; ?></td>
                                <td><?php echo $location['email']; ?></td>
                                <td>
                                    <a href="admin_edit_location.php?location_id=<?php echo $location['location_id']; ?>">Edit</a>
                                    <a href="admin_delete_location.php?location_id=<?php echo $location['location_id']; ?>" onclick="return confirm('Are you sure you want to delete this car?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No locations found.</p>
                <?php endif; ?>
        </div>
    </main>
</body>
</html>