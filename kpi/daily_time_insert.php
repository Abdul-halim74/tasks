<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

 $month_and_year = $_GET['month_and_year'];





     $montOfTheYear = date('m', strtotime($month_and_year));
      $year = date('Y', strtotime($month_and_year));
    
     $select_late_sql = "select m.emp_id,
                    (select count(status) from attendance l where l.status = 0 and l.emp_id = m.emp_id and month(l.date) = '$montOfTheYear' AND year(l.date)='$year' ) as late,
                    (select count(status) from attendance l where l.status in (1,3) and l.emp_id = m.emp_id and month(l.date) = '$montOfTheYear' AND year(l.date)='$year' ) as att
                    from attendance m
                    where month(m.date) = '$montOfTheYear'
                    group by m.emp_id";

     $late_q = mysqli_query($connection, $select_late_sql);


      $select_if_exist ="SELECT * FROM `daily_time` where 
                        `year_and_month`= '$month_and_year' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='daily_time.php';</script>";
                                exit();
                        }

    // $f= mysql_fetch_array($late_q);

     while ($late_f = mysqli_fetch_array($late_q)) {

            $emp_id = $late_f['emp_id'];

             $select_emp_name = "select name from `users` where `id` = '$emp_id' ";
             $select_q = mysqli_query($connection, $select_emp_name);

             $select_f = mysqli_fetch_array($select_q);

             $emp_name = $select_f['name'];
            
            $total_attend = $late_f['late'] + $late_f['att'];

            $late = $late_f['late'];


            $total_attend = $late_f['late'] + $late_f['att'];
            $right_time_attend = $total_attend - $late_f['late'];

            $cal = (8 * $right_time_attend) / $total_attend;

            $late_marks = round($cal);

             $inser_sql = "INSERT INTO `daily_time` SET `emp_id` = '$emp_id', `emp_name` = '$emp_name', 
            `year_and_month` = '$month_and_year', `total_attend` = '$total_attend', `total_late` = '$late', 
            `marks` = '$late_marks', `entry_user` = '$userid' ";

            $insert_q = mysqli_query($connection, $inser_sql);

          


     }

       if ($insert_q == 1) {

                  $_SESSION['result'] ='
                <div class="alert alert-success fade in alert-dismissible" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                <strong>attendance Marks  Inserted Successfully.</strong> 
                </div>
                ';

                echo "<script>window.location.href='daily_time.php';</script>";
                exit();

            }





?>

