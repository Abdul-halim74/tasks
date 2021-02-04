<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
extract($_REQUEST);

//get  total  bill amount  from  bill  table
 $department_id = $_POST['id'];
$sql = "SELECT * FROM `users` WHERE `department_id` LIKE '%$department_id%' ";
$result = mysqli_query($connection, $sql);
$return_arr = array();
while($row = mysqli_fetch_array($result)){
    array_push($return_arr,$row);
}

// Encoding array in JSON format
$row = mysqli_fetch_array($result);
echo json_encode($return_arr);

?>
