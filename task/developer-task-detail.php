<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$id = $_GET['id'];
$single_sql = "SELECT  * FROM `developers` WHERE  `id`=$id";
$result = mysqli_query($connection, $single_sql);
$data = mysqli_fetch_assoc($result);


?>
<body>
<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>
<div class="content-area">
    <div class="container-fluid">
        <div>

            <div class="row justify-content-center">

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Developer Task Details
                            <?php if($_SESSION['emp_type']=="super_admin"){ ?>
                            <a  href="<?php echo $global_url; ?>/task/edit__developer_task-not-used.php?id=<?php echo $data['id']; ?>"
                                    class="pull-right btn btn-warning  btn-sm">Edit Developer Task</a>
                         <?php } ?>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">

                                <tbody>
                                <tr>
                                    <td colspan="3"><b>Task Title:</b> <?php echo $data['title']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Task Manager: </b> <span>
                                  <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                    aria-hidden="true"></i> <?php echo $data['task_manager'] ?></span>
                                                                                                                                                                                                                                                                                                                                                            </span>
                                    </td>
                                    <td><b>Status :</b>
                                        <?php echo $data['status']; ?>
                                    </td>
                                    <td><b>Assign
                                            Date: </b> <?php echo date('jS   F Y  ', strtotime($row['assign_date'])); ?>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <b>Team Members: </b>
                                        <?php
                                        $array = $data['team_member'];
                                        $names = "SELECT name FROM `users` WHERE `id` IN($array )";
                                        $name_list = mysqli_query($connection, $names);
                                        while ($lists = mysqli_fetch_assoc($name_list)) {
                                            ?>
                                            <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                              aria-hidden="true"></i> <?php echo $lists['name']; ?></span>
                                        <?php }
                                        ?>

                                    </td>

                                </tr>
                                <tr>

                                    <td><b>Delivery
                                            Date: </b> <?php echo date('jS   F Y  ', strtotime($row['delivery_date'])); ?>
                                    </td>
                                    <td><b>Update
                                            Date: </b> <?php echo date('jS   F Y  ', strtotime($row['delivery_date'])); ?>
                                    </td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <b>Assignment: </b>
                                        <br>
                                        <?php echo $data['assignment']; ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <b>Remarks: </b> <?php echo $data['remarks']; ?>
                                        <br><br>
                                    </td>
                                </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
    </div>
</div>
</div>
<?php
include_once '../inc/footer.php';
?>
</body>
</html>
