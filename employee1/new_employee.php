<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
?>

<?php

if (isset($_POST['submit'])) {
    //echo $_POST['submit'];
    extract($_REQUEST);

    $company = implode(",", $_REQUEST['company_id']);
    //$department_id = implode(",", $_REQUEST['department_id']);

    $password = md5($_POST['password']);

//    $image = $_FILES['photo']['name'];
//    // image file directory
//    $target = "" . basename($image);
//    move_uploaded_file($_FILES['photo']['tmp_name'], "images/" . basename($image));


    $tmp_file = $_FILES['photo']['tmp_name'];
    $ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
    $rand = md5(uniqid().rand());
    $image = $rand.".".$ext;
    $mv_img=move_uploaded_file($tmp_file,"images/".$image);


    $resume_tmp_file = $_FILES['resume']['tmp_name'];
    $extension = pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION);
    $rand = md5(uniqid().rand());
    $resume = $rand.".".$extension;
    $mv_resume=move_uploaded_file($resume_tmp_file,"resumes/".$resume);


    $join_date = date("Y-m-d", strtotime($join_date));
    $dob = date("Y-m-d", strtotime($dob));

    //if($mv_img==1 && $mv_resume==1){
        //Insert user  table data
        $user_sql = "INSERT INTO `users` SET name='$name', email='$email',employee_id='$employee_id', employee_role='$employee_role',department_id='$department_id', designation_id='$designation_id', password='$password',user_status='$user_status'";
        $user_query = mysqli_query($connection, $user_sql);
        $get_insert_id = mysqli_insert_id($connection);

        //insert  employee table data
        $sql_employee = "INSERT INTO `employees` SET user_id='$get_insert_id', company='$company',father_name='$father_name', mother_name='$mother_name', spouse_name='$spouse_name',
    is_married='$is_married',personal_phone='$personal_phone', official_phone='$official_phone', current_address='$current_address', permanent_address='$permanent_address',
    national_id='$national_id', passport_no='$passport_no', blood_group='$blood_group', emergency_contact_person='$emergency_contact_person',emergency_contact_person_relations='$emergency_contact_person_relations',
     emergency_contact_person_phone='$emergency_contact_person_phone', previous_working_experience='$previous_working_experience', `references`='$references', dob='$dob',  join_date='$join_date',photo='$image', resume='$resume',work_type='$work_type'";
        $employee_query = mysqli_query($connection, $sql_employee);

        if ($user_query == 1 && $employee_query == 1) {
            $_SESSION['query'] = '
            <div class="alert alert-success fade in alert-dismissible" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
            <strong>New Employee </strong>   Added Successfully.
            </div>';
         echo "<script>window.location.href='$global_url/employee/new_employee.php'</script>";
            exit();
        } else {
            $_SESSION['query'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>Error</strong>   Check all field. <br> <b>Email & Employee ID</b> Need To unique 
        </div>';
            //header('location:new_employee.php');
             echo "<script>window.location.href='$global_url/employee/new_employee.php'</script>";
            exit();
        }
    ///}
}
?>
<body>
<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>

