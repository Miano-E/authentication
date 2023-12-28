<?php
    include "connect.php";
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: index.php"); // Redirect to the login page if not logged in
        exit();
    }

    if (isset($_SESSION['timeout'])) {
        $_SESSION['timeout'] = time() + $timeoutPeriod / 1000; // Convert milliseconds to seconds
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo"><a href="index.php">Authentication</a></div>
        <ul class="nav-links">
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Hello, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>!</h2>

            <p class="subheading">
                Welcome to the Home Page.
                Your privacy and security are our top priorities. 
                Don't forget to log out when you're done!
            </p>

                 
    </div>

    <script>
        // Set a timeout period in milliseconds (e.g., 15 seconds)
        const timeoutPeriod = 15 * 1000; 

        let timeoutTimer;

        function startTimeoutTimer() {
            // Clear any existing timers
            clearTimeout(timeoutTimer);

             // Set a new timer
        timeoutTimer = setTimeout(function () {
        // Redirect to logout.php when the session expires
        window.location.href = "timeoutLogout.php";
        }, timeoutPeriod);
    }

        // Start the timer when the page loads
        startTimeoutTimer();

        // Reset the timer on user interaction (e.g., mouse move or key press)
        document.addEventListener("mousemove", startTimeoutTimer);
        document.addEventListener("keypress", startTimeoutTimer);
    </script>


</body>
</html>
