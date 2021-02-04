<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];


?>

<?php
if (isset($_REQUEST['submit'])) {

	 $month_or_date = $_REQUEST['month_or_date'];
	$holiday_office = $_REQUEST['holiday_office'];
	$hourse = $_REQUEST['hourse'];

	 $update_sql = "UPDATE kpi_parameter set marks_generate = '$month_or_date' , holiday_office = '$holiday_office', overtime='$hourse' where id= '1' ";

	$update_q = mysqli_query($connection, $update_sql);
	if ($update_q==1) {

            $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Updated Successfully.
        </div>
        ';

           echo "<script>window.location.href='parameter.php';</script>";
        exit();
  }
	
}


?>