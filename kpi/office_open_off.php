<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];

if (isset($_POST['submit'])) {

  $pradio = $_POST['pradio'];

  $mradio = $_POST['mradio'];
  $date = $_POST['date'];

  $select_this_date_exist_data = "SELECT * FROM `offce_open_off` where `date`='$date'";

  $exist_data_q = mysqli_query($connection, $select_this_date_exist_data);

  if (mysqli_num_rows($exist_data_q)>0) {
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>This Date Data  Already Exist !.</strong>  
        </div>
        ';

           echo "<script>window.location.href='office_open_off.php';</script>";
        exit();
  }

   $insert_sql = "INSERT INTO `offce_open_off` SET `programmer`= '$pradio', `marketting`='$mradio', 
  `date`='$date', `entry_usr`= '$userid', `entry_time` =CURTIME() ";

  $insert_q = mysqli_query($connection, $insert_sql);

  if ($insert_q==1) {

            $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Added Successfully.
        </div>
        ';

           echo "<script>window.location.href='office_open_off.php';</script>";
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
                    <div class="panel-heading">Office Open / Off Status </div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Programmars <i class="red">*</i></label>

                                        <label class="radio-inline" style="margin-left: 13px;">
                                          <input style="margin-top: -7px;" type="radio" name="pradio" checked value="1">Open
                                        </label>
                                        <label class="radio-inline">
                                          <input style="margin-top: -7px;" type="radio" name="pradio" value="0">Off
                                        </label>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Marketting <i class="red">*</i></label>

                                        <label class="radio-inline" style="margin-left: 13px;">
                                          <input style="margin-top: -7px;" type="radio" name="mradio" checked value="1">Open
                                        </label>
                                        <label class="radio-inline">
                                          <input style="margin-top: -7px;" type="radio" name="mradio" value="0">Off
                                        </label>
                                        
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
                        <div class="panel-heading">Office Open / Off Status List Last (10)</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Programmers</th>
                                    <th>Marketting</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $offce_open_off_sql="SELECT * FROM `offce_open_off`  ORDER BY `id` DESC LIMIT 10";

                                    $offce_open_off_query=mysqli_query($connection,$offce_open_off_sql);
                                    
                                    while ($data=mysqli_fetch_array($offce_open_off_query)) {
                                      

                                      ?>
                                   
                                    
                                <tr>
                                    <td><?php  echo $data['date']; ?></td>

                                    <td><?php   $data['programmer'];

                                        if ($data['programmer']==1) {
                                           echo "Open";
                                        }elseif($data['programmer']==0){
                                            echo "Off";
                                        }

                                     ?></td>
                                    <td><?php   $data['marketting'];
                                         if ($data['marketting']==1) {

                                           echo "Open";
                                        }elseif($data['marketting']==0){
                                            echo "Off";
                                        }

                                     ?></td>
                                     
                                    <td><a href="<?php echo $global_url; ?>/kpi/edit_office_off.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Edit</a></td>

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
