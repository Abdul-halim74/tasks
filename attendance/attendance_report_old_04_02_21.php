<?php error_reporting(0);

session_start();

include_once '../inc/connection.php';

include_once '../inc/head.php';

$userid =$_SESSION['user_id'];



$time=date('H:i:s');

 

$date = date("Y-m-d");



//FIND  IP ADDRESSS





?>



<body>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<div id="app" class="app">

    <?php include_once  '../inc/sidebar.php'; ?>

</div>

<div class="content-area">



    <div class="container-fluid" style="margin-bottom: 20px;">

  		 <div class="container-fluid">

            <?php

            echo $_SESSION['result'];

            $_SESSION['result'] = null;

            ?>

              <div class="row">

	            <div class="col-md-6">

	            	<div class="panel panel-success">

	                 <div class="panel-heading">Attendance Report</div>

	                <div class="panel-body"> 

	                    <form method="GET" action="" accept-charset="UTF-8" class="create_form_area"

	                          enctype="multipart/form-data">

	                            <div class="col-md-12">

	                            	<div class="form-group row">

	                                    <label class="col-md-12 col-form-label">Start Date <span class="red">*</span></label>

	                                    <div class="col-md-12">

	                                    	 <?php 

	                                        	$start_date = $_GET['start_date'];

	                                        	$end_date = $_GET['end_date'];



												 $final_start_date=date("Y-m-d", strtotime($start_date));

												 $final_end_date=date("Y-m-d", strtotime($end_date));

											 ?>

	                                        <input type="text" class="form-control simple-datepicker"

	                                       

	                                               value="<?php if(isset($_REQUEST['start_date'])){

	                                               	echo $start_date;} else{ echo date('d-m-Y'); } ?>" name="start_date" required="">

	                                        <small> Day-Month-Year</small>

	                                    </div>

	                                </div><!--END-->



	                                <div class="form-group row">

	                                    <label class="col-md-12 col-form-label">End Date <span class="red">*</span></label>

	                                    <div class="col-md-12">

	                                        <input type="text" class="form-control simple-datepicker"

	                                               value="<?php if(isset($_REQUEST['end_date'])){

	                                               	echo $end_date;} else{ echo date('d-m-Y'); }?>" name="end_date" required="">

	                                        <small> Day-Month-Year</small>

	                                    </div>

	                                </div><!--END-->

	                                 

	                                 <div class="form-group row">



			                            <div class="col-md-12">

			                                <button type="submit" class="btn  btn-info" name="submit">

			                                    &nbsp;&nbsp;&nbsp;<i class="fa fa-floppy-o" aria-hidden="true"></i> submit&nbsp;&nbsp;&nbsp;

			                                </button>

			                            </div>

			                        </div>

	                        	</div>



	                    </form>





	                </div>

	            </div>

	        </div>

	        <?php

	        	

	        	if (isset($_REQUEST['submit'])) { 

	        	   $report_sql="SELECT * FROM `attendance` INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id` INNER JOIN `employees` ON  `users`.`id`= `employees`.`user_id` WHERE `date` BETWEEN '$final_start_date' and '$final_end_date' ";

                    $report_query=mysqli_query($connection,$report_sql);

	         ?>

	         <div class="col-md-12">

            	<div class="panel panel-default"> 

                    <div class="panel-heading">Attendance Report List   <button name="create_excel" id="create_excel" class="btn btn-sm btn-success  pull-right create_excel">Download Excel File</button> </div>

                <div class="panel-body" id="employee_table"> 

                	<table class="table table-striped table-bordered table2excel dataTables_wrapper" id="empTable">

					  <thead>

					    <tr>

					      <th>Date</th>

					      <th>Employee Name</th>

					      <th>Company</th>

					      <th>Department</th>

					      <th>Designation</th>  

					      <th>In Time</th>

					      <th>Out Time</th>

					      <th>Status</th>

					      <th>Incoming Reason</th>

					      <th>Outgoing Reason</th>

					    </tr>

					  </thead>

					  <tbody>

					  	<?php 

					  	while ($report_fetch=mysqli_fetch_array($report_query)) {

					  		?>

					    <tr>

					      <td><?php echo $report_fetch['date']; ?></td>

					      <td><?php echo $report_fetch['name']; ?></td>

					      <?php  $company_id =$report_fetch['company'];

					      	$select_company="SELECT * FROM `companies` WHERE id='$company_id' ";

					      	$company_query=mysqli_query($connection,$select_company);

					      	$company_fetch=mysqli_fetch_array($company_query);



					       ?>

					      <td><?php  echo $company_fetch['company_name'];?></td>

					      <?php

					        $department_id=$report_fetch['department_id'];

					      	$select_department="SELECT * FROM `departments` WHERE id='$department_id' ";

					      	$department_query=mysqli_query($connection,$select_department);

					      	$department_fetch=mysqli_fetch_array($department_query);

					      ?>

					      <td><?php  echo $department_fetch['department_name'];  ?></td>



					      <?php

					        $designation_id=$report_fetch['designation_id'];

					      	$select_designation="SELECT * FROM `designations` WHERE id='$designation_id' ";

					      	$designation_query=mysqli_query($connection,$select_designation);

					      	$designation_fetch=mysqli_fetch_array($designation_query);

					      ?>

					      <td><?php  echo $designation_fetch['designation_name'];  ?></td>

					     

					      <td class="text-center"><?php  echo date("h:i a",strtotime($report_fetch['in_time'])); ?></td>



					     	<td class="text-center">

                                        <?php   

                                        $out=$report_fetch['out_time']; 

                                        if($out){ 

                                            echo date("h:i a",strtotime($out));  

                                            ?> 

                                        <?php }else{ ?>

                                        <!--<button  data-toggle="modal" data-target="#out_attendance" class="btn btn-success btn-sm">OUT</button>-->

                                          <?php }  ?>

                                        </td>

					      <td><?php if($report_fetch['status']==0){echo "Late Present";} elseif($report_fetch['status']==1){echo "Present";}elseif($report_fetch['status']==2){echo "Cancel";}?></td>

					      <td style="font-size: 13px !important"><?php  echo '<font size="13px">'.$report_fetch['incoming_reason'].'</font>'; ?></td>

					      <td style="font-size: 13px !important"><?php  echo '<font size="13px">'.$report_fetch['outgoing_reason'].'</font>'; ?></td> 

					    </tr>

					    

					    <?php

							}

					    ?>

					  </tbody>

					</table>



                </div>

            </div>



        </div>

		 	 

          </div>

        </div>

       

        <?php 			

	        	}



	        ?>

	</div>

	<script>

		

	 $(document).ready(function() {

	    $('#create_excel').on('click', function(e){

	        $("#empTable").table2excel({

	             filename: "Attendance_report<?php echo 'From '.$final_start_date.'To '.$final_end_date; ?>.xls"

	        });

	    });

	});

    $('#empTable').DataTable({

       "searching": false

    });

</script>



<?php

include_once '../inc/footer.php';

?>
<style type="text/css">
	table tr td p,table tr td p span
	{
		font-size: 13px !important;
	}
</style>
</body>

</html>