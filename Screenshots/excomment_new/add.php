<?php 

include_once('db.php');

if (isset($_POST['add'])) {
	// code...
	 $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $name = $_POST['name'];
    $price= $_POST['price'];
    $qty= $_POST['quantity'];
    $category = $_POST['category'];

    if (!in_array($extension, ['jpg','jpeg','png'])) {
        echo "You file extension must be .jpg, .jpeg or .png";
    } elseif ($_FILES['myfile']['size'] > 10000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO item (image,item_name,price,quantity,seller_id,category_id) VALUES ('$filename','$name','$price','$qty','".$_SESSION['id']."','$category')";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

$replace_stock = "SELECT * FROM `item`";
$sql = mysqli_query($conn, $replace_stock);

if (isset($_POST['restock'])) {
	$id = $_POST['item_id'];
  echo  $sql = "SELECT * FROM `item` WHERE id = '$id'";
    $qry = mysqli_query($conn,$sql);
    $num = mysqli_fetch_array($qry);
    // code...
      echo "<br>";
   echo $test1= $num['quantity'];
   echo "<br>";
   echo $test2= $_POST['number'];
   echo "<br>";

    $num1 = $num['quantity'] + $_POST['number'];
    echo "<br>";

    
   echo  $add = "UPDATE `item` SET `quantity` = $num1 WHERE id ='$id'";

    if($qry1  = mysqli_query($conn,$add)){
    //echo "<script>alert('Successfully Edit');
    //window.location.href='add.php';</script>";
  }
  else{

    echo "<script>window.location.href = 'add.php';alert('Invaild Insert');</script>";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Stock/Replace Stocl</title>
</head>
<body>
	<h1>Add New Product</h1>
<form action="add.php" method='post' enctype="multipart/form-data">
	<div>
		<label>Image</label><br>
		<input type="file" name="myfile">
	</div>
    	<div>
		<label>Product Name</label><br>
		<input type="text" name="name">
	</div>
	<div>
		<label>Price</label><br>
		<input type="text" name="price">
	</div>
	<div>
		<label>quantity</label><br>
		<input type="number" name="quantity">
 	</div>
   <div>
		<label>Category</label><br>
    <select name="category">
      <?php 
    $categ = 'SELECT * FROM `category`';
    $sql1 = mysqli_query($conn,$categ);
    while ($row = mysqli_fetch_array($sql1,MYSQLI_ASSOC)):; 
    ?>
    <option value="<?php echo $row['id'] ;
                    // The value we usually set is the primary key
    
                ?>">
                    <?php echo $row["category"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
  </select>
 	</div>
	<div><br>
		<input type="submit" name="add" value="Sumbit">
	</div>
	
</form>

<h1>Restock</h1>

<form action="add.php" method='post' enctype="multipart/form-data">

	<select name="item_id">
		<?php 
    
    while($row = mysqli_fetch_array($sql)) {?>
		<option value="<?=$row['id']?>"><?=$row['item_name']?></option>
	<?php } ?>
	</select>
	<div>
		<label>quantity</label><br>
		<input type="number" name="number">
 	</div>
 	<div><br>
		<input type="submit" name="restock" value="Sumbit">
	</div>
</form>
</body>
</html>