<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

try {
    // Get all customers
    $customers = $user->getallcustomers();
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
    <title>Admin - Customers</title>
    <link rel="stylesheet" href="admin_all.css">
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
        <div class="addcustomer">
            <h2>Add Customer</h2>
            <form method="post" action="admin_process_add_customer.php">

                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" required><br>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" required><br>

                <label for="dateofbirth">Date of Birth:</label>
                <input type="date" name="dateofbirth" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" required><br>

                <label for="postalcode">Postal Code:</label>
                <input type="text" name="postalcode" required><br>

                <label for="country">Country:</label>
                <select id="country" name="country" required>
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

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <input type="submit" class="submit" value="Add Customer">
            </form>
        </div>
        <div class="showcustomers">
        <h2>All Customers</h2>
        
        <?php if (!empty($customers)): ?>
            <table border="1">
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Postal Code</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>House Number</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer['user_id']; ?></td>
                        <td><?php echo $customer['firstname']; ?></td>
                        <td><?php echo $customer['lastname']; ?></td>
                        <td><?php echo $customer['date_of_birth']; ?></td>
                        <td><?php echo $customer['email']; ?></td>
                        <td><?php echo $customer['phonenumber']; ?></td>
                        <td><?php echo $customer['postalcode']; ?></td>
                        <td><?php echo $customer['country']; ?></td>
                        <td><?php echo $customer['city']; ?></td>
                        <td><?php echo $customer['street']; ?></td>
                        <td><?php echo $customer['housenumber']; ?></td>
                        <td>
                            <a href="admin_edit_customer.php?user_id=<?php echo $customer['user_id']; ?>">Edit</a>
                            |
                            <a href="admin_delete_user.php?user_id=<?php echo $customer['user_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No customers found.</p>
        <?php endif; ?>
        </div>
    </main>
</body>
</html>