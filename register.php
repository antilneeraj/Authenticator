<?php

require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$rollno = $mobileno  = $email = $city = $pincode = $state = $country = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // check if username is not empty
  if (empty(trim($_POST['username']))) {
    $username_err = "Username cannot be blank";
  } else {
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connect, $sql);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // set the value of param username
      $param_username = trim($_POST['username']);

      // try to execute this statement
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This username is already taken";
        } else {
          $username = trim($_POST['username']);
        }
      } else {
        echo "Some Error Occured Try Again";
      }
    }
  }

  mysqli_stmt_close($stmt);

  // check for password
  if (empty(trim($_POST['password']))) {
    $password_err = "Password cannot be blank";
  } elseif (strlen(trim($_POST['password'])) < 5) {
    $password_err = "Password cannot be less than 5 characters";
  } else {
    $password = trim($_POST['password']);
  }

  // check for confirm password
  if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
    $password_err = "Passwords doesn't Match";
  }

  // Set values for the rest of the fields
  $rollno = isset($_POST['rollno']) ? trim($_POST['rollno']) : "";   // trim($_POST['rollno']) || "";
  $mobileno = isset($_POST['mobileno']) ? trim($_POST['mobileno']) : "";
  $email = isset($_POST['email']) ? trim($_POST['email']) : "";
  $city = isset($_POST['city']) ? trim($_POST['city']) : "";
  $state = isset($_POST['state']) ? trim($_POST['state']) : "";
  $country = isset($_POST['country']) ? trim($_POST['country']) : "";

  // if there were no errors, go ahead and insert into the database
  if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
    // $sql = "INSERT INTO users (username, password ) VALUES (?, ?)";
    $sql = "INSERT INTO users (rollno, username, password, email, mobileno, city, state, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $sql);
    if ($stmt) {
      // mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
      mysqli_stmt_bind_param($stmt, "ssssssss", $param_rollno, $param_username, $param_password, $param_email, $param_mobileno, $param_city, $param_state, $param_country);

      // set these parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT);     // Creates a password hash
      $param_rollno = $rollno;
      $param_mobileno = $mobileno;
      $param_email = $email;
      $param_city = $city;
      $param_state = $state;
      $param_country = $country;

      // try to execute the query
      if (mysqli_stmt_execute($stmt)) {
        header("location: login.php");
      } else {
        echo "Something went wrong... cannot redirect!";
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($connect);
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
  <title>Register</title>
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
        <a href="./login.php">
          <button class="btn" type='Submit'>Login</button>
        </a>
      </div>
    </div>
  </nav>

  <!--Registration Form Content -->
  <div class="formContainer">
    <form action="" method="post">
      <div style="margin:-20px 0 30px 0; display:grid; place-items:center;">
        <span class="roseGrad">Register</span>
      </div>
      <div style="width:100%">
        <div class="twoElements">
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="Username" name="username" required>
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="number" placeholder="Roll no." name="rollno" required>
        </div>
        <div class="twoElements">
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="number" pattern="/^(\+\d{1,3}[- ]?)?\d{10}$/" placeholder="Mobile no." name="mobileno" required>
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="email" placeholder="Email" name="email" required>
        </div>
        <div class="twoElements">
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="password" placeholder="Password" name="password" required>
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="password" placeholder="Confirm Password" name="confirm_password" required>
        </div>
        <div class="twoElements">
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="City" name="city" required>
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="Pincode" name="pincode" required>
        </div>
        <div class="twoElements">
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="State" name="state" required>
          <input style="width:100%;outline: none;border: none;height: 30px;border-radius: 5px;padding: 5px; margin-bottom:10px;font-family:k2d" type="text" placeholder="Country" name="country" required>
        </div>
        <div style="display:flex;align-items:center;height:fit-content; gap:5px;margin-bottom:10px">
          <input type="checkbox" required /><span style="font-family:'k2d'; color:#fff;font-size:.8rem;">I Agree To Register Myself Here</span>
        </div>
        <button type='submit' class="btn" style="width:100%;height:40px;margin-top:10px">Sign Up</button>
      </div>
    </form>
  </div>

</body>

</html>