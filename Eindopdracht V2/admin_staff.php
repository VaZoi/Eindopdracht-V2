<?php

require 'user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: login.php");
    exit();
}

try {
    // Get all customers
    $customers = $user->getallemployees();
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
        <div class="addstaff">
            <h2>Add Employee</h2>
            <form action="process_add_employee.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">
                First Name: <input type="text" name="firstname" required><br>
                Last Name: <input type="text" name="lastname" required><br>
                Date of Birth: <input type="date" name="dateofbirth" required><br>
                Work Email: <input type="email" name="work_email" required><br>
                Private Email: <input type="email" name="private_email" required><br>
                Phone Number: <input type="tel" name="phonenumber" required><br>
                Salary: <input type="number" name="salary" required><br>
                Department: <input type="text" name="department" required><br>
                Function: <input type="text" name="function" required><br>
                Postal Code: <input type="text" name="postalcode" required><br>
                Country: <input type="text" name="country" required><br>
                City: <input type="text" name="city" required><br>
                Street: <input type="text" name="street" required><br>
                House Number: <input type="number" name="housenumber" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="Add Employee">
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
                            <td><?php echo $employee['user_id']; ?></td>
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
                                <a href="admin_edit_employee.php?id=<?php echo $employee['user_id']; ?>">Edit</a>
                                <a href="admin_delete_employee.php?id=<?php echo $employee['user_id']; ?>">Delete</a>
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
