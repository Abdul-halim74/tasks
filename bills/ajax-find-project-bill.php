<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
extract($_REQUEST);

//get  total  bill amount  from  bill  table
$project_id = $_POST['id'];
$sql = "SELECT  `receivable_amount`   FROM `bills` WHERE `id`='$project_id'";
$result = mysqli_query($connection, $sql);
$total = mysqli_fetch_assoc($result);
$total_bill_amount = $total['receivable_amount'];

//find  total bill collected amount

$sql_collect = "SELECT  sum(`amount`) as total_collect_bills   FROM `collect_bills` WHERE `project_id`='$project_id'";
$result_collect = mysqli_query($connection, $sql_collect);
$total_collected = mysqli_fetch_assoc($result_collect);
$total_collected_bill_amount = $total_collected['total_collect_bills'];
if ($total_collected_bill_amount == '') {
    $total_collected_bill_amount = 0;
}

$return = array("total_bill_amount" => $total_bill_amount, "total_collected_bill_amount" => $total_collected_bill_amount);
echo json_encode($return);

?>
