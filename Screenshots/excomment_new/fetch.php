<?php

include_once('db.php');
$output = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	echo $query = "
	SELECT * FROM `item` WHERE `item_name` LIKE '%".$search."%' AND `seller_id`='".$_SESSION['id']."'";
}
else
{
	$query = "
	SELECT * FROM `item` WHERE `seller_id`='".$_SESSION['id']."'";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th></th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
                            <th></th>
							<th></th>
						</tr>';
	while($row = mysqli_fetch_array($result))
	{
		$output .= '
			<tr>
				<td><img style="width="200" height="100"" src="uploads/'.$row["image"].'" ></td>
				<td>'.$row["item_name"].'</td>
				<td>'.$row["price"].'</td>
				<td>'.$row["quantity"].'</td>
                <td><a href="edit.php?id='.$row['id'].'"><button type="button" class="btn btn-primary">Edit</button></a></td>
				<td><a href="delete.php?item_id='.$row['id'].'"><button type="button" class="btn btn-primary">Delete</button></a></td>
			</tr>
		';
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}
?>