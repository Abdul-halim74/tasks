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
                        <div class="panel-heading">Collected Bill  List's</div>
                        <div class="panel-body">
                            <table id="example" class="table   table-bordered  table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Collected Bill Amount</th>
                                    <th>Bill Collection Date</th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php
                                $sql = "SELECT * FROM `collect_bills` ORDER BY id DESC";
                                $result = mysqli_query($connection, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td class="text-capitalize">
                                         <?php
                                            $project_name = $row['project_id'];
                                            $name_sql = "SELECT * FROM `bills` WHERE `id`=$project_name";
                                            $name = mysqli_query($connection, $name_sql);
                                            while ($p_name = mysqli_fetch_assoc($name)) { ?>
                                               <a href="bill_details.php?project_id=<?php echo $row['project_id']; ?>"> <?php echo $p_name['project_name']; ?></a>
                                               
                                            <?php }
                                            ?>
                                      
                                        </td>
                                        <td class="orange"><b>&#2547;  <?php echo formatInBDTStyle($row['amount']); ?>  </b></td>
                                        <td><?php echo date('jS   F Y  ', strtotime($row['collection_date'])); ?> </td>
                                    </tr>
                                <?php }
                                ?>


                                </tbody>
                                <tfoot>
                                <tr>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Collected Bill Amount</th>
                                    <th>Bill Collection Date</th>
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
