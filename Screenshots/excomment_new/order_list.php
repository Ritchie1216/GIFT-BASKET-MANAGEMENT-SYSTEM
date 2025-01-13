<?php 

include_once('db.php');

$qry = "SELECT order_list.*,order_list.id,item.seller_id,item.image,item.item_name,buyer.first_name,buyer.last_name,buyer.address,buyer.contact_number FROM `order_list`INNER JOIN item ON order_list.item_id = item.id INNER JOIN buyer ON order_list.c_id = buyer.id WHERE (status = 'PENDING' OR status = 'TO SHIP' OR status = 'RECEIVE') AND `seller_id`='".$_SESSION['id']."' ORDER BY order_list.id DESC";
//Connect database
$sql = mysqli_query($conn, $qry);

$pending_rows = array();
$paid_rows = array();
$receive_rows = array();
$string = implode(',', $paid_rows);
echo $string;
while ($row = mysqli_fetch_array($sql)) {
    if ($row['status'] == 'PENDING') {
        $pending_rows[] = $row;
    } else if ($row['status'] == 'TO SHIP') {
        $paid_rows[] = $row;
    }else if ($row['status'] == 'RECEIVE') {
        $receive_rows[] = $row;
    }
}

if(isset($_GET['id']) && isset($_GET['action'])&& $_GET['action'] == 'ship'){
    $id = $_GET['id'];
    echo $update = "UPDATE `order_list` SET `status` = 'TO SHIP' WHERE `id` = $id";
    if($result = mysqli_query($conn,$update)){
        echo "<script>window.location.href='order_list.php';alert('Item has been checkout');</script>";
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
  <button type="button" onclick="window.location.href='seller_index.php'">Back</button>



    <script type="text/javascript">
            function function1() {
        document.all.myButton.disabled = true;
    }
    </script>
    <form method="post">
        <h1>Pending List</h1>
    <table>
        <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Total Order Amount</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($pending_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['first_name']?> <?=$row['last_name']?></td>
                <td><?=$row['address']?></td>
                <td><?=$row['contact_number']?></td>
                <td><?=$row['status']?></td>
                <td>
                    <button type="button" onclick="window.location.href='order_list.php?id=<?=$row['id']?>&action=ship'">Ship</button>
                </td>
            </tr>
            
        <?php }?>
        
        </tbody>
    </table>

    <h1>Shipment Detail</h1>
    <table>
    <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Total Order Amount</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Status</th>
            
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($paid_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['address']?></td>
                <td><?=$row['contact_number']?></td>
                <td><?=$row['status']?></td>
            </tr>
            
        <?php }?>
        
        </tbody>

    </table>

    <h1>Receive Detail</h1>
    <table>
    <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Total Order Amount</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Status</th>
            
        </thead>
        <tbody id="item_table">
        
        <?php foreach ($receive_rows as $row) {?>
          
            <tr>
                <td><img style="width:20%; height:20%;" src="uploads/<?=$row['image']?>" ></td>
                <td><?=$row['item_name']?></td>
                <td>RM <?=$row['amount']?></td>
                <td><?=$row['quantity']?></td>
                <td><?=$row['date']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['address']?></td>
                <td><?=$row['contact_number']?></td>
                <td><?=$row['status']?></td>
            </tr>
            
        <?php }?>
        
        </tbody>

    </table>
    </form>
  </div>

</body>
</html>