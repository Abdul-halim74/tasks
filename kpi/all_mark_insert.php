<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

  $month_and_year = $_GET['month_and_year'];

 
  
      $select_if_exist ="SELECT * FROM `all_marks` where year_and_month = '$month_and_year' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='all_mark.php';</script>";
                                exit();
                        }


    
                            
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

                                 if($select_usr_f['attendance_marks']==''){
                                             $attendance_marks=0;
                                        }else{
                                              $attendance_marks=$select_usr_f['attendance_marks'];
                                        }

                                  if($select_usr_f['dt_marks']==''){
                                                    $daily_time_marks = 0;
                                              }else{
                                                 $daily_time_marks = $select_usr_f['dt_marks'];
                                              }
                                   if($select_usr_f['hom_marks']==''){
                                                    $hom_marks = 0;
                                              }else{
                                                 $hom_marks = $select_usr_f['hom_marks'];
                                              } 


                                     if($select_usr_f['om_marks']==''){
                                                    $overtime_marks = 0;
                                              }else{
                                                 $overtime_marks = $select_usr_f['om_marks'];
                                              } 
                                              
                                      if($select_usr_f['tfm_maarks']==''){
                                                    $tfm_marks = 0;
                                              }else{
                                                 $tfm_marks = $select_usr_f['tfm_maarks'];
                                              } 
                                              

                                        if($select_usr_f['rsm_marks']==''){
                                                    $rsm_marks = 0;
                                              }else{
                                                 $rsm_marks = $select_usr_f['rsm_marks'];
                                              } 
                                              
                                         if($select_usr_f['om_reporting_marks']==''){
                                                    $report_marks = 0;
                                              }else{
                                                 $report_marks = $select_usr_f['om_reporting_marks'];
                                              } 
                                              
                                          if($select_usr_f['om_dresscode_marks']==''){
                                                    $dresscode_marks = 0;
                                              }else{
                                                 $dresscode_marks = $select_usr_f['om_dresscode_marks'];
                                              }                                     

                                 
                                  $sum = $attendance_marks + $daily_time_marks + $hom_marks + $overtime_marks + $tfm_marks + $rsm_marks + $report_marks + $dresscode_marks;


                                $insert_sql = "INSERT INTO all_marks SET `emp_id` = '$user_id', 
                                attendance_marks='$attendance_marks', daily_time_marks ='$daily_time_marks', holiday_office_time_marks = '$hom_marks', overtime_marks='$overtime_marks', target_fillup_marks='$tfm_marks', regular_suupport_marks ='$rsm_marks', report_schedule_marks = '$report_marks', 
                                dresscode_marks ='$dresscode_marks', total = '$sum', year_and_month='$month_and_year', entry_usr='$userid'  ";

                               
                                $insert_q = mysqli_query($connection, $insert_sql);

                             }

                            
                             

       if ($insert_q == 1) {

                  $_SESSION['result'] ='
                <div class="alert alert-success fade in alert-dismissible" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                <strong>All Marks Inserted Successfully.</strong> 
                </div>
                ';

                echo "<script>window.location.href='all_mark.php';</script>";
                exit();

            }

?>

