<?php

    session_start();

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to a login page or any other page of your choice after logout
    header("Location: login.php"); // Replace "login.php" with the appropriate URL

    // Make sure to exit after redirecting
    exit();

?>