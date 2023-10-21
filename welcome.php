<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devicewidth, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@100;200;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Welcome - <?php echo $_SESSION['username'] ?></title>
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
            <div style="width:max-content;display:flex;gap:20px;align-items:center">
                <div style="color:white;">
                    <p>Welcome, <?php echo $_SESSION['username'] ?></p>
                </div>
                <a href="./logout.php">
                    <button class="btn" style="display:flex; align-items:center;justify-content:center;gap:10px;width:100px" type='Submit'>Logout <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z" fill="white" />
                        </svg></button>
                </a>
            </div>
        </div>
    </nav>

    <div class="formContainer">
        <div style="background:rgba(0,0,0,0.6);backdrop-filter: blur(2px);border-radius:1in;height:0 40px;width:fit-content;">
            <span class="roseGrad" style="padding:10px;height:fit-content;width:fit-content">Hi! <?php echo $_SESSION['username'] ?>, This is the Main Dashboard Page</span>
        </div>
    </div>
</body>

</html>