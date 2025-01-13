<?php
 include_once('db.php');
 $doc = "SELECT * FROM `document` WHERE `seller_id` = '".$_GET['id']."'";
 $result = mysqli_query($conn,$doc);
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>



<div class="container mt-3">
  <h2>Seller Document</h2>            
  <table class="table">
    <thead>
      <tr>
        <th>myKad</th>
        <th>MyKad Back</th>
        <th>SSM Document</th>
      </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($result)) {?>
      <tr>
        <td>
            <img onclick="zoomIn(this)" style="width:20%; height:20%;" src="<?=$row['id_card_front']?>" >
        </td>
        <td><img onclick="zoomIn(this)" style="width:20%; height:20%;" src="<?=$row['id_card_back']?>" ></td>
        <td><img onclick="zoomIn(this)" style="width:20%; height:20%;" src="<?=$row['SSM']?>"></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <button type="button" onclick="window.location.href='dashboard.php'">Back</button>
</div>
<script>
     function zoomIn(img) {
    img.classList.add("zoom");
    img.style.width = "100%";
    img.style.height = "100%";
  }
</script>