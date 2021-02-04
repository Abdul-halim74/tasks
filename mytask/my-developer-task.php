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
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">Status</th>
                                    <th>Team&nbsp;Member</th>
                                    <th>Assign&nbsp;Date</th>
                                    <th>T.Delivery&nbsp;Date</th>
                                    <th>Update&nbsp;Date</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $userid= $_SESSION['user_id'];
                                $sql_tasks = "SELECT * FROM `developer_tasks` WHERE task_manager=$userid OR team_member  LIKE '%$userid%' OR created_user=$userid AND `department_id`=2";
                                $result1 = mysqli_query($connection, $sql_tasks);
                                while ($row = mysqli_fetch_assoc($result1)) {
                                if($row['department_id']==2){
                                    ?>
                                    <tr>
                                        <td><a href="edit_task.php?edit_id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
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
                                        <td>
                                            <?php
                                            $assigned_by= $row['created_user'];
                                            $single_sql = "SELECT  * FROM `users` WHERE  `id`=$assigned_by";
                                            $result = mysqli_query($connection, $single_sql);
                                            $data = mysqli_fetch_assoc($result);
                                            ?>
                                            <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                              aria-hidden="true"></i> <?php echo $data['name']; ?></span>

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

                                    </tr>
                                <?php } } ?>


                                <?php
                                ?>

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
