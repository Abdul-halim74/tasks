<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];

$time=date('H:i:s');
 
$date = date("Y-m-d");

//FIND  IP ADDRESSS
if (!empty($_SERVER["HTTP_CLIENT_IP"]))
{
 //check for ip from share internet
 $ip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
 // Check for the Proxy User
 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
 $ip = $_SERVER["REMOTE_ADDR"];
}
 //echo $ip;
$get_ip_query=mysqli_query($connection,"SELECT `ip_address` FROM `ip_address` WHERE 1");  
$ip_data = mysqli_fetch_assoc($get_ip_query);
$ip_Array = explode(',', $ip_data['ip_address']);
 
if (isset($_POST['give_attendance'])) {
    if(in_array($ip, $ip_Array)){
    extract($_REQUEST);
   $give_attendance_sql="INSERT INTO `attendance` SET `emp_id`='$userid',`date`='$date',`in_time`='$time',`status`=1 ";
  $result = mysqli_query($connection,$give_attendance_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Attendance </strong>   taken Successfully.
        </div>
        ';
        echo "<script>window.location.href='attendance.php';</script>";
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
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
    }
}else{
     $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
}
}


//late attendance start
if (isset($_POST['late_attandance'])) {
      if(in_array($ip, $ip_Array)){
    extract($_REQUEST);
    $late_attendance_sql="INSERT INTO `attendance` SET `emp_id`='$userid',`date`='$date',`in_time`='$time',
 `status`=0, `incoming_reason`='$incoming_reason'";
 
    $result = mysqli_query($connection,$late_attendance_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Late Attendance </strong>   take Successfully.
        </div>
        ';
          echo "<script>window.location.href='attendance.php';</script>";
        exit();

    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
    }
}else{
     $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
}
}



//Today  leave  query

if (isset($_POST['leave_today_btn'])) {
      if(in_array($ip, $ip_Array)){
    extract($_REQUEST);

    $leave_sql="INSERT INTO `leaves` SET `emp_id`='$userid',`date_start`='$date',`date_end`='$date',`total_days`=1,`leave_reason`='$leave_reason',`status`=0";
 
  $result = mysqli_query($connection,$leave_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Leave  </strong>  Request Send Successfully.
        </div>
        ';
        echo "<script>window.location.href='attendance.php';</script>";
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
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
    }
     }else{
         $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
     }
}


//out attendance  sql

