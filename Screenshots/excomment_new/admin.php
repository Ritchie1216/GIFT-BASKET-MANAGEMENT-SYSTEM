<?php
include_once('db.php');
// $pass = password_hash('123',PASSWORD_DEFAULT);
// $sql = "INSERT INTO admin (admin,password) VALUE('admin','$pass')";
// mysqli_query($conn,$sql);
if (isset($_POST['login'])) {
  // Get the email and password from the form
  $log_name = $_POST['user_log'];
  $password = $_POST['pswd_log'];

  // Check if the email and password are not empty
  if (!empty($log_name) && !empty($password)) {
    // Query the database to get the hashed password for the given email
    $query = "SELECT * FROM `admin` WHERE `admin` = '$log_name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // Check if the password is correct
    if (password_verify($password, $row['password'])) {
      $_SESSION['admin'] = $log_name;
      $_SESSION['password'] = $pass;
      $_SESSION['id'] = $row[0];
	  echo '<script>
	  alert("Welcome, '.$_SESSION['admin'].'");
	  window.location.href="dashboard.php";
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
  <h2>Admin Panel</h2>
  <form action='admin.php' method='post' name='login_form'>
    <div class="mb-3 mt-3">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" placeholder="Enter Username" name="user_log">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd_log">
    </div>
    <input type="submit" class="btn btn-primary" name='login' value='Login'>
  </form>
</div>
  
</body>
</html>