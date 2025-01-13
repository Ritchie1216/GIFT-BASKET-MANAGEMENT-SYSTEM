<?php 
include_once('db.php');

if (isset($_FILES["ic"]) && isset($_FILES["ic_back"]) && isset($_FILES["ssm"])) {
  // Process the first file
  $tmpFilePath1 = $_FILES["ic"]["tmp_name"];
  $newFilePath1 = "documents/" . $_FILES["ic"]["name"];
  // Process the second file
  $tmpFilePath2 = $_FILES["ic_back"]["tmp_name"];
  $newFilePath2 = "documents/" . $_FILES["ic_back"]["name"];

  $tmpFilePath3 = $_FILES["ssm"]["tmp_name"];
  $newFilePath3 = "documents/" . $_FILES["ssm"]["name"];
  $seller_id = $_SESSION['id'];
  if (move_uploaded_file($tmpFilePath2, $newFilePath2) && move_uploaded_file($tmpFilePath1, $newFilePath1) && move_uploaded_file($tmpFilePath3, $newFilePath3)) {
      // Insert into database
      $query = "INSERT INTO document (`id_card_front`, `id_card_back`, `SSM`,`seller_id`) VALUES ('$newFilePath1', '$newFilePath2','$newFilePath3', '$seller_id')";
      if (mysqli_query($conn, $query)) {
        $id = $_SESSION['id'];
        $update_status = "UPDATE seller SET status = 'PENDING' WHERE id = $id";
        $result = mysqli_query($conn,$update_status);
        echo '<script>
        window.location.href="pending.php";
      </script>';
   }
} else {
   echo "Failed to upload file.";
}
  }
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
<h1 style='text-align:center;'>Active Your Account Now</h1>
<form action="unactive.php" method='post' enctype="multipart/form-data">
  <div class="mb-3 mt-3">
    <label for="ic" class="form-label">Identity Card Front</label>
    <input type="file" class="form-control" id="ic" name="ic" onchange="showIC(event);"><br>
    <div class="preview">
   <img id="myKad-Preview">
 </div>
 <div class="mb-3 mt-3">
    <label for="ic" class="form-label">Identity Card Back</label>
    <input type="file" class="form-control" id="ic_back" name="ic_back" onchange="showIC_Back(event);"><br>
    <div class="preview">
   <img id="myKad-back-Preview">
 </div>
  </div>
  <div class="mb-3">
    <label for="ssm" class="form-label">SSM</label>
    <input type="file" class="form-control" id="SSM" name="ssm" onchange="showSSM(event);"><br>
    <div class="preview">
   <img id="ssm-preview">
 </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> 

<p style='color:red;'>Please giving us 1 - 3 working days to verifation your account</p>
</div>
</body>
</html>
<script>
function showIC(event){
  if(event.target.files.length > 0){
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("myKad-Preview");
    preview.src = src;
    preview.style.display = "block";
  }
}
    
function showIC_Back(event){
  if(event.target.files.length > 0){
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("myKad-back-Preview");
    preview.src = src;
    preview.style.display = "block";
  }
}


function showSSM(event){
  if(event.target.files.length > 0){
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("ssm-preview");
    preview.src = src;
    preview.style.display = "block";
  }
}



</script>



