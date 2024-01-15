<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

try {
    // Get all employees
    $employees = $user->getallemployees();
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
    <title>Admin - Staff</title>
    <link rel="stylesheet" href="admin_all.css">
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
        <div class="addstaff">
            <h2>Add Employee</h2>
            <form action="admin_process_add_employee.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">
            <label for="firstname">First Name:</label>
                <input type="text" name="firstname" required><br>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" required><br>

                <label for="dateofbirth">Date of Birth:</label>
                <input type="date" name="dateofbirth" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"><br>

                <label for="work_email">Work Email:</label>
                <input type="email" name="work_email" required><br>

                <label for="private_email">Private Email:</label>
                <input type="email" name="private_email" required><br>

                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" required><br>

                <label for="salary">Salary:</label>
                <input type="number" name="salary" required><br>

                <label for="department">Department:</label>
                <input type="text" name="department" required><br>

                <label for="function">Function:</label>
                <input type="text" name="function" required><br>

                <label for="postalcode">Postal Code:</label>
                <input type="text" name="postalcode" required><br>

                <label for="country">Country:</label>
                <select id="country" name="country" required><br>
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

                <input type="submit" class="submit" value="Add Employee">
            </form>
        </div>
        <div class="showstaff">
            <h2>Show Employees</h2>
            <?php if (!empty($employees)): ?>
                <table border="1">
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Work Email</th>
                        <th>Private Email</th>
                        <th>Phone Number</th>
                        <th>Salary</th>
                        <th>Department</th>
                        <th>Function</th>
                        <th>Postal Code</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Street</th>
                        <th>House Number</th>
                        <th>Action</th>
                    </tr>

                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo $employee['staff_id']; ?></td>
                            <td><?php echo $employee['firstname']; ?></td>
                            <td><?php echo $employee['lastname']; ?></td>
                            <td><?php echo $employee['date_of_birth']; ?></td>
                            <td><?php echo $employee['work_email']; ?></td>
                            <td><?php echo $employee['private_email']; ?></td>
                            <td><?php echo $employee['phonenumber']; ?></td>
                            <td><?php echo $employee['salary']; ?></td>
                            <td><?php echo $employee['department']; ?></td>
                            <td><?php echo $employee['function']; ?></td>
                            <td><?php echo $employee['postalcode']; ?></td>
                            <td><?php echo $employee['country']; ?></td>
                            <td><?php echo $employee['city']; ?></td>
                            <td><?php echo $employee['street']; ?></td>
                            <td><?php echo $employee['housenumber']; ?></td>
                            <td>
                                <a href="admin_edit_employee.php?staff_id=<?php echo $employee['staff_id']; ?>">Edit</a>
                                |
                                <a href="admin_delete_employee.php?staff_id=<?php echo $employee['staff_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No employees found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
