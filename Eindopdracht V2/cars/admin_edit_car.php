<?php

require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['car_id'])) {
    echo "Car ID not provided.";
    exit();
}

$car_id = intval($_GET['car_id']);

try {
    $carinfo = $user->firstcar($car_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($carinfo)) {
    echo "Car not found.";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedbrand = htmlspecialchars($_POST['brand']);
    $updatedmodel = htmlspecialchars($_POST['model']);
    $updatedlicence_plate = htmlspecialchars($_POST['licence_plate']);
    $updatedyear = htmlspecialchars($_POST['year']);
    $updatedcolor = htmlspecialchars($_POST['color']);
    $updatedfueltype = htmlspecialchars($_POST['fueltype']);
    $updatedavailability = htmlspecialchars($_POST['availability']);
    $updatedimage = $_FILES["image"]["name"];

    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($updatedimage);

    try {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $user->editcars($updatedbrand, $updatedmodel, $updatedlicence_plate, $updatedyear, $updatedcolor, $updatedfueltype, $updatedavailability, $updatedimage, $car_id);
            header("Location: admin_cars.php");
            exit();
        } else {
            throw new \Exception("Error uploading file.");
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
    <title>Admin - Edit Car</title>
    <link rel="stylesheet" href="admin_edit.css">
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
        <div class="editcar">
            <h2>Edit Car</h2>
            <form action="" method="POST" enctype='multipart/form-data'>
                <input type="hidden" name="csrf_token" value="<?php echo $user->generateCsrfToken(); ?>">

                <label for="brand">Brand:</label>
                <input type="text" name="brand" value="<?php echo $carinfo['brand']; ?>" required><br>

                <label for="model">Model:</label>
                <input type="text" name="model" value="<?php echo $carinfo['model']; ?>" required><br>

                <label for="licence_plate">License Plate:</label>
                <input type="text" name="licence_plate" value="<?php echo $carinfo['licence_plate']; ?>" required><br>

                <label for="year">Year:</label>
                <input type="number" name="year" min="1900" max="2099" value="<?php echo $carinfo['year']; ?>" required><br>

                <label for="color">Color:</label>
                <input type="text" name="color" value="<?php echo $carinfo['color']; ?>" required><br>

                <label for="fueltype">Fuel Type:</label>
                <select name="fueltype" required>
                    <option value="<?php echo $carinfo['fueltype']; ?>"></option>
                    <option value="Petrol">Petrol</option>
                    <option value="Electric">Electric</option>
                    <option value="Diesel">Diesel</option>
                </select><br>

                <label for="image">Image:</label>
                <input type="file" name="image" value="<?php echo $carinfo['image']; ?>" required><br>

                <input type="submit" value="Save Changes">
            </form>
        </div>
    </main>
</body>
</html>
