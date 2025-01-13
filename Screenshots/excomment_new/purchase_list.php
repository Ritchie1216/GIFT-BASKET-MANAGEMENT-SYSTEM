<?php 

include_once('db.php');

$qry = "SELECT  order_list.*,order_list.id,item.image,item.item_name FROM `order_list`INNER JOIN item ON order_list.item_id = item.id WHERE (order_list.status = 'PENDING' OR order_list.status = 'TO SHIP' OR order_list.status = 'RECEIVE') AND c_id = '".$_SESSION['id']."'  ORDER BY `order_list`.`id` DESC";
//Connect database
$sql = mysqli_query($conn, $qry);

$pending_rows = array();
$paid_rows = array();
$receive_rows = array();
$string = implode(',', $paid_rows);
while ($row = mysqli_fetch_array($sql)) {
    if ($row['status'] == 'PENDING') {
        $pending_rows[] = $row;
    } else if ($row['status'] == 'TO SHIP') {
        $paid_rows[] = $row;
    }else if ($row['status'] == 'RECEIVE') {
        $receive_rows[] = $row;
    }
}

if(isset($_GET['id']) && isset($_GET['action'])&& $_GET['action'] == 'receive'){
    $id = $_GET['id'];
    echo $update = "UPDATE `order_list` SET `status` = 'RECEIVE' WHERE `id` = $id";
    if($result = mysqli_query($conn,$update)){
        echo "<script>window.location.href='purchase_list.php';alert('Thank for you purchase');</script>";
    }else{
        echo "<script>alert('Oh! Something Wrong');</script>";
    }
}

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
    
</style>
</head>
<body>
  <div>
  <button type="button" onclick="window.location.href='product_list.php'">Back</button>
  <button type="button" onclick="window.location.href='log_out.php'">Log Out</button>

  
  
    <script type="text/javascript">
            function function1() {
        document.all.myButton.disabled = true;
    }
    </script>
    <form method="post">

    <h1>Pending</h1>
	 <table>
        <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Order Total Amount</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Status</th>
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($pending_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['status']?></td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>

    <h1>TO SHIP</h1>
	 <table>
        <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Order Total Amount</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Status</th>
            <th></th>
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($paid_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['status']?></td>
                <td>
                    <button type="button" onclick="window.location.href='purchase_list.php?id=<?=$row['item_id']?>&action=receive'">Receive</button>
                </td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>

    <h1>RECEIVE</h1>
	 <table>
        <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Order Total Amount</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Status</th>
            <th></th>
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($receive_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['status']?></td>
                <td>
                    <button type="button" onclick="window.location.href='checkout.php?id=<?=$row['item_id']?>'">Buy Again</button>
                </td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>
    </form>
  </div>

</body>
</html>