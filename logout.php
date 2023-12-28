
<?php
// Clear session-related data
session_start();
session_unset();
session_destroy();

// Clear the session token cookie
setcookie('sessionToken', '', time() - 3600, '/', '', true, true);

header("Location: index.php");
exit();


?>