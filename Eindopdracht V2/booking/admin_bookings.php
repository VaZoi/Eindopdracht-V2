<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

$csrfToken = $user->generateCsrfToken();

try {
    // Get all bookings
    $bookings = $user->getallbookings();
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
    <title>Admin - Bookings</title>
    <link rel="stylesheet" href="admin_all.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    
    <div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a class="active" href="admin_bookings.php">Bookings</a>
        <a href="../customers/admin_customers.php">Customers</a>
        <a href="../employees/admin_staff.php">Employees</a>
        <a href="../cars/admin_cars.php">Cars</a>
        <a href="../locations/admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>

    <main>
        <div class="addbookings">
            <h2>Booking Form</h2>
            <form action="admin_process_add_booking.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <label for="customer_id">Customer ID:</label>
                <select name="customer_id" required>
                <?php
                    $customers = $user->getallcustomers();
                    
                    foreach ($customers as $customer) {
                        echo "<option value='" . htmlspecialchars($customer['user_id']) . "'>" . htmlspecialchars($customer['user_id']) . "</option>";
                    }
                ?>
                </select><br>

                <label for="car_id">Car ID:</label>
                <select name="car_id" required>
                <?php
                $cars = $user->getallcars();
                
                foreach ($cars as $car) {
                    echo "<option value='" . htmlspecialchars($car['car_id']) . "'>" . htmlspecialchars($car['car_id']) . "</option>";
                }
                ?>
                </select><br>

                <label for="pickupdate">Pickup Date:</label>
                <input type="date" name="pickup_date" min="<?php echo date('Y-m-d'); ?>" required><br>

                <label for="returndate">Return Date:</label>
                <input type="date" name="return_date" min="<?php echo date('Y-m-d'); ?>" required><br>

                <label for="pickup_location">Pickup Location:</label>
                <select name="pickup_location" required>
                <?php
                $locations = $user->getalllocations();
                
                foreach ($locations as $location) {
                    echo "<option value='" . htmlspecialchars($location['location_id']) . "'>" . htmlspecialchars($location['location_id']) . "</option>";
                }
                ?>
                </select><br>

                <label for="return_location">Return Location:</label>
                <select name="return_location" required>
                <?php
                $locations = $user->getalllocations();
                
                foreach ($locations as $location) {
                    echo "<option value='" . htmlspecialchars($location['location_id']) . "'>" . htmlspecialchars($location['location_id']) . "</option>";
                }
                ?>
                </select><br>

                <button type="submit">Add Booking</button>
            </form>
        </div>

        <div class="showbookings">
        <h2>All Bookings</h2>
        <?php if (!empty($bookings)): ?>
            <table border="1">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer ID</th>
                    <th>Car ID</th>
                    <th>Pickup Date</th>
                    <th>Return Date</th>
                    <th>Pickup Location</th>
                    <th>Return Location</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['booking_id']; ?></td>
                        <td><?php echo $booking['customer_id']; ?></td>
                        <td><?php echo $booking['car_id']; ?></td>
                        <td><?php echo $booking['pickup_date']; ?></td>
                        <td><?php echo $booking['return_date']; ?></td>
                        <td><?php echo $booking['pickup_location']; ?></td>
                        <td><?php echo $booking['return_location']; ?></td>
                        <td><?php echo $booking['total_cost']; ?></td>
                        <td><?php echo $booking['status']; ?></td>
                        <td>
                            <?php if ($booking['status'] !== 'Completed' && $booking['status'] !== 'Cancelled'): ?>
                                <a href="admin_edit_booking.php?booking_id=<?php echo $booking['booking_id']; ?>">Edit</a>
                            <?php endif; ?>
                            |
                            <a href="admin_delete_booking.php?booking_id=<?php echo $booking['booking_id']; ?>">Delete</a>
                            |
                            <a href="booking_details.php?booking_id=<?php echo $booking['booking_id']; ?>">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
        </div>
    </main>
</body>
</html>