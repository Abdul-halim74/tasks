<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid= $_SESSION['user_id'];

 $edit_id = $_GET['edit_task_id'];


//echo "<script>alert('$edit_id');</script>";die;
$curr_time=date('h:i:s');
if (isset($_POST['submit'])) {
    extract($_REQUEST);
    $team_member = implode(",", $_REQUEST[team_member]);

    $department_id = implode(",", $_REQUEST[department_id]);
    $assign_date= date("Y-m-d ", strtotime($assign_date)). $curr_time;
    $delivery_date= date("Y-m-d ", strtotime($delivery_date)). $curr_time;

     $assignment_f = mysqli_real_escape_string($connection, $assignment);

      $edit_sqls="SELECT *,dev_task.department_id as dev_task_department  FROM `developer_tasks` `dev_task` inner join `departments` `dept` on `dev_task`.department_id =`dept`.id inner join `users` `usr` on `dev_task`.task_manager = `usr`.id inner join `project_status` `status` on `dev_task`.`status`=`status`.`id` WHERE `dev_task`.id='$edit_id'" ;
            $queries=mysqli_query($connection, $edit_sqls);
            $fetchs=mysqli_fetch_array($queries);

           $late_completed_status = $fetchs['late_completed_status']+1;


   $update_sql = "UPDATE `developer_tasks` SET `title`='$title' , `department_id`='$department_id',`task_manager`='$task_manager', 
    `team_member`='$team_member', `assign_date` ='$assign_date', `delivery_date`= '$delivery_date', `amount`='$amount', `priority`='$priority', `assignment`='$assignment_f', 
    late_completed_status ='$late_completed_status'  WHERE `id`='$edit_id' ";

    $insert_sql ="INSERT INTO `tentative_delivery_log` SET `task_id`='$edit_id', task_title='$title', task_manager='$task_manager', `assign_date`='$assign_date',`tentative_delivery_date`='$delivery_date',`tentative_delivery_update_date`=now(), `entry_usr`='$userid'";

    $update_result = mysqli_query($connection, $update_sql);
    $insert_result = mysqli_query($connection, $insert_sql);
    
    if ($update_result == 1) {
        $_SESSION['result'] = '
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Task </strong>   Updated Successfully.
        </div>
        ';
            echo "<script>window.location.href='edit_task.php?edit_task_id=$edit_id';</script>";
        //header('location:edit_task.php?edit_task_id='.$edit_id);
        exit();
    } else {
        $_SESSION['result'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check number Need to be unique.
        </div>
          
        ';
         echo "<script>window.location.href='edit_task.php?edit_task_id=$edit_id';</script>";
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
            <?php

            $edit_sqls="SELECT *,dev_task.department_id as dev_task_department  FROM `developer_tasks` `dev_task` inner join `departments` `dept` on `dev_task`.department_id =`dept`.id inner join `users` `usr` on `dev_task`.task_manager = `usr`.id inner join `project_status` `status` on `dev_task`.`status`=`status`.`id` WHERE `dev_task`.id='$edit_id'" ;
            $queries=mysqli_query($connection, $edit_sqls);
            $fetchs=mysqli_fetch_array($queries);
             

              
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Edit Task</div>
                <div class="panel-body">
                    <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Task Title</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="title"  value="<?php echo $fetchs['title']; ?>">
                                    </div>
                                </div><!--END-->
                                 <?php if($_SESSION['employee_role']==1){ ?>
                                <!--SUPER ADMIN USER FORM --->
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Department Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="department_id[]" class="form-control" id="department_id" name="multiple[]" multiple="" style="height: 80px;">
                                            <option value="">Select Department</option>
                                            <?php
                                            //$department_id= $_SESSION['department_id'];
                                            $sql_dept = "SELECT * FROM `departments`";
                                            $result_dept = mysqli_query($connection, $sql_dept);

                                            $department_id = $fetchs['dev_task_department'];
                                            $department_exp =explode(',', $department_id);

                                            while ($dept = mysqli_fetch_assoc($result_dept)) {
                                                ?>
                                                <option value="<?php echo $dept['id']; ?>" <?php 
                                                if(in_array($dept['id'], $department_exp)){echo "selected";}?> ><?php echo $dept['department_name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Task Manager Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="task_manager" class="form-control" id="users">

                                            <?php

                                         
                                          $dev_task_department=$fetchs['dev_task_department'];
                                           $get_this_department_id = str_replace(',', '|', $dev_task_department);

                                          


                                           $task_manager_sql = "SELECT * FROM `users` where CONCAT(',', department_id, ',') regexp '(^|[|]),|$get_this_department_id,([|]|$)'";
                                                
                                            $task_manager_result = mysqli_query($connection, $task_manager_sql);
                                            while ($task_manager_name = mysqli_fetch_assoc($task_manager_result)) {
                                                ?>
                                                <option <?php if ($task_manager_name['id'] == $fetchs['task_manager']) echo "selected=''"; ?>
                                                        value="<?php echo $task_manager_name['id']; ?>"><?php echo $task_manager_name['name']; ?></option>
                                            <?php }

                                        

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Team Member <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="team_member[]" class="form-control team" id="team_member"  multiple=""  required>
                                            <?php

                                            $dev_task_department=$fetchs['dev_task_department'];
                                           $get_this_department_id = str_replace(',', '|', $dev_task_department);

                                          
                                            $task_manager_sql = "SELECT * FROM `users` where CONCAT(',', department_id, ',') regexp '(^|[|]),|$get_this_department_id,([|]|$)'";
                                                
                                            $task_manager_result = mysqli_query($connection, $task_manager_sql);

                                              $team_member_id = $fetchs['team_member'];

                                              $team_member_id_exp = explode(',', $team_member_id);

                                              $team_member_id_sql = "SELECT * FROM `users` WHERE `id` in ($team_member_id) ";
                                            $team_member_id_result = mysqli_query($connection, $team_member_id_sql);


                                            while ($task_manager_name = mysqli_fetch_assoc($task_manager_result)) {

                                            $team_memeber_list_f = mysqli_fetch_assoc($team_member_id_result);
                                            $team_memeber_list_f['id'];

                                            // echo $team_member_list_id = 35;
                                                $task_manager_id = $task_manager_name['id'];

                                                ?>
                                                <option <?php if (in_array($task_manager_id, $team_member_id_exp)) {
                                                    echo "selected";
                                                } ?>
                                                    
                                                        value="<?php echo $task_manager_name['id']; ?>">

                                                        <?php echo $task_manager_name['name']; ?>
                                                            
                                                        </option>
                                            <?php }


                                            ?>
                                        </select>
                                    </div>
                                </div><!--END-->
                                 <!--END SUPER ADMIN USER FORM --->
                                 <?php } ?>
                                   <?php if($_SESSION['employee_role']==2){ ?>
                                <!-- Admin User FORM DESIGN -->
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Department Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="department_id" class="form-control" id="department_id">
                                            <option value="">Select Department</option>
                                            <?php
                                            $department_id= $_SESSION['department_id'];
                                            $sql_dept = "SELECT * FROM `departments` WHERE id IN($department_id)";
                                            $result_dept = mysqli_query($connection, $sql_dept);
                                            while ($dept = mysqli_fetch_assoc($result_dept)) {
                                                ?>
                                                <option value="<?php echo $dept['id']; ?>" <?php if($dept['id']==$fetchs['department_id']){echo "selected";}?> ><?php echo $dept['department_name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Task Manager Name <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="task_manager" class="form-control" id="users">

                                            <?php
                                          
                                          $task_manager_sql = "SELECT * FROM `users` WHERE `department_id`='$department_id'";
                                                
                                            $task_manager_result = mysqli_query($connection, $task_manager_sql);
                                            while ($task_manager_name = mysqli_fetch_assoc($task_manager_result)) {
                                                ?>
                                                <option <?php if ($task_manager_name['id'] == $fetchs['task_manager']) echo "selected=''"; ?>
                                                        value="<?php echo $task_manager_name['id']; ?>"><?php echo $task_manager_name['name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Team Member <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select name="team_member[]" class="form-control team" id="team_member"  multiple=""  required>
                                            <?php
                                            $team_member_id= explode(',',$fetchs['team_member']); 
                                            $team_member_id_sql = "SELECT * FROM `users` WHERE `department_id`='$department_id' ";
                                            $team_member_id_result = mysqli_query($connection, $team_member_id_sql);
                                            while ($team_memeber_list = mysqli_fetch_assoc($team_member_id_result)) {
                                                if($fetchs['task_manager']!=$team_memeber_list['id']){
                                                ?>
                                                <option <?php if (in_array($team_memeber_list['id'], $team_member_id)) echo "selected=''"; ?>
                                                        value="<?php echo $team_memeber_list['id']; ?>"><?php echo $team_memeber_list['name']; ?></option>
                                            <?php } }
                                            ?>
                                        </select>
                                    </div>
                                </div><!--END-->
                                <!-- END Admin User FORM DESIGN -->
                                 <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Assign Date</label>
                                    <div class="col-md-12">
                                    <?php if($_SESSION['employee_role']==1){ ?>
                                        <input type="text" class="form-control datepicker"   name="assign_date"  value="<?php echo $fetchs['assign_date'] ?>"/>
                                       <?php  }else{?>
                                        <input type="text" class="form-control"   name="assign_date"  value="<?php echo $fetchs['assign_date'] ?>"    readonly="" />
                                         <?php  } ?>
                                        <small> Day-Month-Year</small>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Tentative  Delivery Date <b class="red">*</b></label>
                                    <div class="col-md-12">
                                     <?php if($_SESSION['employee_role']==1){ ?>
                                        <input type="text" class="form-control datepicker" name="delivery_date"  value="<?php echo $fetchs['delivery_date'] ?>"  required=""    />
                                           <?php  }else{?>
                                             <input type="text" class="form-control" name="delivery_date"  value="<?php echo $fetchs['delivery_date'] ?>"  required=""   readonly="" />
                                        <?php  } ?>
                                        <small> Day-Month-Year</small>
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Amount (Optional)</label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" value="<?php echo $fetchs['amount'] ?>"  name="amount" />

                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Priority <b class="red">*</b></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="priority" required>
                                            <option <?php if($fetchs['priority']==3){echo "selected";} ?> value="3">Low</option>
                                            <option <?php if($fetchs['priority']==1){echo "selected";} ?> value="1">High</option>
                                            <option <?php if($fetchs['priority']==2){echo "selected";} ?> value="2">Medium</option>

                                        </select>

                                    </div>
                                </div><!--END-->

                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Assignment Detail</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control summernote" name="assignment">
                                            <?php echo $fetchs['assignment']; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn  btn-info" name="submit">
                                    &nbsp;&nbsp;&nbsp;<i class="fa fa-floppy-o" aria-hidden="true"></i> Update&nbsp;&nbsp;&nbsp;
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
    
</script>
</body>
</html>
