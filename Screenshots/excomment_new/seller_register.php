<?php
include_once('db.php');

if (isset($_POST['signup'])) {
    // Get the email, name, and password from the form
    $name = $_POST['user_signup'];
    $psw = $_POST['pswd_signup'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
  
    // Hash the password
    $hashed_password = password_hash($psw, PASSWORD_DEFAULT);
  
    // Insert the user's information into the database
    $signup = "INSERT INTO `seller` (`shop_name`,`password`,`first_name`,`last_name`,`email`,`contact_number`,`status`,`ban_count`) VALUES ('$name', '$hashed_password','$first_name','$last_name','$email','$phone_num','UNACTIVE',0)";
    if(mysqli_query($conn, $signup)){
        echo '<script>
             alert("Welcome, '.$name.'");
                window.location.href="seller_login.php";
            </script>';
    }else{
      echo '<script type="text/javascript">';
      echo 'alert("Fail Register.")';
      echo 'window.location.href = "seller_register.php"';
      echo '</script>';
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
  <h2>Register</h2>
  <form action='seller_register.php' method='post' name='login_form'>
    <div class="mb-3 mt-3">
      <label for="username">Shop Name</label>
      <input type="text" class="form-control" id="username" placeholder="Enter Shop Name" name="user_signup">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" placeholder="Enter password" name="pswd_signup">
    </div>
    <div class="mb-3 mt-3">
      <label for="first_name">First Name</label>
      <input type="text" class="form-control" id="f_name" placeholder="Enter First Name" name="first_name">
    </div>
    <div class="mb-3 mt-3">
      <label for="last_name">Last Name</label>
      <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="last_name">
    </div>
    <div class="mb-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" placeholder="Enter Email" name="email">
    </div>
    <div class="mb-3">
      <label for="phone_num">Contact Number:</label>
      <input type="tel"  pattern="^(\+?6?01)[0-46-9]-*[0-9]{7,8}$" class="form-control" placeholder="Enter Contact Number" name="phone_num">
    </div>
   
    <input type="submit" class="btn btn-primary" name='signup' value='SignUp'>
    <input type="submit" class="btn btn-primary" value='Login' onclick="location.href='seller_login.php';return false;">
  </form>
</div>
  
</body>
</html>