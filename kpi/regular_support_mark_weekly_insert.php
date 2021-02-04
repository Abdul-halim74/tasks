<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

  $from_date = $_GET['from_date'];
  $to_date = $_GET['to_date'];

 
  
      $select_if_exist ="SELECT * FROM `regular_support_marks` where from_date = '$from_date' or `to_date`='$to_date' ";

                        $select_q = mysqli_query($connection, $select_if_exist);

                        if (mysqli_num_rows($select_q) > 0) {

                             $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Already Exist !</strong> 
                                </div>
                                ';

                                echo "<script>window.location.href='regular_support_marks.php';</script>";
                                exit();
                        }


    
                        $user_sql = "SELECT id, name FROM users ";
                                        
        
                $user_sql_q = mysqli_query($connection, $user_sql);

                $sl =0;
                while ($user_sql_f = mysqli_fetch_array($user_sql_q)) {
                        $sl++;


                $emp_id = $user_sql_f['id'];
               $name = $user_sql_f['name'];
               
                $select_sql ="SELECT 
count(m.status) as total,
(select count(p.status) from developer_tasks p where p.status = 1 and m.task_manager = p.task_manager and date(p.delivery_date) BETWEEN '$from_date' AND '$to_date' ) as progress,
(select count(c.status) from developer_tasks c where c.status = 2 and m.task_manager = c.task_manager and date(c.delivery_date) BETWEEN '$from_date' AND '$to_date') as complete
FROM developer_tasks m  where   find_in_set($emp_id , m.team_member) and date(m.delivery_date) BETWEEN '$from_date' AND '$to_date' ";

$select_q = mysqli_query($connection, $select_sql);
$select_f = mysqli_fetch_array($select_q);



   $complete_task = $select_f['complete'];

    $late_completed_status = $select_f['late_completed_status'];

    $late_completed_status_marks = $late_completed_status * 5;

    $total_task = $select_f['total'];

    $marks = ((20 * $complete_task) / $total_task) - $late_completed_status_marks;

   
    if ($total_task == '0') {
       $final_marks =0;

    }else{
          $final_marks = round($marks);
    }



             $inser_sql = "INSERT INTO `regular_support_marks` SET `emp_id` = '$emp_id',`from_date`='$from_date', `to_date`='$to_date',`total_task` = '$total_task', `completed_task` = '$complete_task',
             `marks` = '$final_marks', 
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

                echo "<script>window.location.href='regular_support_marks.php';</script>";
                exit();

            }

?>

