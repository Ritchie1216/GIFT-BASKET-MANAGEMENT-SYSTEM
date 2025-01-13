<?php 

include_once('db.php');

$sql = "SELECT * FROM `item` WHERE id ='".$_GET['id']."'";
$qry = mysqli_query($conn,$sql);
 
if (isset($_POST['submit'])) {
	// code...
    $sql = "SELECT * FROM `item` WHERE id ='".$_GET['id']."'";
    $qry = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($qry);
    
	
    $amount = $row['price'] * $_POST['qty'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Y-m-d');


    $sale = "INSERT INTO `order_list`(`item_id`, `amount`, `quantity`, `Date`,`c_id`,`status`) VALUES ('".$_GET['id']."','$amount','".$_POST['qty']."','$date','".$_SESSION['id']."','PENDING')";

        if($check=mysqli_query($conn,$sale)){
            $new = $row['quantity'] - $_POST['qty'];
            $update_item = "UPDATE `item` SET quantity = $new WHERE id = '".$_GET['id']."'";
            $update_stock = mysqli_query($conn,$update_item);
            echo "<script>alert('checkout success');
                    window.location.href='product_list.php';
                    </script>";
        }else{
            echo "<script>alert('checkout fail');
            window.location.href='checkout.php';
            </script>";
        }
}

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}



* {
                margin:;
                padding:;
                border:;
                outline: 0
            }
 
            ul,
            li {
                list-style: none;
            }
 
            a {
                text-decoration: none;
            }
 
            a:hover {
                cursor: pointer;
                text-decoration: none;
            }
 
            a:link {
                text-decoration: none;
            }
 
            img {
                vertical-align: middle;
            }
 
            .btn-numbox {
                overflow: hidden;
                margin-top: 20px;
            }
 
            .btn-numbox li {
                float: left;
            }
 
            .btn-numbox li .number,
            .kucun {
                display: inline-block;
                font-size: 12px;
                color: #808080;
                vertical-align: sub;
            }
 
            .btn-numbox .count {
                overflow: hidden;
                margin: 0 16px 0 -20px;
            }
 
            .btn-numbox .count .num-jian,
            .input-num,
            .num-jia {
                display: inline-block;
                width: 28px;
                height: 28px;
                line-height: 28px;
                text-align: center;
                font-size: 18px;
                color: #999;
                cursor: pointer;
                border: 1px solid #e6e6e6;
            }
            .btn-numbox .count .input-num {
                width: 58px;
                height: 26px;
                color: #333;
                border-left:;
                border-right:;
            }
</style>
</head>
<body class="w3-content" style="max-width:1200px">
<div class="w3-display-container w3-container">
    <form action="checkout.php?id=<?=$_GET['id']?>" method='post'>
         <?php while($row = mysqli_fetch_array($qry)) {?>
            <table>
                <tr>
                <th rowspan="4"><img src="uploads/<?=$row['image']?>" style="width:50%;height: 50%;" ></th>
                    <input type="hidden" id="price" value="<?=$row['price']?>" readonly>
                    <input type="hidden" id="max" value="<?=$row['quantity']?>" readonly>
                    <td><?=$row['item_name']?></td>
                </tr>
                <tr>
                    <td><ul class="btn-numbox">
            		<li><span class="number">Stock Available</span></li>
            		<li>
                		<ul class="count">
                    		<li><span id="num-sub" class="num-jian">-</span></li>
                    		<li><input type="text" name="qty" class="input-num" id="input-num" value="1" readonly/></li>
                    		<li><span id="num-add" class="num-jia">+</span></li>
                		</ul>
            		</li>
            		<li><span class="kucun"><?=$row['quantity']?> piece available</span></li>
　　　  			</ul></td>
                    <tr>
                        <td><span id="demo"></span></p>
                            <span>RM <?=$row['price']?> per unit</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            $qty = $row['quantity'];
                            if ($qty == 0) {
                                echo "<button type='button' disabled>Out of Stock</button>";
                              } else {
                                echo ' <input type="submit" name="submit" value="Buy Now">';
                              }
                              
                            
                            ?>
                            
                        </td>
                    </tr>
                    
                </tr>
            </table>

        <?php }?>
    </form>
    
</div>
</body>
</html>
<script>
	　  var num_add = document.getElementById("num-add");
        var num_sub = document.getElementById("num-sub");
        var input_num = document.getElementById("input-num");
        var max = document.getElementById("max").value;
        var qty = parseInt(max);


        var x = document.getElementById('price').value;
        var y = document.getElementById('input-num').value;
        document.getElementById('demo').innerHTML ="Total Amount RM " + x * y;

 
        num_add.onclick = function() {
        	if(input_num.value >= qty) {
               input_num.value = qty;
            }else{
            	input_num.value = parseInt(input_num.value) + 1;
            	var x = document.getElementById('price').value;
        		var y = document.getElementById('input-num').value;
        		document.getElementById('demo').innerHTML ="Total Amount RM " + x * y;

            }
            
        }

        num_sub.onclick = function() {
 
            if(input_num.value <= 1) {
                input_num.value = 1;
            } else {
                input_num.value = parseInt(input_num.value) - 1;
                var x = document.getElementById('price').value;
        		var y = document.getElementById('input-num').value;
        		document.getElementById('demo').innerHTML ="Total Amount RM " + x * y;
					
            }
 
        }

if (true) {
    
}
        

</script>
