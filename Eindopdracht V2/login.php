<?php

require 'user.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $pass = htmlspecialchars($_POST['password']);

    try {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $errorMessage = "CSRF token validation failed";
        } else {
            unset($_SESSION['csrf_token']);
            $userExist = $user->login($email, $pass);

            if ($userExist) {
                header("Location: home.php?logged_in");
                exit();
            } else {
                $errorMessage = "Incorrect username or password";
            }
        }
    } catch (\Exception $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
        exit();
    }
}

$csrfToken = $user->generateCsrfToken();
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Systeem</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($errorMessage !== ''): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        Email: <input type="text" name="email" placeholder="Email" required><br>
        Password: <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit">
    </form>
    <a href="register.php">Register here</a>
</body>
</html>
