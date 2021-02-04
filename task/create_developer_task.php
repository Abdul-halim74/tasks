<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid = $_SESSION['user_id'];

if (isset($_POST['task_manager'])) {
    extract($_REQUEST);
  //  var_dump($_REQUEST);

    $team_members = implode(",", $_REQUEST[team_member]);
    $assign_date= date("Y-m-d h:i:s", strtotime($assign_date));
    $delivery_date= date("Y-m-d h:i:s", strtotime($delivery_date));
    $status=1;
    if(strlen($amount)>0){
        $amount=$amount;
    }else{
        $amount=0;
    }
if($_POST[team_member]){
$dep_id='';	
foreach ($department_id as $key => $value) {
 	$dep_id=$dep_id.$value.",";
 }
 $department_id1=rtrim($dep_id,',');
 
        $sql = "INSERT INTO `developer_tasks`(`title`,`task_manager`,`department_id`, `assignment`, `status`, `team_member`,  `assign_date`, `delivery_date`,`user_updated_date`,`remarks`,`amount`,`priority`,`created_user`) VALUES 
  ('$title','$task_manager','$department_id1','$assignment','$status','$team_members','$assign_date','$delivery_date',NULL,'','$amount','$priority','$userid')";

}else{

$dep_id='';	
foreach ($department_id as $key => $value) {
 	$dep_id=$dep_id.$value.",";
 }
 $department_id1=rtrim($dep_id,',');

     $sql = "INSERT INTO `developer_tasks`(`title`,`task_manager`,`department_id`, `assignment`, `status`, `assign_date`, `delivery_date`,`user_updated_date`,`remarks`,`amount`,`priority`,`created_user`) VALUES 
  ('$title','$task_manager','$department_id1','$assignment','$status','$assign_date','$delivery_date',NULL,'','$amount','$priority','$userid')";
}

// print $sql;
// exit();
 
    $result = mysqli_query($connection, $sql);
    if ($result == 1) {
        $_SESSION['result'] = '
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Task </strong>   Added Successfully.
        </div>
        ';
        echo "<script>window.location.href='create_developer_task.php';</script>";
        exit();

    } else {
        $_SESSION['result'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check All Fields.
        </div>
          
        ';
          echo "<script>window.location.href='create_developer_task.php';</script>";
  
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
            echo $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Add New Task</div>
                <div class="panel-body">
                    <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                          enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Task Title <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="title" required="">
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Department Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="department_id[]" class="form-control team" id="department_id" multiple required="required">
                                            
                                            <?php
                                            $department_id= $_SESSION['department_id'];
                                            $sql_dept = "SELECT * FROM `departments` WHERE id in ($department_id)";
                                            $result_dept = mysqli_query($connection, $sql_dept);
                                            while ($dept = mysqli_fetch_assoc($result_dept)) {
                                                ?>
                                                <option value="<?php echo $dept['id']; ?>"><?php echo $dept['department_name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Task Manager Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="task_manager" class="form-control" id="users" required="required">
                                            <option>Select Manager</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Team Member</label>
                                    <div class="col-md-12">
                                        <select name="team_member[]" class="form-control team" id="team_member"  multiple="" required="required">


                                        </select>
                                    </div>
                                </div><!--END-->

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Assign Date <b class="red">*</b></label>
                                    <div class="col-md-12">
                                    <?php if($_SESSION['employee_role']==1){ ?>
                                    <input type="text" class="form-control datepicker"   name="assign_date"  value="<?php echo date('d-m-Y') ?>"  required="" />
                                       
                                    <?php }else{?>
                                          <?php echo date('jS   F Y ');  ?>
                                        <input type="hidden" class="form-control"   name="assign_date"  value="<?php echo date('d-m-Y') ?>"  required="" />
                                        <?php } ?>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Tentative  Delivery Date <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control datepicker" name="delivery_date"  value="<?php echo date('d-m-Y') ?>"  required="">
                                        <small> Day-Month-Year</small>
                                    </div>
                                </div><!--END-->
                              
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Amount (Optional)</label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="amount"  />
                                         
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Priority <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="priority" required="required">
                                        <option value="3">Low</option> 
                                       <option value="1">High</option>
                                        <option value="2">Medium</option>
                                        
                                       </select>
                                         
                                    </div>
                                </div><!--END-->
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label">Assignment Detail <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <textarea class="form-control summernote" name="assignment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-center">

                            <div class="col-md-12">
                                <button type="submit" class="btn  btn-info" name="add_task">
                                    &nbsp;&nbsp;&nbsp;<i class="fa fa-floppy-o" aria-hidden="true"></i> Save&nbsp;&nbsp;&nbsp;
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>

        </script>
    </div>
</div>

</div>


<?php
include_once '../inc/footer.php';
?>
<script>
    $(document).ready(function () {
        $("#department_id").change(function (e) {
            $("#users").empty();

            var deptID = $(this).val();
             //console.log(deptID);
            $.ajax({
                type: 'POST',
                url: 'ajax-find-users.php',
                data: {id: deptID},
                success: function (response) {
                   console.log(response);
                    var data = JSON.parse(response);
                    var len = data.length;
                    //console.log(len)
                    for(var i=0; i<len; i++){
                         var tr_str ="<option value="+ data[i].id +">" + data[i].name + "</option>";
                        $("#users").append(tr_str);
                    }
                },
            });
            $("#team_member").empty();
            // $.ajax({
            //     type: 'POST',
            //     url: 'ajax-find-only-users.php',
            //     data: {id: deptID},
            //     success: function (response) {
            //         //console.log(response);
            //         var data = JSON.parse(response);
            //         var len = data.length;
            //       // console.log(len)
            //         for(var i=0; i<len; i++){
            //             var users ="<option value="+ data[i].id +">" + data[i].name + "</option>";
            //             $("#team_member").append(users);
            //         }
            //     },
            // });
        });

        $("#users").change(function (e) {
            $("#team_member").empty();
            var user_id = $(this).val();
            var department_id = $("#department_id").val();
            $.ajax({
                type: 'POST',
                url: 'ajax-find-team-members.php',
                data: {user_id:user_id,department_id: department_id},
                success: function (response) {
                    //console.log(response);
                    var data = JSON.parse(response);
                    var len = data.length;
                    console.log(len)
                    for(var i=0; i<len; i++){
                        var tr_str ="<option value="+ data[i].id +">" + data[i].name + "</option>";
                        $("#team_member").append(tr_str);
                    }
                },
            });
        });
    });
</script>
</body>
</html>
