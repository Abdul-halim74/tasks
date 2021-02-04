<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

 $month_and_year = $_GET['month_and_year'];

 $montOfTheYear = date('m', strtotime($month_and_year));
  $year = date('Y', strtotime($month_and_year));
    
   


      $select_if_exist ="SELECT * FROM `overtime_marks` where 
                        `year_and_month`= '$month_and_year' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='overtime_marks.php';</script>";
                                exit();
                        }




 $select_overtime_maarks ="SELECT * FROM `kpi_parameter` ";

    $overtime_marks_q = mysqli_query($connection, $select_overtime_maarks);

    $overtime_f = mysqli_fetch_array($overtime_marks_q);



  $overtime_marks_sql = "SELECT  usr.name as emp_name, sum(att.total_overtime) as total_hourse FROM `attendance` att LEFT JOIN users usr on att.emp_id = usr.id WHERE MONTH(att.date)='$montOfTheYear' and YEAR(att.date)='$month_and_year' GROUP BY emp_id";

                                        
          $overtime_marks_q = mysqli_query($connection, $overtime_marks_sql);

            while ($overtime_marks_f = mysqli_fetch_array($overtime_marks_q)) {


               $emp_id = $overtime_marks_f['emp_id'];
             

               

                $hrs = $overtime_marks_f['total_hourse'];
                 $hours =  round($hrs);

 

                if ($hours >= 200) {
                         $final_marks=3;
                     }else{

                          $marks =  (3 * $hours) / 200;

                           $final_marks = round($marks);
                     }


             $inser_sql = "INSERT INTO `overtime_marks` SET `emp_id` = '$emp_id',   `year_and_month` = '$month_and_year', `total_time_hours`= '$hours', `marks` = '$final_marks',
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

                echo "<script>window.location.href='overtime_marks.php';</script>";
                exit();

            }

?>

