<?php
require '../user.php';

if (!$user->isLoggedInAsAdmin()) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['employee_id'])) {
    echo "Employee ID not provided.";
    exit();
}

$employee_id = intval($_GET['employee_id']);

try {
    $employeeInfo = $user->firstemployee($employee_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($employeeInfo)) {
    echo "User not found.";
    exit();
}


try {

    $user->deleteemployee($employee_id);

    header("Location: admin_staff.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

