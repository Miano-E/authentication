<?php
// Clear session-related data
session_start();
session_unset();
session_destroy();

// Set a session variable to indicate automatic logout
$_SESSION['auto_logout'] = true;
// Check if the user was automatically logged out
if (isset($_SESSION['auto_logout']) && $_SESSION['auto_logout']) {
    // Set the error message in the URL
    header("Location: index.php?error=Your session has timed out.");
    exit();
    // Clear the session variable
    unset($_SESSION['auto_logout']);
}

// Clear the session token cookie
setcookie('sessionToken', '', time() - 3600, '/', '', true, true);

header("Location: index.php");
exit();


?>