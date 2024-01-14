<?php
require 'user.php';

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit();
}

$user_id = intval($_GET['user_id']);

try {
    $userInfo = $user->firstuser($user_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($userInfo)) {
    echo "User not found.";
    exit();
}


try {

    $user->deleteemployee($user_id);

    header("Location: admin_staff.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
