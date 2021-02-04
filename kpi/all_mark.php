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
                    <div class="panel-heading">All Marks</div>
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

            <form action="<?php echo $global_url; ?>/kpi/all_mark_insert.php?month_and_year=<?php echo 
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
                        <div class="panel-heading"> All Marks :<?php  echo $month_and_year; ?></div>
                            <div class="panel-body">

                                <table class="table table-bordered">
                                    <tr>
                                        
                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        
                                        <th>Attndance Marks</th>
                                        <th>Daily Time Marks</th>
                                        <th>Holiday Office Marks</th>
                                        <th>Overtime Marks</th>
                                        <th>Target Fillup Marks</th>
                                        <th>Regular Support Marks</th>
                                        <th>Reporting / Schedule Marks</th>
                                        <th>Dresscode / Office Decorum Marks (100)</th>
                                        <th>Total Marks</th>
                                       
                                    </tr>

                                 <?php



                                 $select_usr = "select
   id,
   name,
   if( isnull(dt_marks) = 1 , 0, dt_marks) as dt_marks,
   if( isnull(attenance_marks) = 1 , 0, attenance_marks) as attendance_marks, 
   if( isnull(hom_marks) = 1 , 0, hom_marks) as hom_marks,
   if( isnull(om_marks) = 1 , 0, om_marks) as om_marks,
    if( isnull(tfm_maarks) = 1 , 0, tfm_maarks) as tfm_maarks,
    if( isnull(rsm_marks) = 1 , 0, rsm_marks) as rsm_marks ,
    if( isnull(om_reporting_marks) = 1 , 0, om_reporting_marks) as om_reporting_marks ,
     if( isnull(om_dresscode_marks) = 1 , 0, om_dresscode_marks) as om_dresscode_marks 
   
