<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';

 $userid =$_SESSION['user_id'];

$month_and_year = $_GET['month_and_year'];

 $montOfTheYear = date('m', strtotime($month_and_year));
 $year = date('Y', strtotime($month_and_year));
 $dept = $_GET['dept'];


 if ($dept =='programmer') {
 	$select_sql="SELECT * FROM `offce_open_off` where programmer='1' and MONTH(date)='$montOfTheYear' and YEAR(date)='$year' ";
 	$select_q = mysqli_query($connection, $select_sql);

 	 $total_days_office = mysqli_num_rows($select_q);
 
 }elseif ($dept !='programmer') {
 	$select_sql="SELECT * FROM `offce_open_off` where marketting='1' and MONTH(date)='$montOfTheYear' and YEAR(date)='$year' ";
 	$select_q = mysqli_query($connection, $select_sql);

 	$total_days_office = mysqli_num_rows($select_q);
 }


?>


<?php
		   	if (isset($_POST['submit'])) {

		   		 if ($dept =='programmer') {
		   		 	
    					  $attendance_info_sql = "SELECT  count(att.status) as total_present, 
    					  usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where MONTH(att.date) = '$montOfTheYear' and YEAR(att.date)='$year' and att.`status` in (0,1,3) and usr.department_id like '%2%' GROUP BY att.emp_id";

    				}elseif ($dept !='programmer') {

    					 $attendance_info_sql = "SELECT  count(att.status) as total_present, 
    					 usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where MONTH(att.date) = '$montOfTheYear' and YEAR(att.date)='$year'  and att.`status` in (0,1,3) and usr.department_id NOT LIKE '%2%' GROUP BY att.emp_id";

    				}

    				 $select_if_exist ="SELECT * FROM `attendance_marks` where 
			            `year_and_month`= '$month_and_year' and `deptartment`='$dept' ";

			            $select_q = mysqli_query($connection, $select_if_exist);

			            if (mysqli_num_rows($select_q) > 0) {

			            	 $_SESSION['result'] ='
						        <div class="alert alert-danger fade in alert-dismissible" >
						        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
						        <strong>Data Already Exist !</strong> 
						        </div>
						        ';

						            echo "<script>window.location.href='attendance_mark.php';</script>";
						        	exit();
			            }
			            
    				$attendance_info_q = mysqli_query($connection, $attendance_info_sql);

    				while ($attendance_info_f = mysqli_fetch_array($attendance_info_q)) {
    					$emp_id = $attendance_info_f['emp_id'];
    					$emp_name = $attendance_info_f['name'];
    					$total_present = $attendance_info_f['total_present'];
    					$total_absent = $total_days_office - $attendance_info_f['total_present'];

    					$cal = (8 * $attendance_info_f['total_present']) / $total_days_office;

			            $marks = round($cal);

			           

    					 $insert_sql = "INSERT INTO `attendance_marks` SET `emp_id` = '$emp_id', `emp_name` = '$emp_name', `deptartment` = '$dept', `year_and_month` ='$month_and_year', 
    					`total_office_opened` = '$total_days_office', `present` = '$total_present', 
    					`absent`='$total_absent', `marks` = '$marks' , `entry_user`= '$userid'  ";

    					$insert_q= mysqli_query($connection, $insert_sql);


    					

    				}

    				if($insert_q==1){

    				  $_SESSION['result'] ='
		        <div class="alert alert-success fade in alert-dismissible" >
		        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
		        <strong>attendance Marks  Inserted Successfully.</strong> 
		        </div>
		        ';

		            echo "<script>window.location.href='attendance_mark.php';</script>";
		        	exit();
		    		
		    	}		

		   	}

		   ?>
