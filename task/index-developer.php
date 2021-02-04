<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
?>
<body>
<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>
<div class="content-area">
    <div class="container-fluid">
        <div class="container-fluid">
            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default pdr30 pdl15">
                        <div class="panel-heading">All Task List's</div>
                        <div class="panel-body" style="overflow-x: scroll;">
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Task&nbsp;Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;Task&nbsp;Manager&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assigned&nbsp;By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Team&nbsp;Member&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Assign&nbsp;Date</th>
                                    <th>T.Delivery&nbsp;Date</th>

                                    <th>Department</th>
                                    <th>Update&nbsp;Date</th>
                                    <?php if($_SESSION['employee_role']==1){?>
                                    <th>Edit </th>
                                      <?php  }?>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $userid= $_SESSION['user_id'];
                                $employee_role=$_SESSION['employee_role'];
                                if($employee_role==1){
                                    $sql_tasks = "SELECT * FROM `developer_tasks` ";
                                }else{
                                    $sql_tasks = "SELECT * FROM `developer_tasks` WHERE task_manager=$userid OR team_member  LIKE '%$userid%' OR created_user=$userid";
                                }
                                $result1 = mysqli_query($connection, $sql_tasks);
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo $global_url; ?>/mytask/my-created-task-details.php?task_id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>

                                        <td>
                                            <?php
                                            $task_manager= $row['task_manager'];
                                            $single_sql_manager = "SELECT  * FROM `users` WHERE  `id`=$task_manager";
                                            $result_manager = mysqli_query($connection, $single_sql_manager);
                                            $manager_name = mysqli_fetch_assoc($result_manager);
                                            ?>
                                            <span class=""><center><font size="2%"><?php echo $manager_name['name'];?></font></center></span>

                                        </td>
                                        <td>
                                            <?php
                                            $assigned_by= $row['created_user'];
                                            $single_sql = "SELECT  * FROM `users` WHERE  `id`=$assigned_by";
                                            $result = mysqli_query($connection, $single_sql);
                                            $data = mysqli_fetch_assoc($result);
                                            //if($_SESSION['user_id']!=$row['created_user']){ ?>

                                                <span class=""><center><font size="2%"><?php echo $data['name']; ?></font></center></span>

                                            <?php ?>


                                        </td>
                                        <td class="status"><?php
                                            $status= $row['status'];
                                            $status_sql = "SELECT  * FROM `project_status` WHERE  `id`=$status";
                                            $result_status = mysqli_query($connection, $status_sql);
                                            $statusdata = mysqli_fetch_assoc($result_status); ?>
                                            <span>
                                              <?php
                                            
                                               if($statusdata['status_name']=="Completed"){
                                                echo '<span class="green">'.$statusdata['status_name'].'</span>'; 
                                               }else if($statusdata['status_name']=="In Progress"){
                                                  echo '<span class="orange">'.$statusdata['status_name'].'</span>'; 
                                               }else if($statusdata['status_name']=="Rejected"){
                                                  echo '<span class="red">'.$statusdata['status_name'].'</span>'; 
                                                  }else if($statusdata['status_name']=="Extension"){
                                                  echo '<span>'.$statusdata['status_name'].'</span>'; 
                                               }
                                               
                                               ?>
                                         </span>
                                        </td>
                                        <td>
                                            <?php
                                            $array = $row['team_member'];
                                            $names = "SELECT name FROM `users` WHERE `id` IN($array )";
                                            $name_list = mysqli_query($connection, $names);
                                            $sl=0;
                                            while ($lists = mysqli_fetch_assoc($name_list)) {
                                                $sl++;
                                                ?><font size="2%"><?php echo $sl.') '.$lists['name'];?></font><br>
                                            <?php }
                                            ?>
                                        </td>
                                        <td><?php echo date('d-m-Y', strtotime($row['assign_date']));  ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['delivery_date'])); ?></td>

                                        <td>
                                            <?php
                                            $department_id= $row['department_id'];
                                            $dept_name = "SELECT department_name FROM `departments` WHERE `id`=$department_id LIMIT 1";
                                            $fetchname = mysqli_query($connection, $dept_name);
                                            $d_name = mysqli_fetch_assoc($fetchname);
                                            echo $d_name['department_name'];
                                            ?>
                                        </td>
                                        <td>

                                            <?php
                                            if($row['user_updated_date']!=''){
                                                echo date('d-m-Y h:i', strtotime($row['user_updated_date']));
                                            }
                                            ?></td>
                                            
                                              <?php if($_SESSION['employee_role']==1){?>
                                               <td>
                                                  <a class="btn btn-sm btn-info" href="<?php if($statusdata['status_name']=="Completed"){echo "";}else{ echo $global_url; ?>/mytask/edit_task.php?edit_task_id=<?php  echo $row['id'];} ?>"><i class="fa fa-pencil"></i> </a>
                                                </td>
                                              <?php  }?>

                                         
                                    </tr>
                                <?php } ?>


                                <?php
                                ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-center">Task&nbsp;Title</th>
                                    <th class="text-center">&nbsp;&nbsp;&nbsp;Task&nbsp;Manager&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">Status</th>
                                    <th>Team&nbsp;Member</th>
                                    <th>Assign&nbsp;Date</th>
                                    <th>T.Delivery&nbsp;Date</th>
                                    <th>Department</th>
                                    <th>Update&nbsp;Date</th>
                                      <?php if($_SESSION['employee_role']==1){?>
                                    <th>Edit </th>
                                      <?php  }?>
                                </tr>
                                </tfoot>
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