<div class="content-area">
    <div class="container-fluid">
        <div class="col-md-12">
            <?php
            if ($_SESSION['query']) {
                echo $_SESSION['query'];
                $_SESSION['query'] = null;
            }

            ?>
        </div>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">Add New Employee</div>
                <div class="panel-body">

                    <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Full Name <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="name" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Employee ID <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="employee_id" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Employee Role <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="employee_role" required="">
                                            <option value="">Select Employee Role</option>
                                            <?php
                                            $sql_roles = "SELECT * FROM  user_roles";
                                            $roles_query = mysqli_query($connection, $sql_roles);
                                            while ($role = mysqli_fetch_array($roles_query)) {
                                                ?>
                                                <option value="<?php echo $role['id']; ?>"><?php echo $role['role_name']; ?></option>
                                            <?php } ?>

                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Email Address <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" required="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Company <span class="red">*</span></label>

                                    <div class="col-md-12">
                                        <select name="company_id[]" class="form-control team" required="" multiple="">
                                            <?php
                                            $sql_company = "SELECT * FROM companies";
                                            $company_query = mysqli_query($connection, $sql_company);
                                            while ($company = mysqli_fetch_array($company_query)) {
                                                ?>
                                                <option value="<?php echo $company['id']; ?>"><?php echo $company['company_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Department <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="select1" name="department_id" required="">
                                            <option value=" ">Select Department</option>
                                            <?php
                                            $sql_department = "SELECT * FROM departments";
                                            $department_query = mysqli_query($connection, $sql_department);
                                            while ($department = mysqli_fetch_array($department_query)) {
                                                ?>
                                                <option value="<?php echo $department['id']; ?>"><?php echo $department['department_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Designation <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="designation_id" id="select2" required="">
                                            <option ref=" " value=" ">Select Designation</option>
                                            <?php
                                            $sql_designation = "SELECT * FROM designations";
                                            $designation_query = mysqli_query($connection, $sql_designation);
                                            while ($designation = mysqli_fetch_array($designation_query)) {
                                                ?>
                                                <option ref="<?php echo $designation['department_id']; ?>"
                                                        value="<?php echo $designation['id']; ?>"><?php echo $designation['designation_name']; ?></option>
                                            <?php } ?>
                                            </option>
                                        </select>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Father Name <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" name="father_name" class="form-control" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Mother Name <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" name="mother_name" class="form-control" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Spouse Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="spouse_name">
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Is Married</label>
                                    <div class="col-md-12">
                                        <select name="is_married" class="form-control">
                                            <option value="">Select Marital Status</option>
                                            <option value="married">Married</option>
                                            <option value="unmarried">UnMarried</option>
                                        </select>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Personal Phone <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="personal_phone" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Official Phone</label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="official_phone">
                                    </div>
                                </div><!--END-->


                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Status <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="user_status" required="">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Work Type <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="work_type" required="">
                                            <option value="">Select One</option>
                                            <option value="1">Part Time Employee</option>
                                            <option value="2">Full Time Employee</option>

                                        </select>
                                    </div>
                                </div><!--END-->

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="password" class="col-md-12 col-form-label">Password <span
                                                class="red">*</span></label>

                                    <div class="col-md-12">
                                        <input id="password" type="text" class="form-control" value=""
                                               onkeyup="checkPassword();" name="password"
                                               required="">
                                        <small>password need to be Alphanumeric.EX: [A-Z][0-9] &nbsp; <span id="pass_message"></span>
                                        </small>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">National Id <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="national_id" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Passport No</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="passport_no">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Current Address <span
                                                class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="current_address" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Permanent Address <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="permanent_address" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Blood Group</label>
                                    <div class="col-md-12">

                                        <input type="text" class="form-control" name="blood_group">

                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Emergency Contact Person Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="emergency_contact_person">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Emergency Contact Person Relations</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control"
                                               name="emergency_contact_person_relations">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Emergency Contact Person Phone</label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="emergency_contact_person_phone">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Previous Working Experience</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="previous_working_experience">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">References</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="references">
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">DOB <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control simple-datepicker" name="dob" required>
                                        <small> Day-Month-Year</small>
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Join Date <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control simple-datepicker"
                                               value="<?php echo date('d-m-Y'); ?>" name="join_date" required="">
                                        <small> Day-Month-Year</small>
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Photo <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="file" class="form-control" name="photo" required="">

                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Resume <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="file" class="form-control" name="resume" required="">
                                    </div>
                                </div><!--END-->
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-center">

                            <div class="col-md-12">
                                <br><br>
                                <button type="submit" name="submit" class="btn btn-info">
                                    Register
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


<script type="text/javascript">

    //START DEPARTMENT DESIGNATION  DEPENDEND FIELD
    var $select1 = $('#select1'), $select2 = $('#select2'), $options = $select2.find('option');
    $select1.on('change', function () {
        $select2.html($options.filter('[ref="' + this.value + '"]'));
    }).trigger('change');

    //END DEPARTMENT DESIGNATION  DEPENDEND FIELD

    function checkPassword() {
        var password = $("#password").val();

        if (password.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/)) {
            $("#pass_message").html('<span class="green">Password is Strong.</span>');
        } else {
            $("#pass_message").html('<span class="red">Password is Wrong.</span>');
        }
    }
</script>


<?php
include_once '../inc/footer.php';
?>
</body>
</html>
