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
                        <div class="panel-heading">Employee List's</div>
                        <div class="panel-body">
                            <table id="example" class="table   table-bordered table-responsive">
                                <thead>

                                <tr>
                                    <th>EMP ID</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Phone</th>
                                    <th>Designation</th>
                                    <th>Joining Date</th>
                                    <th>Total Days</th>
                                    <th width="40px" class="text-center">Edit</th>

                                </tr>

                                </thead>

                                <tbody>

                                <?php
                               $sql = "SELECT *,users.id as user_id FROM users INNER JOIN employees ON users.id=employees.user_id INNER JOIN designations ON users.designation_id=designations.id";
                                $query = mysqli_query($connection, $sql);

                                while ($data = mysqli_fetch_array($query)) {

                                    ?>

                                    <tr role="row" class="odd">
                                        <td class="text-capitalize">
                                       <a href="emp_detail.php?emp_id=<?php echo $data['user_id']; ?>"
                                        ><?php echo $data['employee_id']; ?></a>
                                                </td>
                                        <td class="text-capitalize"><?php echo $data['name']; ?></td>


                                        <td><?php echo $data['email']; ?></td>
                                        <td><?php echo $data['personal_phone']; ?></td>
                                        <td><?php echo $data['designation_name']; ?></td>
                                        <td class="join_date">  <?php echo  date('jS   F Y ',strtotime($data['join_date'])); ?>  </td>
                                        <td>

                                            <?php
                                            // Declare and define two dates
                                            $date1 = strtotime($data['join_date']);
                                            $date2 = strtotime(date('jS   F Y '));
                                            // Formulate the Difference between two dates
                                            $diff = abs($date2 - $date1);
                                            // To get the year divide the resultant date into
                                            // total seconds in a year (365*60*60*24)
                                            $years = floor($diff / (365 * 60 * 60 * 24));
                                            // To get the month, subtract it with years and
                                            // divide the resultant date into
                                            // total seconds in a month (30*60*60*24)
                                            $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                                                / (30 * 60 * 60 * 24));

                                            if ($years > 0) {
                                                echo $years . " Years ";
                                            };
                                            if ($months > 0) {
                                                echo $months . " Month ";
                                            };
                                            ?>

                                        </td>

                                        <td class="text-center">
                                                                                        <a href="edit_emp.php?edit_emp_id=<?php echo $data['user_id']; ?>"
                                                                                           class="btn btn-info btn-sm text-center"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                }

                                ?>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>EMP ID</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Phone</th>
                                    <th>Designation</th>
                                    <th>Joining Date</th>
                                    <th>Total Days</th>
                                    <th width="40px">Edit</th>

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
