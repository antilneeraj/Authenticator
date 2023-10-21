<?php
// Start a new session
session_start();

// check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blank";
    } else {
        $username = trim($_POST['username']);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } else {
        $password = trim($_POST['password']);
    }

    // If there were no errors, go ahead and try to login the user
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connect, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = $username;

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt)) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // This means the password is correct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        }
                    }
                }
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devicewidth, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@100;200;400&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <nav>
        <div class='container'>
            <span class="roseGrad">Authenticator</span>
            <ul>
                <li class="navItems"><a href="#">Home</a></li>
                <li class="navItems"><a href="#">About Us</a></li>
                <li class="navItems"><a href="#">Course</a></li>
            </ul>
            <div style="width:max-content;display:flex;gap:20px;">
                <a href="./register.php">
                    <button class="btn" type='Submit'>Register</button>
                </a>
            </div>
        </div>
    </nav>

    <!--Registration Form Content -->
    <div class="formContainer">
        <form action="" method="post">
            <div style="margin:-20px 0 30px 0; display:grid; place-items:center;">
                <span class="roseGrad">Login</span>
            </div>
            <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="Username" name="username" required>

            <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="password" placeholder="Password" name="password" required>

            <div style="display:flex;align-items:center;height:fit-content;justify-content:flex-start  ;gap:5px;margin-bottom:10px">
                <input type="checkbox" required /><span style="font-family:'k2d'; color:#fff;font-size:.8rem;">I Agree To Login</span>
            </div>
            <button type='submit' class="btn" style="width:100%;height:40px;margin-top:10px">Login</button>
        </form>
    </div>

</body>

</html>