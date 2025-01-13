<?php

include_once('db.php');



$item_id = $_GET['item_id'];
$item_delete = "DELETE FROM `item` WHERE `id` = '$item_id'";
if($item_result = mysqli_query($conn,$item_delete)){
    echo '<script type="text/javascript">';
    echo 'window.location.href = "admin.php"';
    echo 'alert("This Product has been delete.")';
    echo '</script>';
}else{
    echo '<script type="text/javascript">';
    echo 'alert("Ohh! Some Error")';
    echo '</script>';
}

header("location:admin.php");


?>