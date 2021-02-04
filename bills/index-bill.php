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
                    <div class="panel panel-default">
                        <div class="panel-heading">All Bill List's</div>
                        <div class="panel-body">
                            <table id="example" class="table   table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Receivable Amount</th>
                                    <th>Assigned To</th>
                                    <th>Target Date</th>
                                    <th class="text-center" width="60px">Edit</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $sql = "SELECT * FROM `bills` ORDER BY id DESC";
                                $result = mysqli_query($connection, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><a href="bill_details.php?project_id=<?php echo $row['id']; ?>"><?php echo $row['project_name'] ?></a></td>
                                        <!--                                        <td><a href="-->
                                        <?php //echo $global_url ;
                                        ?><!--/bills/bill-detail.php?id=--><?php //echo $row['id'];
                                        ?><!--">--><?php //echo $row['project_name']
                                        ?><!--</a></td>-->


                                        <td><b class="green">&#2547; <?php echo formatInBDTStyle($row['receivable_amount']); ?>  </b></td>
                                        <td>
                                            <?php
                                            $array = $row['assigned_person'];
                                            $names = "SELECT name FROM `users` WHERE `id` IN($array )";
                                            $name_list = mysqli_query($connection, $names);
                                            while ($lists = mysqli_fetch_assoc($name_list)) {
                                                ?>
                                                <span class="badge badge-info"><i class="fa fa-user-o  "
                                                                                   aria-hidden="true"></i> <?php echo $lists['name']; ?></span>
                                            <?php }
                                            ?>

                                        </td>
                                        <td>
                                            <?php  echo date("jS   F Y", strtotime($row["target_date"])); ?>


                                            <br>

                                        </td>
                                        <td class="text-center"><a href="edit_bill.php?edit_id=<?php echo $row['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                <?php }
                                ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Receivable Amount</th>
                                    <th>Assigned To</th>
                                    <th>Target Date</th>
                                    <th class="text-center">Edit</th>
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
