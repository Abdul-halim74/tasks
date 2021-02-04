<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

 $month_and_year = $_GET['month_and_year'];

 $montOfTheYear = date('m', strtotime($month_and_year));
  $year = date('Y', strtotime($month_and_year));
    
   
      $select_if_exist ="SELECT * FROM `target_fillup_marks` where 
                        `year_and_month`= '$month_and_year' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='target_fillup_marks.php';</script>";
                                exit();
                        }





    $target_fillup_marks_sql = "SELECT m.task_manager,
            count(m.status) as total,
            (select count(p.status) from developer_tasks p where p.status = 1 and m.task_manager = p.task_manager and  month(p.delivery_date)='$montOfTheYear' and YEAR(p.delivery_date)='$year') as progress,
            (select count(c.status) from developer_tasks c where c.status = 2 and m.task_manager = c.task_manager and  month(c.delivery_date)='$montOfTheYear' and YEAR(c.delivery_date)='$year') as complete
            FROM developer_tasks m  where month(m.delivery_date)='$montOfTheYear' 
            and YEAR(m.delivery_date)='$year'

            GROUP by m.task_manager order by m.task_manager ";

                                        
        
                $target_fillup_marks_q = mysqli_query($connection, $target_fillup_marks_sql);

                while ($target_fillup_marks_f = mysqli_fetch_array($target_fillup_marks_q)) {
                        $sl++;


                $emp_id = $target_fillup_marks_f['task_manager'];
               $total_task = $target_fillup_marks_f['total'];
               $complete_task = $target_fillup_marks_f['complete'];

                $late_completed_status = $target_fillup_marks_f['late_completed_status'];

                $late_completed_status_marks = $late_completed_status * 5;

                $total_task = $target_fillup_marks_f['total'];

                $marks = ((50 * $complete_task) / $total_task) - $late_completed_status_marks;

                 $final_marks = round($marks);


               

             $inser_sql = "INSERT INTO `target_fillup_marks` SET `emp_id` = '$emp_id', `year_and_month` = '$month_and_year', `total_task`= '$total_task',`completed_task` = '$complete_task', 
             `marks` = '$final_marks',
              `entry_usr` = '$userid' ";

            $insert_q = mysqli_query($connection, $inser_sql);


     }

       if ($insert_q == 1) {

                  $_SESSION['result'] ='
                <div class="alert alert-success fade in alert-dismissible" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                <strong>Holiday Office Marks  Inserted Successfully.</strong> 
                </div>
                ';

                echo "<script>window.location.href='target_fillup_marks.php';</script>";
                exit();

            }

?>