from
   users u 
   left join
      (
         select
            emp_id as dt_emp_id,
            marks as dt_marks 
         from
            daily_time 
         where
             year_and_month ='$month_and_year'
      )
      daily_time 
      on u.id = daily_time.dt_emp_id 
   left join
      (
         select
            emp_id,
            if(marks = 'INF', 0, marks) as attenance_marks 
         from
            attendance_marks 
         where
           year_and_month ='$month_and_year'
      )
      attendace 
      on attendace.emp_id = u.id
      
    left join(
         select
         emp_id as hom_emp_id,
          marks as hom_marks
        from
           holiday_office_marks hom 
        where
           year_and_month ='$month_and_year'
    )  
        hom
        on hom.hom_emp_id = u.id
    
    left join(
         select
         om.emp_id om_emp_id,
         om.marks om_marks
        from
            overtime_marks om 
        where
           year_and_month ='$month_and_year'
    )
    om
    on om.om_emp_id = u.id 
    
    left join(
         select
         tfm.emp_id tfm_emp_id,
         tfm.marks tfm_maarks
        from
           target_fillup_marks tfm 
        where
          year_and_month ='$month_and_year'
    )
    tfm
    on tfm.tfm_emp_id = u.id
    
    left join(
         select
         rsm.emp_id rsm_emp_id,
         rsm.marks rsm_marks
        from
          regular_support_marks rsm 
        where
          year_and_month ='$month_and_year'
    )
    
    rsm
    on rsm.rsm_emp_id = u.id
    
    left join(
         select
    otm.emp_id om_emp_id,
    otm.reporting_marks om_reporting_marks,
    otm.dresscode_marks om_dresscode_marks
    
    from
     others_marks otm 
    where
      year_and_month ='$month_and_year'
    )
    otm
    on otm.om_emp_id = u.id
        
    ";

                                $select_usr_q = mysqli_query($connection, $select_usr);
                                $sl = 0;
                                while($select_usr_f = mysqli_fetch_array($select_usr_q)){
                                    $sl++;

                                 $user_id = $select_usr_f['id'];

                                
                                 ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>

                                        <td style="width: 200px;"><?php echo $select_usr_f['name'];  ?></td>

                                        <td><?php  if($select_usr_f['attendance_marks']==''){
                                           echo  $attendance_marks=0;
                                        }else{
                                            echo  $attendance_marks=$select_usr_f['attendance_marks'];
                                        } ?></td>

                                        
                                         <td>
                                              <?php   if($select_usr_f['dt_marks']==''){
                                                   echo $daily_time_marks = 0;
                                              }else{
                                                echo $daily_time_marks = $select_usr_f['dt_marks'];
                                              } ?>
                                         </td>

                                         <td><?php  

                                            if($select_usr_f['hom_marks']==''){
                                                   echo $hom_marks = 0;
                                              }else{
                                                echo $hom_marks = $select_usr_f['hom_marks'];
                                              } 

                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_marks']==''){
                                                   echo $overtime_marks = 0;
                                              }else{
                                                echo $overtime_marks = $select_usr_f['om_marks'];
                                              } 
                                              
                                         ?></td>


                                         <td><?php  

                                            if($select_usr_f['tfm_maarks']==''){
                                                   echo $tfm_marks = 0;
                                              }else{
                                                echo $tfm_marks = $select_usr_f['tfm_maarks'];
                                              } 
                                              
                                         ?></td>


                                         <td><?php  

                                            if($select_usr_f['rsm_marks']==''){
                                                   echo $rsm_marks = 0;
                                              }else{
                                                echo $rsm_marks = $select_usr_f['rsm_marks'];
                                              } 
                                              
                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_reporting_marks']==''){
                                                   echo $report_marks = 0;
                                              }else{
                                                echo $report_marks = $select_usr_f['om_reporting_marks'];
                                              } 
                                              
                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_dresscode_marks']==''){
                                                   echo $dresscode_marks = 0;
                                              }else{
                                                echo $dresscode_marks = $select_usr_f['om_dresscode_marks'];
                                              } 
                                              
                                         ?></td>

                                         <td><?php  
                                          echo $sum = $attendance_marks + $daily_time_marks + $hom_marks + $overtime_marks + $tfm_marks + $rsm_marks + $report_marks + $dresscode_marks;
                                              
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

            <form action="<?php echo $global_url; ?>/kpi/all_mark_weekly_insert.php?from_date=<?php echo 
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
                                        <th style="width: 200px;">Emp Name </th>
                                        
                                        <th>Attndance Marks</th>
                                        <th>Daily Time Marks</th>
                                        <th>Holiday Office Marks</th>
                                        <th>Overtime Marks</th>
                                        <th>Target Fillup Marks</th>
                                        <th>Regular Support Marks</th>
                                        <th>Reporting / Schedule Marks</th>
                                        <th>Dresscode / Office Decorum Marks</th>
                                        <th>Total Marks (100)</th>
                                    </tr>

                                   
                                    <?php



                                 $select_usr = "select
   id,
   name,
   if( isnull(dt_marks) = 1 , 0, dt_marks) as dt_marks,
   if( isnull(attenance_marks) = 1 , 0, attenance_marks) as attendance_marks, 
   if( isnull(hom_marks) = 1 , 0, hom_marks) as hom_marks,
   if( isnull(om_marks) = 1 , 0, om_marks) as om_marks,
    if( isnull(tfm_maarks) = 1 , 0, tfm_maarks) as tfm_maarks,
    if( isnull(rsm_marks) = 1 , 0, rsm_marks) as rsm_marks ,
    if( isnull(om_reporting_marks) = 1 , 0, om_reporting_marks) as om_reporting_marks ,
     if( isnull(om_dresscode_marks) = 1 , 0, om_dresscode_marks) as om_dresscode_marks 
   
