
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  
<div class="container">
    <?php
    include_once('db.php');
    $sql = "SELECT suspend.id,suspend.reason,suspend.seller_id,suspend.ban_expire_time,seller.id as s_id,seller.status,seller.ban_count  FROM `suspend` INNER JOIN `seller` ON `suspend`.`seller_id` = `seller`.`id` WHERE `seller_id` = '{$_SESSION['id']}' ORDER BY `id` DESC";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);

        if($row['ban_expire_time'] < time() && $row['status']=='BAN'){
            $update = "UPDATE `seller` SET `status` = 'ACTIVE' WHERE `id` = '{$_SESSION['id']}' "; 
            $qry1 = mysqli_query($conn,$update);
        }
    ?>
  <h1>Your has been suspend!</h1>
  <p><?php echo $row['reason'];?></p>
  <?php
  
  if($row['ban_count'] == 1){
    echo '<p>Your account will be suspend 3 days.</p>';
    echo 'Your will reactive on ' . date("Y-m-d", $row['ban_expire_time']);
    echo '<p>Please contact admin if your have any question.</p>';
  }else if($row['ban_count'] == 2){
    echo '<p>Your account will be suspend 1 week.</p>';
    echo 'Your will reactive on ' . date("Y-m-d", $row['ban_expire_time']);
    echo '<p>Please contact admin if your have any question.</p>';
  }else if($row['status'] =='BAN_PERMANENT'){
    echo '<p>Your Account has been BAN. Contact admin if have any question.</p>';
  }
  
  ?>
 
  <button class="btn btn-primary"  onclick="window.location.href='log_out.php'" type="button">Back</button>
</div>

</body>
</html>