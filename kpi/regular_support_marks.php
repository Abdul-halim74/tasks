<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

$month_and_year = $_POST['start'];


 $select_overtime_maarks ="SELECT * FROM `kpi_parameter` ";

    $overtime_marks_q = mysqli_query($connection, $select_overtime_maarks);

    $overtime_f = mysqli_fetch_array($overtime_marks_q);

     $overtime_marks = $overtime_f['overtime'];

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
                    <div class="panel-heading">Regular Support Marks</div>
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
  
            
		   </form>

            


            <?php
            if ($kpi_f['marks_generate'] == 1) {

                ?>

            <form action="<?php echo $global_url; ?>/kpi/regular_support_mark_insert.php?month_and_year=<?php echo 
            $month_and_year; ?> " method="post" style="margin-bottom: 30px;">
            <?php
                if (isset($_POST['search'])) {

                        
                        $month_and_year = $_POST['start'];
                     $montOfTheYear = date('m', strtotime($month_and_year));
                      $year = date('Y', strtotime($month_and_year));

                    
                        

                     ?>
                

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> Regular Support Marks :<?php  echo $month_and_year; ?></div>
                            <div class="panel-body">

                                <table class="table table-bordered">
                                    <tr>
                                        
                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        
                                        <th>Total Task Assigned </th>
                                        <th>Completed</th>
                                        <th>Marks</th>
                                       
                                    </tr>

                                 <?php


                                 $select_usr = "SELECT id, name FROM users";
                                $select_usr_q = mysqli_query($connection, $select_usr);
                                $sl = 0;
                                while($select_usr_f = mysqli_fetch_array($select_usr_q)){
                                    $sl++;

                                 $user_id = $select_usr_f['id'];

                                 $select_sql ="SELECT 
count(m.status) as total,
(select count(p.status) from developer_tasks p where p.status = 1 and m.task_manager = p.task_manager and  month(p.delivery_date)='$montOfTheYear' and year(p.delivery_date)='$year' ) as progress,
(select count(c.status) from developer_tasks c where c.status = 2 and m.task_manager = c.task_manager and  month(c.delivery_date)='$montOfTheYear' and year(c.delivery_date)='$year' ) as complete
FROM developer_tasks m  where   find_in_set($user_id, m.team_member) and month(m.delivery_date)='$montOfTheYear' and year(m.delivery_date)='$year'";

$select_q = mysqli_query($connection, $select_sql);
$select_f = mysqli_fetch_array($select_q);

                                 ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>

                                        <td><?php echo $select_usr_f['name'];  ?></td>

                                        <td><?php  echo $select_f['total']; ?></td>

                                        
                                         <td>
                                              <?php  echo $select_f['complete']; ?>
                                         </td>

                                         <td><?php  


                                           $complete_task = $select_f['complete'];

                                            $late_completed_status = $select_f['late_completed_status'];

                                            $late_completed_status_marks = $late_completed_status * 5;

                                            $total_task = $select_f['total'];

                                            $marks = ((20 * $complete_task) / $total_task) - $late_completed_status_marks;

                                           
                                            if ($total_task == '0') {
                                               echo "0";
                                            }else{
                                                 echo $final_marks = round($marks);
                                            }

                                         ?></td>

                                    </tr>

  <?php  } ?>


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

            <form action="<?php echo $global_url; ?>/kpi/regular_support_mark_weekly_insert.php?from_date=<?php echo 
            $_POST['from_date']; ?>&to_date=<?php echo $_POST['to_date']; ?> " method="post" style="margin-bottom: 30px;">

            <?php
                if (isset($_POST['search'])) {

                        
                      $from_date = $_POST['from_date'];
                      $to_date = $_POST['to_date'];

                     // $montOfTheYear = date('m', strtotime($month_and_year));
                     //  $year = date('Y', strtotime($month_and_year));

                    
                     ?>
                

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>From</strong> <?php echo $from_date ." <strong>to</strong> ". $to_date; ?> </div>
                            <div class="panel-body">

                            
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        
                                        
                                        <th>Total Task Assigned </th>
                                        <th>Completed</th>
                                        <th>Marks</th>
                                    </tr>

                                   
                                    <?php


                                 $select_usr = "SELECT id, name FROM users";
                                $select_usr_q = mysqli_query($connection, $select_usr);
                                $sl = 0;
                                while($select_usr_f = mysqli_fetch_array($select_usr_q)){
                                    $sl++;

                                 $user_id = $select_usr_f['id'];

                                 $select_sql ="SELECT 
count(m.status) as total,
(select count(p.status) from developer_tasks p where p.status = 1 and m.task_manager = p.task_manager and date(p.delivery_date) BETWEEN '$from_date' AND '$to_date' ) as progress,
(select count(c.status) from developer_tasks c where c.status = 2 and m.task_manager = c.task_manager and date(c.delivery_date) BETWEEN '$from_date' AND '$to_date') as complete
FROM developer_tasks m  where   find_in_set($user_id , m.team_member) and date(m.delivery_date) BETWEEN '$from_date' AND '$to_date' ";

$select_q = mysqli_query($connection, $select_sql);
$select_f = mysqli_fetch_array($select_q);

                                 ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>

                                        <td><?php echo $select_usr_f['name'];  ?></td>

                                        <td><?php  echo $select_f['total']; ?></td>

                                        
                                         <td>
                                              <?php  echo $select_f['complete']; ?>
                                         </td>

                                         <td><?php  


                                           $complete_task = $select_f['complete'];

                                            $late_completed_status = $select_f['late_completed_status'];

                                            $late_completed_status_marks = $late_completed_status * 5;

                                            $total_task = $select_f['total'];

                                            $marks = ((20 * $complete_task) / $total_task) - $late_completed_status_marks;

                                           
                                            if ($total_task == '0') {
                                               echo "0";
                                            }else{
                                                 echo $final_marks = round($marks);
                                            }

                                         ?></td>

                                    </tr>

  <?php  } ?>


                                   
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
