<?php

require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
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
</head>
<body>
    <div class="sidebar">
        <a href="admin.php">Dasboard</a>
        <a class="active" href="admin_customers.php">Customers</a>
        <a href="admin_staff.php">Employees</a>
        <a href="admin_cars.php">Cars</a>
        <a href="admin_locations.php">Locations</a>
    </div>
    <main>
        <div class="addcustomer">
            <h2>Add Customer</h2>
            <form method="post" action="process_add_customer.php">

                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" required><br>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" required><br>

                <label for="dateofbirth">Date of Birth:</label>
                <input type="date" name="dateofbirth" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" required><br>

                <label for="postalcode">Postal Code:</label>
                <input type="text" name="postalcode" required><br>

                <label for="country">Country:</label>
                <input type="text" name="country" required><br>

                <label for="city">City:</label>
                <input type="text" name="city" required><br>

                <label for="street">Street:</label>
                <input type="text" name="street" required><br>

                <label for="housenumber">House Number:</label>
                <input type="number" name="housenumber" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <input type="submit" value="Add Customer">
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