from
   users u 
   left join
      (
         select
            emp_id as dt_emp_id,
            marks as dt_marks 
         from
            daily_time 
         where
            from_date >= '$from_date' 
            and to_date <= '$to_date' 
      )
      daily_time 
      on u.id = daily_time.dt_emp_id 
   left join
      (
         select
            emp_id,
            if(marks = 'INF', 0, marks) as attenance_marks 
         from
            attendance_marks 
         where
            from_date >= '$from_date' 
            and to_date <= '$to_date' 
      )
      attendace 
      on attendace.emp_id = u.id
      
    left join(
         select
         emp_id as hom_emp_id,
          marks as hom_marks
        from
           holiday_office_marks hom 
        where
           from_date >= '$from_date' 
           and to_date <= '$to_date'
    )  
        hom
        on hom.hom_emp_id = u.id
    
    left join(
         select
         om.emp_id om_emp_id,
         om.marks om_marks
        from
            overtime_marks om 
        where
            from_date >= '$from_date' 
           and to_date <= '$to_date'
    )
    om
    on om.om_emp_id = u.id 
    
    left join(
         select
         tfm.emp_id tfm_emp_id,
         tfm.marks tfm_maarks
        from
           target_fillup_marks tfm 
        where
           from_date >= '$from_date' 
           and to_date <= '$to_date'
    )
    tfm
    on tfm.tfm_emp_id = u.id
    
    left join(
         select
         rsm.emp_id rsm_emp_id,
         rsm.marks rsm_marks
        from
          regular_support_marks rsm 
        where
           from_date >= '$from_date' 
           and to_date <= '$to_date'
    )
    
    rsm
    on rsm.rsm_emp_id = u.id
    
    left join(
         select
    otm.emp_id om_emp_id,
    otm.reporting_marks om_reporting_marks,
    otm.dresscode_marks om_dresscode_marks
    
    from
     others_marks otm 
    where
       from_date >= '$from_date' 
           and to_date <= '$to_date'
    )
    otm
    on otm.om_emp_id = u.id
        
    ";

                                $select_usr_q = mysqli_query($connection, $select_usr);
                                $sl = 0;
                                while($select_usr_f = mysqli_fetch_array($select_usr_q)){
                                    $sl++;

                                 $user_id = $select_usr_f['id'];

                                
                                 ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>

                                        <td style="width: 200px;"><?php echo $select_usr_f['name'];  ?></td>

                                        <td><?php  if($select_usr_f['attendance_marks']==''){
                                           echo  $attendance_marks=0;
                                        }else{
                                            echo  $attendance_marks=$select_usr_f['attendance_marks'];
                                        } ?></td>

                                        
                                         <td>
                                              <?php   if($select_usr_f['dt_marks']==''){
                                                   echo $daily_time_marks = 0;
                                              }else{
                                                echo $daily_time_marks = $select_usr_f['dt_marks'];
                                              } ?>
                                         </td>

                                         <td><?php  

                                            if($select_usr_f['hom_marks']==''){
                                                   echo $hom_marks = 0;
                                              }else{
                                                echo $hom_marks = $select_usr_f['hom_marks'];
                                              } 

                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_marks']==''){
                                                   echo $overtime_marks = 0;
                                              }else{
                                                echo $overtime_marks = $select_usr_f['om_marks'];
                                              } 
                                              
                                         ?></td>


                                         <td><?php  

                                            if($select_usr_f['tfm_maarks']==''){
                                                   echo $tfm_marks = 0;
                                              }else{
                                                echo $tfm_marks = $select_usr_f['tfm_maarks'];
                                              } 
                                              
                                         ?></td>


                                         <td><?php  

                                            if($select_usr_f['rsm_marks']==''){
                                                   echo $rsm_marks = 0;
                                              }else{
                                                echo $rsm_marks = $select_usr_f['rsm_marks'];
                                              } 
                                              
                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_reporting_marks']==''){
                                                   echo $report_marks = 0;
                                              }else{
                                                echo $report_marks = $select_usr_f['om_reporting_marks'];
                                              } 
                                              
                                         ?></td>

                                          <td><?php  

                                            if($select_usr_f['om_dresscode_marks']==''){
                                                   echo $dresscode_marks = 0;
                                              }else{
                                                echo $dresscode_marks = $select_usr_f['om_dresscode_marks'];
                                              } 
                                              
                                         ?></td>

                                         <td><?php  
                                          echo $sum = $attendance_marks + $daily_time_marks + $hom_marks + $overtime_marks + $tfm_marks + $rsm_marks + $report_marks + $dresscode_marks;
                                              
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



