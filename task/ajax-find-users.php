<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
extract($_REQUEST);
$employee_role=$_SESSION['employee_role'];
//get  total  bill amount  from  bill  table
 $department_id = $_POST['id'];
 sort($department_id);
 $dep_id='';
 $all='';
 foreach ($department_id as $key => $value) {
 	# code...
 	$dep_id=$dep_id."'".$value."',";
 	$all=$all.$value.',';
 }
 $dep_id=rtrim($dep_id,',');
 $all=rtrim($all,',');

$sql = "SELECT * FROM `users` WHERE (`department_id`   in ($dep_id) OR `department_id` LIKE '%$all%') AND `employee_role` >=$employee_role group by id ORDER BY `users`.`name` ASC";
$result = mysqli_query($connection, $sql);
$return_arr = array();
while($row = mysqli_fetch_array($result)){
    array_push($return_arr,$row);
}

// Encoding array in JSON format
$row = mysqli_fetch_array($result);
echo json_encode($return_arr);
// echo json_encode($sql);

?>
