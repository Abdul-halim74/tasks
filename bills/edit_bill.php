<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];
$edit_id=$_GET['edit_id'];

 $edit_bills_sql="SELECT * FROM `bills` WHERE id = '$edit_id' ";

$edit_bills_query=mysqli_query($connection,$edit_bills_sql);
$edit_bills_fetch=mysqli_fetch_array($edit_bills_query);



if (isset($_POST['add_bill'])) {
    extract($_REQUEST);

    //for  convert date
    $final_target_date = date("Y-m-d", strtotime($target_date));
    $assigned_person_list = implode (",",$_REQUEST[assigned_person]);

  $sql ="UPDATE  `bills` SET `project_name`='$project_name', `receivable_amount`='$receivable_amount', `target_date`='$final_target_date', `assigned_person`='$assigned_person_list' WHERE id='$edit_id' ";

    $result = mysqli_query($connection,$sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Bill </strong>   Updated Successfully.
        </div>
        ';
          echo "<script>window.location.href='edit_bill.php?edit_id=$edit_id';</script>";
        exit();

    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
          
        ';
        echo "<script>window.location.href='edit_bill.php?edit_id=$edit_id';</script>";
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
                    <div class="panel-heading">Update Bill Information</div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Project Name <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="project_name" required="" value="<?php echo $edit_bills_fetch['project_name']; ?>">
                                        </div>
                                    </div><!--END-->
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Receivable  Amount  <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="receivable_amount" required="" value="<?php echo $edit_bills_fetch['receivable_amount'];  ?>">
                                        </div>
                                    </div><!--END-->
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Target Date  <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control datepicker" value="<?php echo $edit_bills_fetch['target_date'];  ?>"  name="target_date" required="">
                                       <small> Day-Month-Year</small>
                                        </div>
                                    </div><!--END-->

                                    <div class="form-group row">
                                        <label for="name" class="col-md-12 col-form-label ">Assigned Person  <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <select name="assigned_person[]" style="height: 120px" multiple class="form-control text-capitalize">
                                                <?php
                                                $array = explode(',', $edit_bills_fetch['assigned_person']);
                                                // $sql_company = "SELECT * FROM bills";
                                                // $company_query = mysqli_query($connection, $sql_company);

                                                $sql = "SELECT * FROM `users`";
                                                $result = mysqli_query($connection,$sql);
                                                while($list=mysqli_fetch_assoc($result)){?>
                                                    <option value="<?php echo $list['id']; ?>" <?php if(in_array($list['id'], $array)){echo 'selected';} ?> ><?php echo $list['name']; ?></option>
                                                <?php  }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row mb-0 text-center">
                              <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn  btn-info" name="add_bill">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-floppy-o" aria-hidden="true"></i>  Update Bill &nbsp;&nbsp;&nbsp;
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
</body>
</html>
