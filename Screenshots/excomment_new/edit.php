<?php

include_once('header.html');
include_once('db.php');

$edit = "SELECT * FROM `item` WHERE `id` = '".$_GET['id']."'";
$result = mysqli_query($conn,$edit);
$row = mysqli_fetch_array($result);

if (isset($_POST['edit'])) {
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

    if (!in_array($extension, ['jpg','jpeg','png'])) {
        echo "You file extension must be .jpg, .jpeg or .png";
    } elseif ($_FILES['myfile']['size'] > 10000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE `item` SET `image` = '$filename',`item_name` = '$name',`price` = '$price',`quantity` = '$qty' WHERE `id` = '".$_GET['id']."'";
            if (mysqli_query($conn, $sql)) {
                echo '<script type="text/javascript">';
                echo 'alert("Update Success.")';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Failed to upload file.")';
            echo '</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<title>Seller Page</title>
</head>

<body>
  <div class='container pt-5'>
  <h1>Update Product</h1>
      <form action="edit.php?id=<?=$_GET['id']?>" method='post' enctype="multipart/form-data">
	      <div>
		      <label>Image</label><br>
		      <input type="file" name="myfile" value="<?=$row['image']?>">
	      </div>
    	  <div>
		      <label>Product Name</label><br>
		      <input type="text" name="name" value="<?=$row['item_name']?>">
	      </div>
	      <div>
		      <label>Price</label><br>
		      <input type="text" name="price" value="<?=$row['price']?>">
	      </div>
	      <div>
		      <label>quantity</label><br>
		      <input type="number" name="quantity" value="<?=$row['quantity']?>">
 	      </div>
	      <div><br>
		      <input type="submit" name="edit" value="Sumbit">
	      </div>
	
      </form>

  </div>
</body>