<?php error_reporting(1);

session_start();

include_once '../inc/connection.php';

include_once '../inc/head.php';

 $user_id=$_SESSION['user_id'];







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

                    <div class="panel panel-default profile">



                        <?php

                        $single_sql = "SELECT users.*,employees.*,designations.designation_name as designation_name,user_roles.role_name as role_name   FROM users INNER JOIN employees ON users.id=employees.user_id INNER JOIN designations ON users.designation_id=designations.id INNER JOIN user_roles ON users.employee_role=user_roles.id WHERE users.id=$user_id";

                        $result = mysqli_query($connection, $single_sql);

                        $data = mysqli_fetch_assoc($result);

                        //echo "<pre>";

                        //var_dump($data);

                        ?>
                        <div class="panel-body">

                            <div class="row text-center">

                                <div class="col-md-12  mt30 mb15">
                                    <a href="edit_emp.php?edit_emp_id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-info  btn-sm pull-right"><i class="fa fa-pencil"></i></a>
                                    <img src="<?php echo $global_url; ?>/employee/images/<?php echo $data['photo']; ?>" class="img-thumbnail" width="150px" height="150px">

<h1><?php echo $data['name']; ?></h1>

<h2><?php echo $data['designation_name']; ?></h2>

                                    <a href="<?php echo $global_url?>/employee/resume/<?php echo $data['resume'];  ?>" class="base-color" download>Download Resume</a>

                                </div>

                                <div class="col-md-3 info-box">

                                    <h2>Email Address</h2>

                                    <?php echo $data['email']; ?>

                                </div>

                                <div class="col-md-3 info-box">

                                    <h2>Personal Phone</h2>

                                    <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $data['personal_phone']; ?>

                                </div>

                                <div class="col-md-3 info-box">

                                    <h2>Employee ID  </h2>

                                    <span ># <?php echo $data['employee_id']; ?> </span>

                                </div>

                                <div class="col-md-3 info-box">

                                    <h2>Present Address</h2>

                                    <?php echo $data['current_address']; ?>

                                </div>

                            </div>

                            <table class="table table-striped table-bordered table-responsive mt30 info-box">



                                <tbody>



                                <tr>



                                    <td><p>Join Date:</p>   <?php echo date('jS   F Y  ', strtotime($data['join_date']));  ?></td>

                                    <td><p>company:</p>

                                        <?php

                                        $array = $data['company'];

                                        $names = "SELECT company_name FROM `companies` WHERE `id` IN($array )";

                                        $name_list = mysqli_query($connection, $names);

                                        while ($lists = mysqli_fetch_assoc($name_list)) {

                                            ?>

                                            <span class="badge badge-info"><?php echo $lists['company_name']; ?></span>

                                        <?php }

                                        ?>

                                    </td>

                                    <td><p>Department:</p>

                                        <?php

                                        $department_array = $data['department_id'];

                                        $department_names = "SELECT department_name FROM `departments` WHERE `id` IN($department_array )";

                                        $department_list = mysqli_query($connection, $department_names);

                                        while ($department = mysqli_fetch_assoc($department_list)) {

                                            ?>

                                            <span class="badge badge-info"><?php echo $department['department_name']; ?></span>

                                        <?php }

                                        ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td><p>Employee Role:</p> <span class="base-color"><i class="fa fa-info-circle"></i> <?php echo $data['role_name']; ?></span></td>

                                    <td><p>Date Of Birth:</p> <?php echo date('jS   F Y  ', strtotime($data['dob']));  ?></td>

                                    <td><p>National ID:</p> <i class="fa fa-id-card-o" aria-hidden="true"></i> <?php echo $data['national_id']; ?></td>





                                </tr>

                                <tr>

                                    <td><p>Official Phone:</p> <?php echo $data['official_phone']; ?></td>

                                    <td><p>Working Experience: </p><span class="base-color"><?php echo $data['previous_working_experience']; ?></span> Years</td>

                                    <td><p>Total Working Time: </p>

                                        <span class="base-color">

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

 </span>

                                    </td>



                                </tr>

                                <tr>



                                    <td><p>Father Name:</p> <?php echo $data['father_name']; ?></td>

                                    <td><p>Mother Name:</p> <?php echo $data['mother_name']; ?></td>

                                    <td><p>Passport NO:</p> <?php echo $data['passport_no']; ?></td>

                                </tr>

                                <tr>

                                    <td><p>Blood Group:</p> <?php echo $data['blood_group']; ?></td>

                                    <td><p>Marital Status:</p> <?php echo $data['is_married']; ?></td>

                                    <td><p>Emergency Contact Person Name:</p> <?php echo $data['emergency_contact_person']; ?></td>



                                </tr>

                                <tr>

                                    <td><p>Relations:</p> <?php echo $data['emergency_contact_person_relations']; ?></td>

                                    <td><p>Emergency Contact Person Phone NO:</p> <?php echo $data['emergency_contact_person_phone']; ?></td>

                                    <td><p>Spouse Name:</p> <?php echo $data['spouse_name']; ?></td>

                                </tr>

                                <tr>

                                    <td><p>Permanent  Address:</p> <?php echo $data['permanent_address']; ?></td>

                                    <td colspan="2"><p>References:</p> <?php echo $data['references']; ?></td>





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

