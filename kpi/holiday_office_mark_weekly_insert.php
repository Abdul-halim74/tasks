<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

  $from_date = $_GET['from_date'];
  $to_date = $_GET['to_date'];




      $select_if_exist ="SELECT * FROM `holiday_office_marks` where 
                        `from_date`= '$from_date' or `to_date`='$to_date' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='holiday_office_marks.php';</script>";
                                exit();
                        }

 

   $holiday_office_marks_sql = "  SELECT  count(ho.emp_id) as total_holiday_office_attend, usr.name FROM `holiday_office` ho left join users usr on ho.emp_id = usr.id where ho.date BETWEEN '$from_date' and '$to_date'  GROUP BY ho.emp_id ";

                                        
            $holiday_office_marks_q = mysqli_query($connection, $holiday_office_marks_sql);

            while ($holiday_office_marks_f = mysqli_fetch_array($holiday_office_marks_q)) {


               $emp_id = $holiday_office_marks_f['id'];

               $total_holiday_office_attend = $holiday_office_marks_f['total_holiday_office_attend'];

               $select_from_para = "SELECT * FROM `kpi_parameter` ";

                $para_q = mysqli_query($connection, $select_from_para);

                $para_f = mysqli_fetch_array($para_q);

                $holiday_office_at_least = $para_f['holiday_office'];

                $total_holiday_office_attend = $holiday_office_marks_f['total_holiday_office_attend'];

                if($total_holiday_office_attend >= $holiday_office_at_least){
                     $final_marks = 3 ;
                }elseif($total_holiday_office_attend < $holiday_office_at_least){

                      $marks = (3 * $total_holiday_office_attend) / $holiday_office_at_least;

                      $final_marks = round($marks);
                }


             $inser_sql = "INSERT INTO `holiday_office_marks` SET `emp_id` = '$emp_id', `total_holiday_office` = '$total_holiday_office_attend',  `marks` = '$final_marks',
              `from_date` = '$from_date', `to_date` = '$to_date',
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

                echo "<script>window.location.href='holiday_office_marks.php';</script>";
                exit();

            }





?>

