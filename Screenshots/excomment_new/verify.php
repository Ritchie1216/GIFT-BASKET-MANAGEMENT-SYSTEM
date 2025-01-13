<?php 
include_once('db.php');
$verify = "SELECT * FROM `seller` WHERE id = '".$_SESSION['id']."'";
$qry = mysqli_query($conn,$verify);
$row = mysqli_fetch_array($qry);
$user_status = $row['status'];


if($user_status =='ACTIVE'){
    header('Location: seller_index.php');
}else if($user_status =='UNACTIVE'){
    header("Location: unactive.php");
    exit();
}else if($user_status == 'PENDING'){
    header("Location: pending.php");
    exit();
}else if($user_status == 'BAN'){
    header("Location: ban.php");
    exit();
}else if($user_status == 'BAN_PERMANENT'){
    header("Location: ban.php");
    exit();
}


?>