if (isset($_POST['btn_out_attendance'])) {
      if(in_array($ip, $ip_Array)){
    extract($_REQUEST);
    
    $leave_sql="UPDATE `attendance` SET  `out_time`='$time' WHERE `emp_id`='$userid' AND `date`='$date'";
  $result = mysqli_query($connection,$leave_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
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
    }else{
         $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
    }
}

if (isset($_POST['out_before_time_btn'])) {
       if(in_array($ip, $ip_Array)){
    extract($_REQUEST);
    
   $leave_sql="UPDATE `attendance` SET `out_time`='$time', `outgoing_reason`='$outgoing_reason' WHERE `emp_id`='$userid' AND `date`='$date'";
 
  $result = mysqli_query($connection,$leave_sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
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
    else{
         $_SESSION['result'] ='
        <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
          
        ';
         echo "<script>window.location.href='attendance.php';</script>";
        exit();
    }
}
 

?>
<body>

<div id="app" class="app">
    <?php include_once  '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid">
        <div class="container-fluid">
            <?php
            echo  $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
            <div class="row">
              <div class="modal fade" id="out_before_time" role="dialog"> 
            <form action="" method="post">
                                <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Reason to  Out  before office time</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Current time</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" value="<?php echo date('h:i A'); ?>" readonly="">
                                        </div>
                                    </div><!--END-->
                                          <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Reason to Out<font size="3pt" color="red"> (Please write reason(s) for early out)</font></label>
                                        <div class="col-md-12">
                                            <textarea name="outgoing_reason" class="form-control summernote-sm" required="required"></textarea>
                                        </div>
                                    </div><!--END-->

                                   
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn  btn-info" name="out_before_time_btn">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-floppy-o" aria-hidden="true"></i>  submit &nbsp;&nbsp;&nbsp;
                                    </button>
                                
                                    </div>
                                  </div>
                                  
                                </div>
                                  </form>
                                  </div>
                                  
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
            <div class="col-md-6 col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-right"><span class="pull-left text-left">Give Attendance</span> <span class="text-right"> <i class="fa fa-clock-o" aria-hidden="true"></i></span> <?php  echo date('jS   F Y  h:i A'); ?></div>
                    <div class="panel-body">
                    <?php  if(in_array($ip, $ip_Array)){ ?>
                            <div class="row">
                            
                            <div class="modal fade text-center" id="take_attendance" role="dialog"> 
                                <div class="modal-dialog" style="width:440px;">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h5 class="modal-title">Are You sure to give  Attendance Today</h5>
                                    </div>
                                    <div class="modal-body">
                                    
                                        <form method="post" action="">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;&nbsp;
                                                <button type="submit" class="btn  btn-success" name="give_attendance">
                                            &nbsp;&nbsp;&nbsp; <i class="fa fa-sign-in" aria-hidden="true"></i>     OK &nbsp;&nbsp;&nbsp;
                                        </button>
                                        <br /><br /> 
                                    </form>
                                    </div><!--END-->
                                         
                                    </div>
                                    
                                  </div>
                                  
                                </div>
                                  <!-- Modal -->                                
                                                                
                              <!-- Modal -->
                              <div class="modal fade" id="late_attendance" role="dialog">
                                  <form action="" method="post">
                                <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Late Attendance Reason</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Current time</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" value="<?php echo date('h:i A'); ?>" readonly="">
                                        </div>
                                    </div><!--END-->
                                          <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Incoming Reason <font size="3pt" color="red"> (Please write reason(s) for late)</font></label>
                                        <div class="col-md-12">
                                            <textarea name="incoming_reason" class="form-control summernote-sm" required></textarea>
                                        </div>
                                    </div><!--END-->

                                   
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn  btn-info" name="late_attandance">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-floppy-o" aria-hidden="true"></i>  submit &nbsp;&nbsp;&nbsp;
                                    </button>
                                
                                    </div>
                                  </div>
                                  
                                </div>
                                  </form>
                              </div>
                                                            
                            <div class="form-group row mb-0 text-center">
                              <br/>
                                <div class="col-md-12">
                                
                                <?php
                                  //In time  for  office
                                  $time = date('H:i:s',strtotime("10 AM"));
                                  
                                  //check  if  user  took attendance  or  not
                                   $check_today_attendance = "SELECT * FROM `attendance` WHERE emp_id=$userid AND date='$date'";
                                    $entry_checking = mysqli_query($connection, $check_today_attendance);
                                      $fetchrow = mysqli_num_rows($entry_checking);
                                     $attendance_fields = mysqli_fetch_assoc($entry_checking);
                                     if($fetchrow==1){
                                ?>
                                 <?php  if($fetchrow!=0 && $attendance_fields['out_time']==''){ ?>
                                 <?php
                                   $out_time = date('H:i:s',strtotime("7 PM"));
                                 

                                 if(date('H:i:s')>$out_time){
                                  ?>
                                  <button  data-toggle="modal" data-target="#out_attendance" class="btn btn-success btn-sm">OUT FOR TODAY</button>
                                 <?php }else{ ?>
                                 
                                 <button  data-toggle="modal" data-target="#out_before_time" class="btn btn-success btn-sm">OUT  FOR TODAY</button>
                               
                                    <?php } }else{ echo "<button    class='btn btn-warning disabled' >YOU ARE   OUT NOW</button>"; }  ?>
                                 
                                <?php }else{ ?>
                                 
                                <?php  if(date('H:i:s') <= $time){ ?>
                                
                                 <button type="submit" class="btn  btn-success" data-toggle="modal" data-target="#take_attendance" >
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-sign-in" aria-hidden="true"></i> Give Today Attendance &nbsp;&nbsp;&nbsp;
                                    </button>
                                 
                                     <?php }else{?>
                                     <button type="button" class="btn  btn-warning" data-toggle="modal" data-target="#late_attendance" >
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-sign-in" aria-hidden="true"></i> Today Late Attendance &nbsp;&nbsp;&nbsp;
                                    </button>
                                       <?php }?>
                                        
                                <?php }?>
                              
                                     
                                </div>
                            </div>
                    </div>
                    <?php }else{ ?>
                    <br />
               <div class="alert alert-warning fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        This Network IP address is not  valid Please Go to right Network.
        </div>
                    <?php } ?>
                </div>
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