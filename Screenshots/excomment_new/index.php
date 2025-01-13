<?php 



include_once('db.php');

$qry = "SELECT * FROM `item` ORDER BY `id` DESC";
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
    padding:4px;
}
    
</style>
</head>
<body>
  <div>
  <button type="button" onclick="window.location.href='login.php'">Login</button>
  <button type="button" onclick="window.location.href='register.php'">Sign Up</button>
  <button type="button" onclick="window.location.href='seller_register.php'">Seller Center</button>

  
  
    <script type="text/javascript">
            function function1() {
        document.all.myButton.disabled = true;
    }
    </script>
    <form method="post">


	 <table>
        <thead>
            <th>Picture</th>
            <th>Product</th>
            <th style='color:green;'>Price</th>
            <th>Stock Quantity</th>
            <th>Action</th>
        </thead>
        <tbody id="item_table">
        
        <?php while($row = mysqli_fetch_array($sql)){?>
          
            <tr>
                <td><img style="width: 20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['price']?></td>
                <td><?=$row['quantity']?></td>
                <td>
                    <button type="button" style=' color:white; background-color:black;' onclick="window.location.href='login.php'">Buy</button>
                </td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>
    </form>
  </div>

</body>
</html>