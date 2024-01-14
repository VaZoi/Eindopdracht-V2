<?php

require 'user.php';

// Controleer of de gebruiker is ingelogd
if ($user->isLoggedIn()) {
    $user->logout();

    // Stuur de gebruiker door naar de uitlogpagina of een andere pagina
    header("Location: login.php");
    exit();
} else {
    // Als de gebruiker niet is ingelogd, stuur ze dan naar de inlogpagina
    header("Location: login.php");
    exit();
}
?>
