<?php 

include_once('db.php');
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$qry = "SELECT * FROM `item` INNER JOIN `seller` ON `item`.`seller_id` = `seller`.`id`  WHERE `status` = 'ACTIVE'";
//Connect database
$sql = mysqli_query($conn, $qry);

 ?>

 <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
th, td{
    border: 2px solid black;
    padding:8px;
}

.button{
    background-color:black;
    color:white;
}
    
</style>
</head>
<body>
  <?php
  echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
  ?>
  <div>
  <button class='button' type="button" onclick="window.location.href='purchase_list.php?id=<?=$_SESSION['id']?>'">My Purchase</button>
  <button class='b'  type="button" onclick="window.location.href='log_out.php'">Log Out</button>

  
  
    <script type="text/javascript">
            function function1() {
        document.all.myButton.disabled = true;
    }
    </script>
    <form method="post">


	 <table>
        <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </thead>
        <tbody id="item_table">
        
        <?php while($row = mysqli_fetch_array($sql)){?>
          
            <tr>
                <td><img style="width: 50%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['price']?></td>
                <td><?=$row['quantity']?></td>
                <td>
                    <button class='button' type="button" onclick="window.location.href='checkout.php?id=<?=$row['id']?>'">Buy</button>
                </td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>
    </form>
  </div>

</body>
</html>