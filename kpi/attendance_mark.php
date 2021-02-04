<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

$month_and_year = $_POST['start'];

 $dept = $_POST['dept'];


?>
<body>

<div id="app" class="app">
    <?php include_once  '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid">
        <div class="container-fluid">
          
            <div class="row">
            <div class="col-md-6 col-lg-6">
              <?php
            echo  $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Attendance Marks</div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                   

                                   <?php
                                    $kpi_para_sql = "SELECT * FROM `kpi_parameter`";
                                    $kpi_q =mysqli_query($connection, $kpi_para_sql);

                                    $kpi_f = mysqli_fetch_array($kpi_q);

                                    if ($kpi_f['marks_generate'] == 1) {
                                       
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Select Month and Year<i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="month" id="start" name="start" min="2019-01" value="" required="">

                                       		<small> Month-Year</small>
                                        </div>
                                    </div><!--END-->

                                    <?php

                                     }elseif ($kpi_f['marks_generate'] == 0) {


                                        ?>
                                         
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">From date<i class="red">*</i></label>
                                        <div class="col-md-12">

                                            <input class="form-control" type="date" id="from_date" name="from_date" value="" required="">

                                           
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">To date<i class="red">*</i></label>
                                        <div class="col-md-12">

                                            <input class="form-control" type="date" id="to_date" name="to_date" value="" required="">

                                           
                                        </div>
                                    </div>

                                    <?php

                                     }

                                   ?>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Select Departmemt<i class="red">*</i></label>
                                        <div class="col-md-12">

                                            <select class="form-control" name="dept" required="required">
                                            	<option>--select--</option>
                                            	<option value="programmer">programmer</option>
                                            	<option value="marketting">marketting</option>

                                            </select>

                                        </div>
                                    </div><!--END-->

                                    
                                </div>

                            </div>
                            <div class="form-group row mb-0 ">
                              <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn  btn-info" name="search">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp; Search &nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          
            </div>


            <?php
            if ($kpi_f['marks_generate'] == 1) {

                ?>

            <form action="<?php echo $global_url; ?>/kpi/attendance_mark_insert.php?month_and_year=<?php echo 
            $month_and_year; ?>&dept=<?php echo $dept; ?> " method="post" style="margin-bottom: 30px;">
            <?php
            	if (isset($_POST['search'])) {

						
						$month_and_year = $_POST['start'];
					 $montOfTheYear = date('m', strtotime($month_and_year));
					  $year = date('Y', strtotime($month_and_year));

					 $dept = $_POST['dept'];
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
				

            <div class="row">
            	<div class="col-md-12">
            		<div class="panel panel-default">
                    	<div class="panel-heading">Office Opened of <strong><?php echo $dept; ?> </strong> team <?php echo $month_and_year; ?> :  &nbsp; <?php  echo $total_days_office; ?> days</div>
                    		<div class="panel-body">

		            		

			            		<table class="table table-bordered">
			            			<tr>
			            				<th>Sl </th>
			            				<th>Emp Name </th>
			            				
			            				<th>Present</th>
			            				<th>Absent</th>
			            				<th>Marks</th>
			            			</tr>

			            			<?php

			            			


			            				$sl= 0;

			            				 if ($dept =='programmer') {

			            					 $attendance_info_sql = "SELECT  count(att.status) as total_present, usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where MONTH(att.date) = '$montOfTheYear' and YEAR(att.date)='$year' and att.`status` in (0,1,3) and usr.department_id like '%2%' GROUP BY att.emp_id";

			            				}elseif ($dept !='programmer') {

			            					 $attendance_info_sql = "SELECT  count(att.status) as total_present, usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where MONTH(att.date) = '$montOfTheYear' and YEAR(att.date)='$year'  and att.`status` in (0,1,3) and usr.department_id NOT LIKE '%2%' GROUP BY att.emp_id";

			            				}


			            				$attendance_info_q = mysqli_query($connection, $attendance_info_sql);

			            				while ($attendance_info_f = mysqli_fetch_array($attendance_info_q)) {
			            						$sl++;

			            					

			            				?>
			            				
			            			<tr>
			            				<td><?php echo $sl; ?></td>

			            				<td><?php  echo $attendance_info_f['name'] ?></td>

			            				<td><?php echo $attendance_info_f['total_present'] ?></td>

			            			<td>
                                        <?php echo $total_days_office - $attendance_info_f['total_present'];
			            				?></td>

			            				<td><?php
			            					$cal = (8 * $attendance_info_f['total_present']) / $total_days_office;

			            					echo round($cal);
			            				?></td>
			            			</tr>

			            			<?php

				            			}

			            			?>

			            		</table>

			            		


		            	</div>
		            </div>
            	</div>
            </div>

            <input type="submit" name="submit" class="btn btn-success">

          <?php  


            }

        
            ?>

            
		   </form>

           <?php



        }
           ?>


          <!--  for weekly or daily  -->


           <?php
            if ($kpi_f['marks_generate'] == 0) {

                ?>

            <form action="<?php echo $global_url; ?>/kpi/attendance_mark_weekly_insert.php?from_date=<?php echo 
            $_POST['from_date']; ?>&to_date=<?php echo $_POST['to_date']; ?>&dept=<?php echo $dept; ?> " method="post" style="margin-bottom: 30px;">

            <?php
                if (isset($_POST['search'])) {

                        
                      $from_date = $_POST['from_date'];
                      $to_date = $_POST['to_date'];

                     // $montOfTheYear = date('m', strtotime($month_and_year));
                     //  $year = date('Y', strtotime($month_and_year));

                     $dept = $_POST['dept'];
                     if ($dept =='programmer') {
                        $select_sql="SELECT * FROM `offce_open_off` where programmer='1' and `date` between 
                        '$from_date' and '$to_date' ";

                        $select_q = mysqli_query($connection, $select_sql);

                        $total_days_office = mysqli_num_rows($select_q);
                     
                     }elseif ($dept !='programmer') {

                        $select_sql = "SELECT * FROM `offce_open_off` where marketting='1' and `date` between 
                        '$from_date' and '$to_date' ";

                        $select_q = mysqli_query($connection, $select_sql);

                        $total_days_office = mysqli_num_rows($select_q);
                     }
                     ?>
                

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>From</strong> <?php echo $from_date ." <strong>to</strong> ". $to_date; ?> Office Opened of <strong><?php echo $dept; ?> </strong> team  :  &nbsp; <?php  echo $total_days_office; ?> days </div>
                            <div class="panel-body">

                            
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Marks</th>
                                    </tr>

                                    <?php

                                    


                                        $sl= 0;

                                         if ($dept =='programmer') {

                                        
                                             $attendance_info_sql = "SELECT  count(att.status) as total_present, usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where att.date between '$from_date' and '$to_date' and att.`status` in (0,1,3) and usr.department_id like '%2%' GROUP BY att.emp_id";

                                        }elseif ($dept !='programmer') {

                                             $attendance_info_sql = "SELECT  count(att.status) as total_present, usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where att.date between '$from_date' and '$to_date' and att.`status` in (0,1,3) and usr.department_id not like '%2%' GROUP BY att.emp_id";

                                        }


                                        $attendance_info_q = mysqli_query($connection, $attendance_info_sql);

                                        while ($attendance_info_f = mysqli_fetch_array($attendance_info_q)) {
                                                $sl++;

                                            

                                        ?>
                                        
                                    <tr>
                                        <td><?php echo $sl; ?></td>

                                        <td><?php  echo $attendance_info_f['name'] ?></td>

                                        <td><?php echo $attendance_info_f['total_present'] ?></td>

                                        <td><?php

                                            echo $total_days_office - $attendance_info_f['total_present'];
                                        ?></td>

                                        <td><?php
                                            $cal = (8 * $attendance_info_f['total_present']) / $total_days_office;

                                            echo round($cal);
                                        ?></td>
                                    </tr>

                                    <?php

                                        }

                                    ?>

                                </table>

                                


                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" name="submit" class="btn btn-success">

          <?php  


            }

        
            ?>

            
           </form>

           <?php

        
        }
           ?>

        </div>
    </div>
</div>

</div>
<?php
include_once '../inc/footer.php';
?>
</body>
</html>
