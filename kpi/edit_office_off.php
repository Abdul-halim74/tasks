<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];


$edit_id = $_GET['id'];

$select_sql = "SELECT *  FROM `offce_open_off` where id = '$edit_id' ";
$select_q = mysqli_query($connection, $select_sql);
$select_f = mysqli_fetch_array($select_q);

$programmer =  $select_f['programmer'];
 $marketting =  $select_f['marketting'];
$date =  $select_f['date'];


if (isset($_POST['submit'])) {
    $pradio = $_POST['pradio'];
    $mradio = $_POST['mradio'];
    $date = $_POST['date'];

    $update_sql = "update offce_open_off set programmer = '$pradio', marketting = '$mradio', `date`='$date' where id = '$edit_id' ";
    $update_q = mysqli_query($connection, $update_sql);

    if ($update_q==1) {
        
            $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Updated Successfully.
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
                    <div class="panel-heading">Edit Office Open / Off Status </div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                  <input type="hidden" name="id" value="<?php   ?>">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Programmars <i class="red">*</i></label>

                                        <label class="radio-inline" style="margin-left: 13px;">
                                          <input style="margin-top: -7px;" type="radio" name="pradio"
                                          <?php 
                                            if($programmer==1){
                                              echo "checked";
                                            }
                                           ?>
                                            value="1">Open
                                        </label>
                                        <label class="radio-inline">
                                          <input style="margin-top: -7px;" type="radio" name="pradio" value="0"
                                           <?php 
                                            if($programmer==0){
                                              echo "checked";
                                            }
                                           ?>
                                          >Off
                                        </label>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Marketting <i class="red">*</i></label>

                                        <label class="radio-inline" style="margin-left: 13px;">
                                          <input style="margin-top: -7px;" type="radio" name="mradio" 
                                            <?php 
                                            if($marketting==1){
                                              echo "checked";
                                            }
                                           ?>
                                           value="1">Open
                                        </label>
                                        <label class="radio-inline">
                                          <input style="margin-top: -7px;" type="radio" name="mradio" 

                                           <?php 
                                            if($marketting==0){
                                              echo "checked";
                                            }
                                           ?>

                                          value="0">Off
                                        </label>
                                        
                                    </div>

                                   
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Date <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control datepicker_open_off_edit" value="<?php echo  $date; ?>"  name="date" required="">
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
            
            </div>
        </div>
    </div>
</div>

</div>
<?php
include_once '../inc/footer.php';
?>


<script type="text/javascript">
  
    

     $('.datepicker_open_off_edit').datepicker({
        format: "yyyy-m-d"
        
    });


</script>

</body>
</html>
