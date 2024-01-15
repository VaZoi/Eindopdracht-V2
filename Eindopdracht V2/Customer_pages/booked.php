<?php
require '../user.php';

if (!$user->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$loggedInUserId = $_SESSION['user_id'];

$bookings = $user->getCustomerBookings($loggedInUserId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="booked.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
</head>

<body>
    <header>
        <nav class="desktop-nav">
            <ul>
                <li><a href="../home.php"><img src="../images/logo.png" alt="logo" width="50px"></a></li>
                <li><a href="RentCar.php"> Rent A Car</a></li>
                <li><a href="Cars.php"> Cars</a></li>
                <li><a href="services.php"> Locations</a></li>
                <li><a class="active" href="booked.php"> Bookings</a></li>
                <?php
                    if ($user->isLoggedInAsAdmin()) {
                        echo '<li><a href="admin.php">Admin Page</a></a>';
                    }
                ?>
                <li><a href="../logout.php"> Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="booking-list">
            <h1>My Bookings</h1>

            <?php if (empty($bookings)) : ?>
                <p>No bookings found.</p>
            <?php else : ?>
                <ul>
                    <?php foreach ($bookings as $booking) : ?>
                        <li>
                            <p>
                                Booking ID: <?php echo $booking['booking_id']; ?> |
                                Pickup Date: <?php echo $booking['pickup_date']; ?> |
                                Return Date: <?php echo $booking['return_date']; ?> |
                                Total Cost: $<?php echo $booking['total_cost']; ?> |
                                <a href="booking_details.php?booking_id=<?php echo $booking['booking_id']; ?>">View Details</a>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>