<?php
include("connect.php");
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($con, $_POST['username']);
    $mypassword = $_POST['password'];  // No need to escape, as we'll use prepared statements

    if (empty($myusername)) {
        header("Location: index.php?error=Username required");
        exit();
    } else if(empty($mypassword)) {
        header("Location: index.php?error=Password required");
        exit();
    }else {
        $sql = "SELECT * FROM auth_table WHERE username = ?";
        $stmt = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($stmt, "s", $myusername);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($mypassword, $row['password'])) {
            $sessionToken = bin2hex(random_bytes(32));
            // Use secure and httponly flags, and set an expiration time
            setcookie('sessionToken', $sessionToken, time() + 60, '/', '', true, true);

            $_SESSION['username'] = $row['username'];

            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect Username or Password");
            exit();
        }

        mysqli_stmt_close($stmt);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo"><a href="index.php">Authentication</a></div>
        <ul class="nav-links">
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="index.php">Login</a></li>
        </ul>
    </nav>

    <div class="container">
        <form action="" method="post">
            <h2>Login Here</h2>
            
            <?php if (isset($_GET['error'])) { ?>
				<p class = "error"><?php echo $_GET['error']; ?></p>
			<?php }?>

            <label for="username">Username</label>
            <input type="text" name="username">

            <label for="password">Password</label>
            <input type = "password" name = "password" id = "myInput">
                    
		    <input type = "checkbox" onclick = "myFunction()">Show Password
					
			<button type = "submit" name = "login" class = "submitbtn">Login</button>
            
			<p class = "check">Don't have an account? <a href = "index.php">Register</a></p>
            <p class="demo">Demo Account: demo | Demo@123</p>
			</form>
		</div>

        <script>
			function myFunction(){
				var a = document.getElementById("myInput");
				if(a.type === "password"){
					a.type = "text";
				}else{
					a.type = "password";
				}
			}
		</script>
</body>
</html>