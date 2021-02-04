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
            <div class="row  ">
                <div class="col-md-12">

                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Developer Task List's</div>
                        <div class="panel-body">
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th class="text-center">Task&nbsp;Title</th>
                                    <th class="text-center">Task&nbsp;Manager</th>

                                    <th class="text-center">Status</th>
                                    <th>Team&nbsp;Member</th>
                                    <th>Assign&nbsp;Date</th>
                                    <th>T.Delivery&nbsp;Date</th>
                                    <th>Update&nbsp;Date</th>
                                    <th>Department</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $userid= $_SESSION['user_id'];
                                $sql_tasks = "SELECT * FROM `developer_tasks` WHERE  created_user=$userid";
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
                                            <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                              aria-hidden="true"></i> <?php echo $manager_name['name']; ?></span>

                                        </td>

                                        <td><?php
                                            $status= $row['status'];
                                            $status_sql = "SELECT  * FROM `project_status` WHERE  `id`=$status";
                                            $result_status = mysqli_query($connection, $status_sql);
                                            $statusdata = mysqli_fetch_assoc($result_status);
                                            echo $statusdata['status_name'];
                                            ?></td>
                                        <td>
                                            <?php
                                            $array = $row['team_member'];
                                            $names = "SELECT name FROM `users` WHERE `id` IN($array )";
                                            $name_list = mysqli_query($connection, $names);
                                            while ($lists = mysqli_fetch_assoc($name_list)) {
                                                ?>
                                                <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                                  aria-hidden="true"></i> <?php echo $lists['name']; ?></span>
                                            <?php }
                                            ?>
                                        </td>
                                        <td><?php echo date('jS   F Y  ', strtotime($row['assign_date']));  ?></td>
                                        <td><?php echo date('jS   F Y  ', strtotime($row['delivery_date'])); ?></td>
                                        <td><?php if($row['user_updated_date']!='0000-00-00 00:00:00')
                                                echo date('jS   F Y  h:i', strtotime($row['user_updated_date']));
                                            ?></td>
                                        <td><?php
                                            $department_id= $row['department_id'];
                                            $dept_name = "SELECT department_name FROM `departments` WHERE `id`=$department_id LIMIT 1";
                                            $fetchname = mysqli_query($connection, $dept_name);
                                            $d_name = mysqli_fetch_assoc($fetchname);
                                            echo $d_name['department_name'];
                                        ?></td>

                                    </tr>
                                <?php    } ?>

                                </tbody>
                                <tfoot>
                                <tr>


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
