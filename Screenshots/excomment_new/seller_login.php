<?php
include_once('db.php');

if (isset($_POST['login'])) {
  // Get the email and password from the form
  $log_name = $_POST['user_log'];
  $password = $_POST['pswd_log'];

  // Check if the email and password are not empty
  if (!empty($log_name) && !empty($password)) {
    // Query the database to get the hashed password for the given email
    $query = "SELECT * FROM seller WHERE shop_name = '$log_name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // Check if the password is correct
    if (password_verify($password, $row['password'])) {
      $_SESSION['seller_name'] = $log_name;
      $_SESSION['password'] = $pass;
      $_SESSION['id'] = $row['id'];
    echo '<script>
        alert("Welcome, '.$_SESSION['seller_name'].'");
        window.location.href="verify.php";
      </script>';
      
    } else {
      // The password is incorrect, show an error message
      echo '<p>Incorrect email or password.</p>';
    }
  } else {
    // The email or password is empty, show an error message
    echo '<p>Please enter your email and password.</p>';
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <title></title>
</head>
<body>
<div class="container mt-3">
  <h2>Seller Login</h2>
  <form action='seller_login.php' method='post' name='login_form'>
    <div class="mb-3 mt-3">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" placeholder="Enter Username" name="user_log">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd_log">
    </div>
    <input type="submit" class="btn btn-primary" name='login' value='Login'>
    <input type="submit" class="btn btn-primary" value='Register' onclick="location.href='seller_register.php';return false;">
  </form>
</div>
  
</body>
</html>