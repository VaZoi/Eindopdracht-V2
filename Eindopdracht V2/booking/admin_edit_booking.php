<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['booking_id'])) {
    echo "Booking ID not provided.";
    exit();
}

$booking_id = intval($_GET['booking_id']);

try {
    $booking = $user->firstbooking($booking_id);
    if (!$booking) {
        echo "Booking not found";
        exit();
    }

    $csrfToken = $user->generateCsrfToken();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedcustomerid = htmlspecialchars($_POST['customer_id']);
    $updatedcarid = htmlspecialchars($_POST['car_id']);
    $updatedpickupdate = htmlspecialchars($_POST['pickup_date']);
    $updatedreturndate = htmlspecialchars($_POST['return_date']);
    $updatedpickuplocation = htmlspecialchars($_POST['pickup_location']);
    $updatedreturnlocation = htmlspecialchars($_POST['return_location']);
    $updatedstatus = htmlspecialchars($_POST['status']);

    $pickupDate = new DateTime($updatedpickupdate);
    $returnDate = new DateTime($updatedreturndate);
    $interval = $pickupDate->diff($returnDate);
    $totalDays = $interval->days;
    $updatedtotalcost = $totalDays * 30;

    try {
        $user->editbooking($updatedcustomerid, $updatedcarid, $updatedpickupdate, $updatedreturndate, $updatedpickuplocation, $updatedreturnlocation, $updatedtotalcost, $updatedstatus, $booking_id);

        header("Location: admin_bookings.php");
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
    <title>Admin - Edit Booking</title>
    <link rel="stylesheet" href="admin_edit.css">
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
        <h2>Edit Booking</h2>
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

            <label for="customer_id">Customer ID:</label>
            <select name="customer_id" required>
                <?php
                $customers = $user->getallcustomers();
                
                foreach ($customers as $customer) {
                    $selected = ($customer['user_id'] === $booking['customer_id']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($customer['user_id']) . "' $selected>" . htmlspecialchars($customer['user_id']) . "</option>";
                }
                ?>
            </select><br>

            <label for="car_id">Car ID:</label>
            <select name="car_id" required>
                <?php
                $cars = $user->getallcars();
                
                foreach ($cars as $car) {
                    $selected = ($car['car_id'] === $booking['car_id']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($car['car_id']) . "' $selected>" . htmlspecialchars($car['car_id']) . "</option>";
                }
                ?>
            </select><br>

            <label for="pickup_date">Pickup Date:</label>
            <input type="date" name="pickup_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($booking['pickup_date']); ?>" required><br>

            <label for="return_date">Return Date:</label>
            <input type="date" name="return_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($booking['return_date']); ?>" required><br>

            <label for="pickup_location">Pickup Location:</label>
            <select name="pickup_location" required>
                <?php
                $locations = $user->getalllocations();
                
                foreach ($locations as $location) {
                    $selected = ($location['location_id'] === $booking['pickup_location']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($location['location_id']) . "' $selected>" . htmlspecialchars($location['location_id']) . "</option>";
                }
                ?>
            </select><br>

            <label for="return_location">Return Location:</label>
            <select name="return_location" required>
                <?php
                foreach ($locations as $location) {
                    $selected = ($location['location_id'] === $booking['return_location']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($location['location_id']) . "' $selected>" . htmlspecialchars($location['location_id']) . "</option>";
                }
                ?>
            </select><br>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="Active" <?php echo ($booking['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Completed" <?php echo ($booking['status'] === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="Cancelled" <?php echo ($booking['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select><br>

            <button type="submit">Change Booking</button>
        </form>
    </main>
</body>
</html>
