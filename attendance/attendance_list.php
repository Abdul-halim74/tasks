<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];
$time=date('h:i:s');
$date = date("Y-m-d");
if (isset($_POST['approve_btn'])) {
     extract($_REQUEST);
     $approve_sql="UPDATE `attendance` SET  `status`='3' WHERE `id`='$id'";
     $result = mysqli_query($connection,$approve_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong> Request  </strong>    Approved Successfully.
        </div>
        ';
        echo "<script>window.location.href='attendance_list.php';</script>";
        //header('location:attendance.php');
        exit();
    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
        ';
         echo "<script>window.location.href='attendance_list.php';</script>";
        exit();
    }
}
if (isset($_POST['reject_btn'])) {
     extract($_REQUEST);
     $approve_sql="UPDATE `attendance` SET  `status`='2' WHERE `id`='$id'";
     $result = mysqli_query($connection,$approve_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong> Request  </strong>    Are  Rejected.
        </div>
        ';
        echo "<script>window.location.href='attendance_list.php';</script>";
        //header('location:attendance.php');
        exit();
    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
        ';
         echo "<script>window.location.href='attendance_list.php';</script>";
        exit();
    }
}

if (isset($_POST['btn_out_attendance'])) {
    extract($_REQUEST);
    
    $leave_sql="UPDATE `attendance` SET  `out_time`='$time' WHERE `emp_id`='$userid' AND `date`='$date'";
  $result = mysqli_query($connection,$leave_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>OUT  </strong>   Request Taken Successfully.
        </div>
        ';
        echo "<script>window.location.href='attendance_list.php';</script>";
        //header('location:attendance.php');
        exit();
    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
        ';
         echo "<script>window.location.href='attendance_list.php';</script>";
        exit();
    }
}
?>
<body>
<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>
<div class="content-area">
    <div class="container-fluid">
        <div class="container-fluid">
         <?php
            echo  $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
            <div class="modal fade text-center" id="out_attendance" role="dialog"> 
                                <div class="modal-dialog" style="width:440px;">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h5 class="modal-title">Are You sure want to OUT now for Today ?</h5>
                                    </div>
                                    <div class="modal-body">
                                    
                                        <form method="post" action="">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;&nbsp;
                                                <button type="submit" class="btn  btn-success" name="btn_out_attendance">
                                            &nbsp;&nbsp;&nbsp; <i class="fa fa-sign-in" aria-hidden="true"></i>     OK &nbsp;&nbsp;&nbsp;
                                        </button>
                                        <br /><br /> 
                                    </form>
                                    </div><!--END-->
                                         
                                    </div>
                                    
                                  </div>
                                  
                                </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                 <?php if($_SESSION['employee_role']==3){ ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Attendance List's</div>
                        <div class="panel-body">
                           
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                    <th class="text-center">Status</th>
                                    <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $select_attendace="SELECT *,attendance.id as attentdanceId FROM `attendance`  INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id` WHERE `attendance`.emp_id=$userid ORDER BY `attendance`.`date` DESC";
                                     $result = mysqli_query($connection, $select_attendace);
                                     while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                                        <td><?php echo date('l', strtotime($row['date'])); ?> </td>
                                        <td class="text-center"><?php  echo date("h:i a",strtotime($row['in_time']));   ?> </td>
                                        <td class="text-center">
                                        <?php   
                                        $out=$row['out_time']; 
                                        if($out){ 
                                            echo date("h:i a",strtotime($out));  
                                            ?> 
                                        <?php }else{ ?>
                                        
                                          <?php }  ?>
                                        </td>
                                        <td class="text-center">
                                          <?php   
                                        $time = date('H:i:s',strtotime("10 AM")); 
                                        $status=$row['status'];
                                       
                                        $status_sql="SELECT * FROM `attendance_status` WHERE id ='$status'";
                                        $status_result = mysqli_query($connection, $status_sql);
                                        $show_status = mysqli_fetch_assoc($status_result);
                                        $show_status=$show_status['id']; 
                                          
                                        if($show_status==1){
                                                 echo "<span class='green'><i class='fa fa-adjust'></i> Present<span>";
                                        }else if($show_status==0 && $row['in_time']!=''){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Present<span>";
                                          }else if($show_status==2){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late<span>";
                                         }else if($show_status==3){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Permitted<span>";
                                         }
                                          else{  
                                        }
                                        
                                          ?></td>
                                        <td><?php  echo $row['incoming_reason'];  ?></td>
                                           <td><?php  echo $row['outgoing_reason'];  ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                     <th class="text-center">Status</th>
                                    <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                </tr>
                                </tfoot>
                            </table>
                          
                        </div>
                    </div>
                 <?php }else if($_SESSION['employee_role']==2){ ?>
                 <div class="row">
                  <div class="col-md-7">
                  </div>
                 <div class="col-md-5">
                  <div class="panel panel-default">
                        <div class="panel-body">
                             <form action="" method="GET">
                            <div class="input-group datebox">
                             <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                                <input type="text" name="date" class="form-control simple-datepicker" placeholder="Select Date to  Filter" required="" />
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">
                                    <i class="glyphicon glyphicon-search"></i> SEARCH
                                    </button>
                                </div>
                            </div>
                         </form>
                          
                        </div>
                    </div>
                 </div>
                 </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Attendance List's <?php if($_GET['date']){ echo "<b class='green'> For ".date('jS   F Y  ', strtotime($_GET['date']))."</b>";} ?>
                        
                        </div>
                        <div class="panel-body">
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                    <th class="text-center">Status</th>
                                    <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $filter_date=date('Y-m-d',strtotime($_GET['date']));
                                if($_GET['date']==''){
                                   $department_id=$_SESSION['department_id'];
                                   $select_attendace="SELECT *,attendance.id as attentdanceId,users.id as  user_id FROM `attendance`  INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id` WHERE `users`.department_id=$department_id  ORDER BY `attendance`.`date` DESC";
                                   $result = mysqli_query($connection, $select_attendace);
                                     while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php  echo $row['name'];  ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                                        <td><?php echo date('l', strtotime($row['date'])); ?> </td>
                                        <td class="text-center"><?php    echo date("h:i a",strtotime($row['in_time']));       ?> </td>
                                        <td class="text-center">
                                        <?php   
                                        $out=$row['out_time'];
                                        if($out){ 
                                            echo date("h:i a",strtotime($out)); 
                                            ?> 
                                        <?php }  ?>
                                        </td>
                                        <td class="text-center">
                                        <?php   
                                        $time = date('H:i:s',strtotime("10 AM")); 
                                        $status=$row['status'];
                                        
                                         $status_sql="SELECT * FROM `attendance_status` WHERE id ='$status'";
                                        $status_result = mysqli_query($connection, $status_sql);
                                        $show_status = mysqli_fetch_assoc($status_result);
                                        $show_status=$show_status['id'];  
                                        
                                        if($show_status==1){
                                                 echo "<span class='green'><i class='fa fa-adjust'></i> Present<span>";
                                        }else if($show_status==0 && $row['in_time']!=''){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Present<span>";
                                          }else if($show_status==2){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late<span>";
                                         }else if($show_status==3){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Permitted<span>";
                                         }
                                          else{  
                                        }
                                        
                                         ?></td>
                                           <td><?php  echo $row['incoming_reason'];  ?></td>
                                           <td><?php  echo $row['outgoing_reason'];  ?></td>
                                           
                                    </tr>
                                <?php
                                }}else{ 
                                    $department_id=$_SESSION['department_id'];
                                    $select_attendace="SELECT *,attendance.id as attentdanceId,users.id as  user_id FROM `attendance`  INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id` WHERE `attendance`.date='$filter_date'  AND `users`.department_id=$department_id";
                                   $result = mysqli_query($connection, $select_attendace);
                                     while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php  echo $row['name'];  ?></td>
                                        <td><?php echo date('jS   F Y  ', strtotime($row['date'])); ?> </td>
                                        <td class="text-center"><?php    echo date("h:i a",strtotime($row['in_time']));       ?> </td>
                                        <td class="text-center">
                                        <?php   
                                        $out=$row['out_time'];
                                        if($out){ 
                                            echo date("h:i a",strtotime($out)); 
                                            ?> 
                                        <?php }  ?>
                                        </td>
                                        <td class="text-center">
                                        <?php   
                                        $time = date('H:i:s',strtotime("10 AM")); 
                                        $status=$row['status'];
                                        
                                         $status_sql="SELECT * FROM `attendance_status` WHERE id ='$status'";
                                        $status_result = mysqli_query($connection, $status_sql);
                                        $show_status = mysqli_fetch_assoc($status_result);
                                        $show_status=$show_status['id'];  
                                        
                                        if($show_status==1){
                                                 echo "<span class='green'><i class='fa fa-adjust'></i> Present<span>";
                                        }else if($show_status==0 && $row['in_time']!=''){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Present<span>";
                                          }else if($show_status==2){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late<span>";
                                         }else if($show_status==3){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Permitted<span>";
                                         }
                                          else{  
                                        }
                                        
                                         ?></td>
                                           <td><?php  echo $row['incoming_reason'];  ?></td>
                                           <td><?php  echo $row['outgoing_reason'];  ?></td>
                                           
                                    </tr>
                                    
                               <?php }}
                                ?>
                              
                                </tbody>
                                <tfoot>
                                <tr>
                                   <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                     <th class="text-center">Status</th>
                                    <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                    
                                </tr>
                                </tfoot>
                            </table>
                          
                        </div>
                    </div>
                     <?php }else if($_SESSION['employee_role']==1){ ?>
                  <div class="row">
                  <div class="col-md-7">
                  </div>
                 <div class="col-md-5">
                  <div class="panel panel-default">
                        <div class="panel-body">
                             <form action="" method="GET">
                            <div class="input-group datebox">
                             <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                                <input type="text" name="date" class="form-control simple-datepicker" placeholder="Select Date to  Filter" required="" />
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">
                                    <i class="glyphicon glyphicon-search"></i> SEARCH
                                    </button>
                                </div>
                            </div>
                         </form>
                          
                        </div>
                    </div>
                 </div>
                 </div>
                    <div class="panel panel-default">
                         <div class="panel-heading">Attendance List's <?php if($_GET['date']){ echo "<b class='green'> For ".date('jS   F Y  ', strtotime($_GET['date']))."</b>";} ?>
                        
                        </div>
                        <div class="panel-body">
                           
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                    <th class="text-center">Status</th>
                                    <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                     <th class="text-center" width="100px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                 $filter_date=date('Y-m-d',strtotime($_GET['date']));
                                if($_GET['date']==''){            
                                   $select_attendace="SELECT *,attendance.id as attentdanceId FROM `attendance`  INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id`  ORDER BY `attendance`.`date` DESC";
                                   $result = mysqli_query($connection, $select_attendace);
                                     while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php  echo $row['name'];  ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                                        <td><?php echo date('l', strtotime($row['date'])); ?> </td>
                                        <td class="text-center"><?php    echo date("h:i a",strtotime($row['in_time']));  ?> </td>
                                        <td class="text-center">
                                        <?php   
                                        $out=$row['out_time'];
                                        if($out){ 
                                             echo date("h:i a",strtotime($out)); 
                                            ?> 
                                        <?php }  ?>
                                       
                                        </td>
                                        <td class="text-center">
                                        <?php   
                                        $time = date('H:i:s',strtotime("10 AM")); 
                                        $status=$row['status'];
                                        
                                        $status_sql="SELECT * FROM `attendance_status` WHERE id ='$status'";
                                        $status_result = mysqli_query($connection, $status_sql);
                                        $show_status = mysqli_fetch_assoc($status_result);
                                        $show_status=$show_status['id']; 
                                        if($show_status==1){
                                                 echo "<span class='green'><i class='fa fa-adjust'></i> Present<span>";
                                        }else if($show_status==0 && $row['in_time']!=''){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Present<span>";
                                          }else if($show_status==2){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late<span>";
                                         }else if($show_status==3){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Permitted<span>";
                                         }
                                          else{  
                                        }
                                        
                                          ?></td>
                                        <td><?php  echo $row['incoming_reason'];  ?></td>
                                          <td><?php  echo $row['outgoing_reason'];  ?></td>
                                           <td class="text-center">
                                           <?php
                                           //if($status==0 && $row['in_time']!=''){ 
                                            if($row['in_time']!=''){ 
                                            ?>
                                    <form action="" method="POST">
                                    <input type="hidden" value="<?php  echo $row['attentdanceId'];  ?>" name="id"  />
                                    <button type="submit" class="btn btn-success btn-xs" name="approve_btn"><i class="fa fa-check"></i></button>
                                     <button type="submit" class="btn btn-danger btn-xs" name="reject_btn"><i class="fa fa-times"></i></button>
                                    
                                    </form>
                                    <?php } ?>
                                </td>
                                    </tr>
                                <?php
                                } }else{ 
                                   $select_attendace="SELECT *,attendance.id as attentdanceId FROM `attendance`  INNER JOIN `users` ON `attendance`.`emp_id`=`users`.`id`  WHERE `attendance`.date='$filter_date' ";
                                   $result = mysqli_query($connection, $select_attendace);
                                     while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php  echo $row['name'];  ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                                        <td><?php echo date('l', strtotime($row['date'])); ?> </td>
                                        <td class="text-center"><?php    echo date("h:i a",strtotime($row['in_time']));  ?> </td>
                                        <td class="text-center">
                                        <?php   
                                        $out=$row['out_time'];
                                        if($out){ 
                                             echo date("h:i a",strtotime($out)); 
                                            ?> 
                                        <?php }  ?>
                                       
                                        </td>
                                        <td class="text-center">
                                        <?php   
                                        $time = date('H:i:s',strtotime("10 AM")); 
                                        $status=$row['status'];
                                        
                                        $status_sql="SELECT * FROM `attendance_status` WHERE id ='$status'";
                                        $status_result = mysqli_query($connection, $status_sql);
                                        $show_status = mysqli_fetch_assoc($status_result);
                                        $show_status=$show_status['id']; 
                                        if($show_status==1){
                                                 echo "<span class='green'><i class='fa fa-adjust'></i> Present<span>";
                                        }else if($show_status==0 && $row['in_time']!=''){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Present<span>";
                                          }else if($show_status==2){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late<span>";
                                         }else if($show_status==3){
                                              echo "<span class='orange'><i class='fa fa-adjust'></i> Late Permitted<span>";
                                         }
                                          else{  
                                        }
                                        
                                          ?></td>
                                        <td><?php  echo $row['incoming_reason'];  ?></td>
                                          <td><?php  echo $row['outgoing_reason'];  ?></td>
                                           <td class="text-center">
                                           <?php
                                           //if($status==0 && $row['in_time']!=''){ 
                                            if($row['in_time']!=''){ 
                                            ?>
                                    <form action="" method="POST">
                                    <input type="hidden" value="<?php  echo $row['attentdanceId'];  ?>" name="id"  />
                                    <button type="submit" class="btn btn-success btn-xs" name="approve_btn"><i class="fa fa-check"></i></button>
                                     <button type="submit" class="btn btn-danger btn-xs" name="reject_btn"><i class="fa fa-times"></i></button>
                                    
                                    </form>
                                    <?php } ?>
                                </td>
                                    </tr>
                                    
                               <?php }} ?>
                              
                                </tbody>
                                <tfoot>
                                <tr>
                                   <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">IN Time</th>
                                    <th class="text-center">OUT Time</th>
                                    <th class="text-center">Status</th>
                                   <th>Incoming Reason</th>
                                    <th>Outgoing Reason</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                          
                        </div>
                    </div>
                      <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<?php
include_once '../inc/footer.php';
?>
</body>
</html>
