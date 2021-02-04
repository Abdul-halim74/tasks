<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];

if (isset($_POST['add_bill'])) {
    extract($_REQUEST);
    //for  convert date
    $final_target_date = date("Y-m-d", strtotime($target_date));
    $assigned_person_list = implode (",",$_REQUEST[assigned_person]);

   $sql ="INSERT INTO `bills`(`project_name`,`receivable_amount`, `target_date`, `assigned_person`,`created_user`) VALUES 
  ('$project_name','$receivable_amount','$final_target_date','$assigned_person_list','$userid')";
 
    $result = mysqli_query($connection,$sql);
    if($result==1){
        $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Bill </strong>   Added Successfully.
        </div>
        ';
           echo "<script>window.location.href='create_bill.php';</script>";
        exit();

    }
    else{
        $_SESSION['result'] ='
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
          
        ';
        echo "<script>window.location.href='create_bill.php';</script>";
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
                    <div class="panel-heading">Add New Bill</div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Project Name <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="project_name" required="">
                                            <small id="emailHelp" class="form-text text-muted">Note: Project Name need to  be  Unique.</small>
                                        </div>
                                    </div><!--END-->
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Receivable  Amount TK. <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="receivable_amount" required="">
                                        </div>
                                    </div><!--END-->
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Target Date <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control datepicker" value="<?php echo date('d-m-Y') ?>"  name="target_date" required="">
                                       <small> Day-Month-Year</small>
                                        </div>
                                    </div><!--END-->

                                    <div class="form-group row">
                                        <label for="name" class="col-md-12 col-form-label ">Assigned Person <i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <select name="assigned_person[]" style="height: 120px"  class="form-control text-capitalize" multiple required="">
                                                <?php
                                                $sql = "SELECT * FROM `users`";
                                                $result = mysqli_query($connection,$sql);
                                                while($list=mysqli_fetch_assoc($result)){?>
                                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
                                                <?php  }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row mb-0 ">
                              <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn  btn-info" name="add_bill">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;  Add Bill &nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                    <div class="panel panel-default bill-collection">
                        <div class="panel-heading">Created Bill List Last (10)</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Amount</th>
                                    <th>Target Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $bill_sql="SELECT * FROM `bills`  ORDER BY `id` DESC LIMIT 10";

                                    $bill_query=mysqli_query($connection,$bill_sql);
                                    
                                    while ($data=mysqli_fetch_array($bill_query)) {
                                      

                                      ?>
                                   
                                    
                                <tr>
                                    <td><a href="bill_details.php?project_id=<?php echo $data['id']; ?>"><?php echo $data['project_name']; ?></a></td>
                                    <td><b class="green"> &#2547; <?php echo formatInBDTStyle($data['receivable_amount']); ?></b></td>
                                    <td><?php  echo date('jS   F Y  ', strtotime($data['target_date'])); ?></td>
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
