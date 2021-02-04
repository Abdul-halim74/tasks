<?php
$message = '';
if(!empty($_FILES['uploaded_file'])) {
  $path = '/images/';
  $path = $path . uniqid('u', true) . '-' . basename($_FILES['uploaded_file']['name']);

  if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
    $message = 'The file ' . basename( $_FILES['uploaded_file']['name']) . ' has been uploaded';
  } else {
    $message = 'There was an error uploading the file, please try again!';
    $message .= $_FILES['uploaded_file']['error'];
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
</head>
<body>
  <?php echo $message; ?>
  <form enctype="multipart/form-data" action="" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
