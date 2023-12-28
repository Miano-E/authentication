<?php
   include_once("connect.php");

   $fullName = "";
   $username = "";
   $email = "";
   $password = "";
   $confirmPassword = "";

   if(isset($_POST['register'])) {

    $fullName = $_POST['fullName'];
    $username = trim($_POST['username']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $errors = array();

    if($fullName == "") {
        $errors['fullName'] = "Full name field required";
    }else if(preg_match("#[0-9]+#", $fullName)) {
        $errors['fullName'] = "Name cannot contain numbers";
    }

    if($username == "") {
        $errors['username'] = "Username field required";
    }else if(strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters";
    }else if(!empty($username)) {
        $stmt = $con->prepare("SELECT username FROM auth_table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $errors['username'] = "Username already exists";
        }
    }

    if($email == "") {
        $errors['email'] = "Email field required";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Input a valid email";
    }else if(!empty($email)) {
        $stmt = $con->prepare("SELECT email FROM auth_table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0) {
            $errors['email'] = "Email already exists";
        }
    }

    if($password == "") {
        $errors['password'] = "Password field required";
    }else if(strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }else if(!preg_match("#[A-Z]+#", $password)) {
        $errors['password'] = "Uppercase characters required";
    }else if(!preg_match("#[0-9]#", $password)) {
        $errors['password'] = "Please include numbers";
    }

    if($confirmPassword == "") {
        $errors['confirmPassword'] = "Confirm field password";
    }else if($confirmPassword != $password) {
        $errors['confirmPassword'] = "Password Mismatch!";
    }

    

    if(empty($errors)) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $con->prepare("INSERT INTO auth_table(fullName, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssss", $fullName, $username, $email, $encpass);

        if($stmt->execute()) {

            $fullName = "";
            $username = "";
            $email = "";
            $password = "";
            $confirmPassword = "";

            echo "<script> alert('Data Submitted') </script>";
        }else {
            echo "<script> alert('Failed to submit') </script>";
        }
        
        $stmt->close();
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="eye.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
    <title>Authentication</title>
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
    <form action="" method="POST">
        <h1>Register Here</h1>
        <label for="fullName">Full Name</label>
        <input type="text" name="fullName" value="<?php echo isset($fullName) ? $fullName : ''; ?>">
        <p class="error"><?php if(isset($errors["fullName"])) echo $errors["fullName"]; ?></p>

        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo isset($username) ? $username : ''; ?>">
        <p class="error"><?php if(isset($errors["username"])) echo $errors["username"]; ?></p>

        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <p class="error"><?php if(isset($errors["email"])) echo $errors["email"]; ?></p>

        <div class = "password-input-container">
			<label for = "password">Password</label>
			<input type = "password" name = "password" class="form-control" id="id_password" value="<?php echo isset($password) ? $password : ''; ?>">
			<i class="fas fa-eye-slash" id="togglePassword"></i>
		</div>
					
		<p class = "error"><?php if(isset($errors['password'])) echo $errors['password'];?></p>
					
		<div class = "password-input-container">
			<label for = "confirmPassword">Confirm Password</label>
			<input type="password" name="confirmPassword" id="id_confirm_password" value="<?php echo isset($confirmPassword) ? $confirmPassword : ''; ?>">
			<i class="fas fa-eye-slash password-toggle" id="toggleconfirmPassword"></i>
		</div>

		<p class = "error"><?php if(isset($errors['confirmPassword'])) echo $errors['confirmPassword'];?></p>
					
        <button type="submit" name="register" class="submitbtn">Register</button>
        <p class="check">Already have an account? <a href="index.php">Login</a></p>
    </form>
  </div>

   <script src="eye.js"></script>

</body>
</html>