<?php
include_once('db.php'); 

if(isset($_POST['submit'])){
    $reason = $_POST['text'];
    $id = $_GET['id'];
    $sql = "SELECT ban_count FROM `seller` WHERE `id`='".$_GET['id']."'";
    $query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($query);
    if($result['ban_count'] >= 3){
        $update_status = "UPDATE `seller` SET `status`='BAN_PERMANENT' WHERE `id` = '$id'";
        $ban = mysqli_query($update_status);
    }else{
        if($result['ban_count'] == 0){
            $bantime = 3*24*60*60;
        }elseif($result['ban_count']==1){
            $bantime = 7*24*60*60;
        }else{
            $bantime = 0;
        }
        $ban_expire_time = time() + $bantime;
        $suspend = "INSERT INTO `suspend`(`reason`,`seller_id`,`ban_expire_time`) VALUES('$reason','$id','$ban_expire_time')";
        if($result = mysqli_query($conn,$suspend)){
            // Update the user status and ban_count
            $update_status = "UPDATE `seller` SET `status`='BAN',`ban_count` = `ban_count`+1 WHERE `id` = '$id'";
            mysqli_query($conn,$update_status);
            echo '<script>
            window.location.href="dashboard.php";
          </script>';
        }
    }
   

   
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suspend Reason</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Suspend Reason</h2>
  <form action="suspend.php?id=<?=$_GET['id']?>" method='post'>
    <div class="mb-3 mt-3">
      <label for="comment">Comments:</label>
      <textarea class="form-control" rows="5" id="comment" name="text"></textarea>
    </div>
    <input type="submit" name='submit' value="Submit">
  </form>
</div>

</body>
</html>
