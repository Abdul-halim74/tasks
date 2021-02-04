<?php error_reporting(0);



session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';

 $userid =$_SESSION['user_id'];



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
                    <div class="panel-heading">Overtime</div>
                    <div class="panel-body">

                        <?php

                             $current_date = date('Y-m-d');

                            $select_sql ="SELECT * FROM `overtime` where `emp_id` = '$userid' AND `overtime_date` =  '$current_date' AND `end_time` is null   ";

                            $select_q = mysqli_query($connection, $select_sql);
                            $select_f = mysqli_fetch_array($select_q);
                            //echo mysqli_num_rows($select_q);die;

                            if (mysqli_num_rows($select_q) > 0 ) {


                                ?>
                                <h4>Start From <?php
                                        $start_time = $select_f['start_time'];
                                   echo $time_in_12_hour_format  = date("g:i a", strtotime("$start_time"));

                                    ?></h4>
                               
                                <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            
                            <div class="form-group row mb-0 ">
                              <br>
                               <div class="col-md-12">
                                    <input class="btn btn-warning" type="submit" id="end_start" name="end_start" value="End Overtime" required="">

                                  </div>  
                              
                            </div>
                        </form>

                        <?php

                            }else{

                        ?>

                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group row">

                                        <label class="col-md-12 col-form-label">Task Title<i class="red">*</i></label>

                                        <div class="col-md-12">

                                            <input class="form-control" type="text" id="task_title" name="task_title" value="" required="">

                                           
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="form-group row mb-0 ">
                              <br>
                               <div class="col-md-12">
                                    <input class="btn btn-success" type="submit" id="overtime_start" name="overtime_start" value="Start Overtime" required="">

                                  </div>  
                              
                            </div>
                        </form>

                        <?php

                            }
                        ?>
                    </div>
                </div>
            </div>
          
            </div>

            <?php
                if (isset($_POST['overtime_start'])) {


                     $current_date = date('Y-m-d');

                            $select_sql ="SELECT * FROM `overtime` where `emp_id` = '$userid' AND `overtime_date` =  '$current_date'  ";

                            $select_q = mysqli_query($connection, $select_sql);
                            $select_f = mysqli_fetch_array($select_q);
                            //echo mysqli_num_rows($select_q);

                            if (mysqli_num_rows($select_q) > 0 ) {
                                 $_SESSION['result'] ='
                                <div class="alert alert-danger fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Your Overtime Already added in this date ! </strong> 
                                </div>
                                ';

                            echo "<script>window.location.href='overtime.php';</script>";
                            exit();


                            }

                   $task_title = $_POST['task_title'];
                  $insert_sql= "INSERT INTO `overtime` SET `emp_id` ='$userid',  `task_title` = '$task_title',
                  `overtime_date` = CURDATE(), `start_time` = CURTIME() ";

                 $insert_q = mysqli_query($connection, $insert_sql);

                 if ($insert_q==1) {

                      $_SESSION['result'] ='
                                <div class="alert alert-success fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Inserted Successfully</strong> 
                                </div>
                                ';

                            echo "<script>window.location.href='overtime.php';</script>";
                            exit();

                 }

                }


                if(isset($_POST['end_start'])){

                  echo  $start_time =  $select_f['start_time'];die;
                  

                  $time =  time() - strtotime($start_time);
                   $min = $time / 60;
                   $minute = round($min);

                     $insert_end_sql= "UPDATE `overtime` SET 
                   `end_time` = CURTIME(), `total_time` ='$minute' where `emp_id` ='$userid' AND `overtime_date` = CURDATE() ";

                   $update_q = mysqli_query($connection, $insert_end_sql);

                   if ($update_q==1) {
                       $_SESSION['result'] ='
                                <div class="alert alert-success fade in alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
                                <strong>Data Inserted Successfully</strong> 
                                </div>
                                ';

                            echo "<script>window.location.href='overtime.php';</script>";
                            exit();
                   }
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
