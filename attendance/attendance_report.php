<?php error_reporting(0);

session_start();

include_once '../inc/connection.php';

include_once '../inc/head.php';

$userid =$_SESSION['user_id'];



$time=date('H:i:s');

 

$date = date("Y-m-d");



//FIND  IP ADDRESSS





?>

<style type="text/css">
	.dropdown-menu.open {
   margin-top: 100px;
}
</style>

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

	            	<div class="panel panel-default" style="margin-top: 40px;">

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

                                          <label for="" class="col-sm-12 form-control-label">Employee Name </label>

                                          <div class="col-sm-12">

                                            <select class="form-control selectpicker" multiple data-live-search="true" name="select_emp[]">

                                              <?php  

                                                $select_emp = "SELECT * FROM `users` WHERE id not in(1,7,11,12,14,15,16,17,18,24,25,27,29,31,36,43,48,63)";
                                                $select_q = mysqli_query($connection, $select_emp);

                                                // $emp_f = mysqli_fetch_array($select_q);
                                                while ($emp_f = mysqli_fetch_array($select_q)) {
                                                    ?>

                                                     <option  
                                                        value="<?php echo $emp_f['id']; ?>" ><?php echo $emp_f['name']; ?></option>

                                                    <?php


                                                }

                                             ?>

                                             
                                            </select>


                                            

                                          </div>

                                    </div>

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

	        		$select_emp = $_REQUEST['select_emp'];
	        		// echo "<pre>";
	        		// print_r($select_emp);
	        		// die;
	        	 

	         ?>

	         <div class="col-md-12">

            	<div class="panel panel-default"> 

                    <div class="panel-heading">Attendance Report List  <button name="create_excel" id="create_excel" class="btn btn-sm btn-success  pull-right create_excel" onclick="tableToExcel()">Download Excel File</button></div>

                <div class="panel-body" id="employee_table"> 

                	<table class="table table-striped table-bordered " id="studtable">

					  <thead>

					    <tr>

					      <th>Office Open Date</th>
					      <th>Attendance Date</th>
					      <th>Attendance</th>

					      <th>Employee Name</th>


					      <th>In Time</th>

					      <th>Out Time</th>
					      <th>Status</th>

					    
					      <th>Incoming Reason</th>

					      <th>Outgoing Reason</th>

					    </tr>

					  </thead>

					  <tbody>

					  	<?php 

					  	if ($select_emp=='') {
					  		
					  	

					  	  $usr_sql = "SELECT * FROM `users` WHERE id not in(1,7,11,12,14,15,16,17,18,24,25,27,29,31,36,43,48,63)";

                    	$usr_query=mysqli_query($connection,$usr_sql);

					  	while ($usr_fetch=mysqli_fetch_array($usr_query)) {

					  		$id = $usr_fetch['id'];
					  		$name = $usr_fetch['name'];


														  			$report_sql="
									SELECT o.date                                  AS offce_open_off_date,
									       a.date                                  AS attendance_date,
									       IF(a.date IS NULL, 'Absent', 'Present') AS attendance,
									       a.*
									FROM   (SELECT date
									        FROM   offce_open_off ooo) o
									       LEFT JOIN (SELECT u.name AS user_name,
									                         date,
									                         emp_id,
									                         in_time,
									                         out_time,
									                         status,
									                         incoming_reason,
									                         outgoing_reason
									                  FROM   attendance a
									                         LEFT JOIN users u
									                                ON a.emp_id = u.id
									                  WHERE  date BETWEEN '$final_start_date' AND 
									                  '$final_end_date'
									                         AND emp_id = '$id') a
									              ON o.date = a.date
									WHERE  o.date BETWEEN '$final_start_date' AND '$final_end_date' 
									";

									$report_q = mysqli_query($connection, $report_sql);


									while($report_fetch = mysqli_fetch_array($report_q)){



					  		?>

					    <tr>

					      <td><?php echo $report_fetch['offce_open_off_date']; ?></td>

					      <td><?php echo $report_fetch['attendance_date']; ?></td>
					      <td><?php echo $report_fetch['attendance']; ?></td>
					      <td><?php echo $name; ?></td>
					      <td><?php echo $report_fetch['in_time']; ?></td>
					      <td><?php 
						     $out_time = $report_fetch['out_time'];

						      if ($out_time=='') {
						      	echo "00:00:00";
						      }elseif ($out_time !='') {
						      	 $ot_strtime = strtotime($out_time);
						      	 echo date('h:i:s a', $ot_strtime);
						      }

					       ?></td>
					      <td><?php 
					      	$status = $report_fetch['status']; 
					      	if ($status=='0') {
					      		echo "Late Present";

					      	}elseif ($status=='1') {
					      		echo "Present";

					      	}elseif ($status=='2') {
					      		echo "Cancel";
					      	}
					      ?></td>
					      <td><?php echo $report_fetch['incoming_reason']; ?></td>
					      <td><?php echo $report_fetch['outgoing_reason']; ?></td>
					     

					    </tr>

					    

					    <?php

					    	}
							}
						}elseif ($select_emp!='') {
							
			        		foreach ($select_emp as $key => $value) {
			        			// echo $value;
			        			// echo "<br>";

			        			$select_emp_name="SELECT id, name from users WHERE id='$value' ";
			        			$select_emp_q = mysqli_query($connection, $select_emp_name);
			        			$emp_f = mysqli_fetch_array($select_emp_q);
			        			$name = $emp_f['name'];

			        			$report_sql="
									SELECT o.date                                  AS offce_open_off_date,
									       a.date                                  AS attendance_date,
									       IF(a.date IS NULL, 'Absent', 'Present') AS attendance,
									       a.*
									FROM   (SELECT date
									        FROM   offce_open_off ooo) o
									       LEFT JOIN (SELECT u.name AS user_name,
									                         date,
									                         emp_id,
									                         in_time,
									                         out_time,
									                         status,
									                         incoming_reason,
									                         outgoing_reason
									                  FROM   attendance a
									                         LEFT JOIN users u
									                                ON a.emp_id = u.id
									                  WHERE  date BETWEEN '$final_start_date' AND 
									                  '$final_end_date'
									                         AND emp_id = '$value') a
									              ON o.date = a.date
									WHERE  o.date BETWEEN '$final_start_date' AND '$final_end_date' 
									";

								$report_q = mysqli_query($connection, $report_sql);


									while($report_fetch = mysqli_fetch_array($report_q)){



					  		?>

					    <tr>

					      <td><?php echo $report_fetch['offce_open_off_date']; ?></td>

					      <td><?php echo $report_fetch['attendance_date']; ?></td>
					      <td><?php echo $report_fetch['attendance']; ?></td>
					      <td><?php echo $name; ?></td>
					      <td><?php echo $report_fetch['in_time']; ?></td>
					      <td><?php 

						      $out_time = $report_fetch['out_time'];

						      if ($out_time=='') {
						      	echo "00:00:00";
						      }elseif ($out_time !='') {
						      	 $ot_strtime = strtotime($out_time);
						      	 echo date('h:i:s a', $ot_strtime);
						      }

					       ?></td>
					      <td><?php 
					      	
					      	$status = $report_fetch['status']; 
					      	if ($status=='0') {
					      		echo "Late Present";

					      	}elseif ($status=='1') {
					      		echo "Present";

					      	}elseif ($status=='2') {
					      		echo "Cancel";
					      	}

					       ?></td>
					      <td><?php echo $report_fetch['incoming_reason']; ?></td>
					      <td><?php echo $report_fetch['outgoing_reason']; ?></td>
					     

					    </tr>

					    

					    <?php

					    	}
					    		

			        		}
			        		
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

	



<?php

include_once '../inc/footer.php';

?>

<script> 
  
  function tableToExcel(){

    $("#studtable").table2excel({ 
        filename: "attendance_report.xls" 
    }); 

}
  
</script> 

<style type="text/css">
	table tr td p,table tr td p span
	{
		font-size: 13px !important;
	}
</style>
</body>

</html>