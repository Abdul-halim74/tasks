<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];



if (isset($_POST['submit'])) {

    $date = $_POST['date'];

 


  $select_emp = $_POST['select_emp'];

  // echo "<pre>";
  // print_r($select_emp);die;



  
foreach ($select_emp as $key => $value) {

  $select_emp = $value;

   $select_this_date_exist_data = "SELECT * FROM `attendance` where `date`='$date' and emp_id = '$select_emp' ";

  $exist_data_q = mysqli_query($connection, $select_this_date_exist_data);

  if (mysqli_num_rows($exist_data_q)>0) {
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>This Employee of this Date Data  Already Exist !.</strong>  
        </div>
        ';

           echo "<script>window.location.href='on_duty.php';</script>";
        exit();
  }

   $insert_sql = "INSERT INTO `attendance` SET `emp_id`= '$select_emp', 
  `date`='$date', `in_time`='10:00:00', `out_time`='19:00:00', `status`='1', `total_overtime`='9', 
  `on_duty_status`='1' ";

  $insert_q = mysqli_query($connection, $insert_sql);

}
  if ($insert_q==1) {

            $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Added Successfully.
        </div>
        ';

           echo "<script>window.location.href='on_duty.php';</script>";
        exit();
  }
}


if (isset($_GET['del_id'])) {
  $del_id = $_GET['del_id'];
  $del_q = mysqli_query($connection, "DELETE FROM attendance WHERE id='$del_id'");
  if($del_q==1) {
       $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Delete Successfully.
        </div>
        ';

        echo "<script>window.location.href='on_duty.php';</script>";
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
          
            <div class="row">
            <div class="col-md-6 col-lg-6">
              <?php
            echo  $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">On duty </div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">


                                     <div class="form-group row">

                                          <label for="" class="col-sm-12 form-control-label">Employee Name <i class="red">*</i></label>

                                          <div class="col-sm-12">

                                            <select class="form-control selectpicker" multiple data-live-search="true" name="select_emp[]">

                                              <?php  

                                                $select_emp = "SELECT * FROM `users` WHERE id not in(1,7,11,12,14,15,16,17,18,24,25,27,29,31,36,43,48,63)";
                                                $select_q = mysqli_query($connection, $select_emp);

                                                // $emp_f = mysqli_fetch_array($select_q);
                                                while ($emp_f = mysqli_fetch_array($select_q)) {
                                                    ?>

                                                     <option  
                                                        value="<?php echo $emp_f['id']; ?>" ><?php echo $emp_f['name']; ?></option>

                                                    <?php


                                                }

                                             ?>

                                             
                                            </select>


                                            

                                          </div>

                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Date <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control datepicker_open_off" value="<?php echo date('Y-m-d') ?>"  name="date" required="">
                                       <small> Day-Month-Year</small>
                                        </div>
                                    </div><!--END-->

                                    
                                </div>

                            </div>
                            <div class="form-group row mb-0 ">
                              <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn  btn-info" name="submit">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp; Submit &nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                    <div class="panel panel-default bill-collection">
                        <div class="panel-heading">On Duty Office Employees List Last (10)</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Employee Name</th>
                                    
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $on_duty_sql = "SELECT att.id, att.date, usr.name FROM `attendance` att left join users usr on att.emp_id = usr.id where on_duty_status='1' LIMIT 10";

                                    $on_duty_query=mysqli_query($connection,$on_duty_sql);
                                    
                                    while ($data=mysqli_fetch_array($on_duty_query)) {
                                      

                                      ?>
                                   
                                    
                                <tr>
                                    <td><?php  echo $data['date']; ?></td>

                                    <td><?php  echo $data['name']; ?></td>

                                   
                                    <td><a href="<?php echo $global_url; ?>/kpi/edit_on_duty_office.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Edit</a> | <a href="<?php echo $global_url; ?>/kpi/on_duty.php?del_id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Delete</a></td>
                               
                                </tr>
                                   <?php
                                        }
                                      
                                        ?>

                                </tbody>
                            </table>
                        </div>
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
