<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

 $month_and_year = $_GET['month_and_year'];

    
   
      $select_if_exist ="SELECT * FROM `others_marks` where year_and_month = '$month_and_year' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='others_mark.php';</script>";
                                exit();
                        }


    
                        $user_sql = "SELECT id, name FROM users ";
                                        
        
                $user_sql_q = mysqli_query($connection, $user_sql);

                $sl =0;
                while ($user_sql_f = mysqli_fetch_array($user_sql_q)) {
                        $sl++;


                $emp_id = $user_sql_f['id'];
               $name = $user_sql_f['name'];
               

             $inser_sql = "INSERT INTO `others_marks` SET `emp_id` = '$emp_id',reporting_marks='6',`dresscode_marks` = '2',`year_and_month` = '$month_and_year', 
              `entry_usr` = '$userid' ";

            $insert_q = mysqli_query($connection, $inser_sql);


     }

       if ($insert_q == 1) {

                  $_SESSION['result'] ='
                <div class="alert alert-success fade in alert-dismissible" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                <strong>Others Marks Inserted Successfully.</strong> 
                </div>
                ';

                echo "<script>window.location.href='others_mark.php';</script>";
                exit();

            }

?>

