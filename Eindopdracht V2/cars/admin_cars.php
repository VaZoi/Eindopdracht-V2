<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

try {
    // Get all cars
    $cars = $user->getallcars();
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
    <title>Admin - Cars</title>
    <link rel="stylesheet" href="admin_all.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>
<body>
    <div class="sidebar">
        <a href="../admin.php">Dashboard</a>
        <a href="../booking/admin_bookings.php">Bookings</a>
        <a href="../customers/admin_customers.php">Customers</a>
        <a href="../employees/admin_staff.php">Employees</a>
        <a class="active" href="admin_cars.php">Cars</a>
        <a href="../locations/admin_locations.php">Locations</a>
        <a href="../home.php">Home Page</a>
        <a href="../logout.php">Logout</a>
    </div>

    <main>
        <div class="addcar">
        <h1>Add Car</h1>

        <form action="admin_process_add_car.php" method="post" enctype='multipart/form-data'>
            <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required><br>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required><br>

            <label for="licence_plate">Licence Plate:</label>
            <input type="text" id="licence_plate" name="licence_plate" required><br>

            <label for="year">Year:</label>
            <input type="number" id="year" name="year" min="1900" max="2099" required><br>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required><br>

            <label for="fueltype">Fuel Type:</label>
            <select name="fueltype" required>
            <option value="Petrol">Petrol</option>
            <option value="Electric">Electric</option>
            <option value="Diesel">Diesel</option>
            </select><br>

            <label for="image">Image:</label>
            <input type="file" name="image" required><br>

            <input type="submit" value="Add Car">
        </form>
        </div>
        

        <div class="showallcars">
        <h1>All Cars</h1>

        <?php if (!empty($cars)): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Licence Plate</th>
                    <th>Year</th>
                    <th>Color</th>
                    <th>Fuel Type</th>
                    <th>Availability</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>

                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?php echo $car['car_id']; ?></td>
                        <td><?php echo $car['brand']; ?></td>
                        <td><?php echo $car['model']; ?></td>
                        <td><?php echo $car['licence_plate']; ?></td>
                        <td><?php echo $car['year']; ?></td>
                        <td><?php echo $car['color']; ?></td>
                        <td><?php echo $car['fueltype']; ?></td>
                        <td><?php echo $car['availability']; ?></td>
                        <td>
                            <?php
                            $imagePath = "uploads/" . $car['image'];
                            echo "<img src='$imagePath' alt='Car Image' style='max-width: 100px; max-height: 100px;'>";
                            ?>
                        </td>
                        <td>
                            <a href="admin_edit_car.php?car_id=<?php echo $car['car_id']; ?>">Edit</a>
                            <a href="admin_delete_car.php?car_id=<?php echo $car['car_id']; ?>" onclick="return confirm('Are you sure you want to delete this car?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            <p>No cars found.</p>
        <?php endif; ?>
        </div>
    </main>
</body>
</html>