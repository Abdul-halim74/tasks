<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];

 $get_id = $_GET['id'];

 $select_sql = "SELECT * FROM `holiday_office` where id='$get_id' ";
$select_q = mysqli_query($connection, $select_sql);
$select_f = mysqli_fetch_array($select_q);


 $date = $select_f['date'];
  $ho_emp_id = $select_f['emp_id'];


  if (isset($_POST['submit'])) {
  		$select_emp = $_POST['select_emp'];
  		$date = $_POST['date'];

  		$update_sql ="UPDATE `holiday_office` set emp_id = '$select_emp', `date`='$date' where id='$get_id' ";
  		$update_q = mysqli_query($connection, $update_sql);

  		if ($update_q==1) {
  			 $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Updated Successfully.
        </div>
        ';

            echo "<script>window.location.href='holiday_office.php';</script>";
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
                    <div class="panel-heading">Holiday Office </div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                  
                                     <div class="form-group row">
                                     	<input type="hidden" name="edit_id" value="<?php echo $edit_id;  ?>">
                                          <label for="" class="col-sm-12 form-control-label">Employee Name <i class="red">*</i></label>

                                          <div class="col-sm-12">
                                            <select  class="form-control selectpicker" id="select_emp" name="select_emp" data-live-search="true" required="">

                                           

                                            <?php  

                                            	
                                                $select_emp = "SELECT * FROM `users` ";
                                                $select_q = mysqli_query($connection, $select_emp);

                                                $emp_f = mysqli_fetch_array($select_q);
                                                while ($emp_f = mysqli_fetch_array($select_q)) {

                                                    ?>

                                                     <option  
                                                        value="<?php echo $emp_f['id']; ?>" <?php
                                                        if ($emp_f['id']== $ho_emp_id) {
                                                        	echo "selected";
                                                        }
                                                       
                                                        ?> ><?php echo $emp_f['name']; ?></option>

                                                    <?php


                                                }

                                             ?>
                                             
                                            </select>

                                          </div>

                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Date <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control datepicker_open_off_edit" value="<?php echo $date; ?>"  name="date" required="">
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
