<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';


?>

<body>
<div id="app" class="app">
    <?php  include_once '../inc/sidebar.php'; ?>
</div>

<?php
$emp_id = $_GET['edit_emp_id'];
if (isset($_REQUEST['submit'])) {
    extract($_REQUEST);

    if ($_FILES['photo']['name']) {
        $tmp_file = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $rand = md5(uniqid().rand());
        $photo = $rand.".".$ext;
        move_uploaded_file($tmp_file,"images/".$photo);
    } else {
        $photo = $oldphoto;
    }


     if ($_FILES['resume']['name']) {
        $tmp_file = $_FILES['resume']['tmp_name'];
        $ext = pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION);
        $rand = md5(uniqid().rand());
        $resume = $rand.".".$ext;
        move_uploaded_file($tmp_file,"resumes/".$resume);
    } else {
        $resume = $oldresume;
    }

    $company = implode(",", $_REQUEST['company_id']);

    if(strlen($password) >=8){
           $password_val=md5($password);;
    }else{
         $password_val = $old_password;
    }

    $join_date = date("Y-m-d", strtotime($join_date));
    $dob = date("Y-m-d", strtotime($dob));
if($_SESSION['employee_role']==1) {
    $sql = "UPDATE `users` SET name='$name', email='$email',employee_id='$employee_id', password='$password_val',
     employee_role='$employee_role', department_id='$department_id', designation_id='$designation_id',user_status='$user_status' WHERE id=$id";
    $query = mysqli_query($connection, $sql);

    $sql_employee = "UPDATE `employees` SET `company`='$company',`father_name`='$father_name',`mother_name`='$mother_name',`spouse_name`='$spouse_name',
  `is_married`='$is_married',`personal_phone`='$personal_phone',`official_phone`='$official_phone',`current_address`='$current_address',
  `permanent_address`='$permanent_address',`national_id`='$national_id',`passport_no`='$passport_no',`blood_group`='$blood_group',
  `emergency_contact_person`='$emergency_contact_person',`emergency_contact_person_relations`='$emergency_contact_person_relations',
  `emergency_contact_person_phone`='$emergency_contact_person_phone',`previous_working_experience`='$previous_working_experience',`references`='$references',
  `dob`='$dob',`join_date`='$join_date',`resume`='$resume',`photo`='$photo',`work_type`='$work_type'  WHERE user_id=$id";
    $query_emp = mysqli_query($connection, $sql_employee);

}else{
    $sql = "UPDATE `users` SET name='$name', password='$password_val' WHERE id=$id";
    $query = mysqli_query($connection, $sql);

    $sql_employee = "UPDATE `employees` SET `father_name`='$father_name',`mother_name`='$mother_name',`spouse_name`='$spouse_name',
  `personal_phone`='$personal_phone',`official_phone`='$official_phone',`current_address`='$current_address',
  `permanent_address`='$permanent_address',`emergency_contact_person`='$emergency_contact_person',`emergency_contact_person_relations`='$emergency_contact_person_relations',
  `emergency_contact_person_phone`='$emergency_contact_person_phone',`resume`='$resume',`photo`='$photo' WHERE user_id=$id";
    $query_emp = mysqli_query($connection, $sql_employee);
}
    if ($query==1 && $query_emp==1) {
        $_SESSION['query'] = '
            <div class="alert alert-success fade in alert-dismissible" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
            <strong>Update </strong> Successfully.
            </div>';
         echo "<script>window.location.href='edit_emp.php?edit_emp_id=$emp_id';</script>";
           exit();
        //header('location:edit_emp.php?edit_emp_id='.$emp_id);

    } else {
        $_SESSION['query'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>Update</strong> failed check  all field!
        </div>';
        echo "<script>window.location.href='edit_emp.php?edit_emp_id=$emp_id';</script>";
          exit();
    }
}

?>


<?php
if($_SESSION['employee_role']!='1'){
    $emp_id=$_SESSION['user_id'];
}else{
    $emp_id=$emp_id;
}
$sql = "SELECT * FROM `users` INNER JOIN `employees` ON users.id = employees.user_id  WHERE users.id='$emp_id' ";
$query = mysqli_query($connection, $sql);
$data = mysqli_fetch_array($query);
//var_dump($data);
?>

<div class="content-area">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">Update Profile</div>
                <div class="panel-body">
                    <?php
                    echo $_SESSION['query'];
                    $_SESSION['query'] = null;
                    ?>
                  <?php if($_SESSION['employee_role']==1){ ?>
                      <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                            enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $emp_id;?>">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label for="name" class="col-md-12 col-form-label ">Full Name <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="name"
                                                 value="<?php echo $data['name']; ?>" required="">
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <label for="name" class="col-md-12 col-form-label ">Employee ID <span class="red">*</span> </label>
                                      <div class="col-md-12">

                                          <input type="text" class="form-control" name="employee_id" value="<?php echo $data['employee_id']; ?>" required="">

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
                                                  <option value="<?php echo $role['id']; ?>" <?php if($data['employee_role']==$role['id']){ echo "selected"; } ?> ><?php echo $role['role_name']; ?></option>
                                              <?php } ?>

                                          </select>

                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="name" class="col-md-12 col-form-label ">Email Address <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="email" readonly class="form-control" value="<?php echo $data['email']; ?>"
                                                 name="email" >
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Company <span class="red">*</span></label>

                                      <div class="col-md-12">
                                          <select name="company_id[]" class="form-control team" required="" multiple="">
                                              <?php
                                              $array = explode(',', $data['company']);
                                              $sql_company = "SELECT * FROM companies";
                                              $company_query = mysqli_query($connection, $sql_company);
                                              while ($company = mysqli_fetch_array($company_query)) {
                                                  ?>
                                                  <option value="<?php echo $company['id']; ?>"  <?php if(in_array($company['id'], $array)) {echo "selected";} ?> ><?php echo $company['company_name']; ?></option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Department <span
                                                  class="red">*</span></label>
                                      <div class="col-md-12">
                                          <select class="form-control" id="department_id" name="department_id" required="">
                                              <?php
                                              $sql_department = "SELECT * FROM departments";
                                              $department_query = mysqli_query($connection, $sql_department);
                                              while ($department = mysqli_fetch_array($department_query)) {
                                                  ?>
                                                  <option value="<?php echo $department['id']; ?>" <?php if($department['id']==$data['department_id']){echo "selected";} ?>><?php echo $department['department_name']; ?></option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Designation <span
                                                  class="red">*</span></label>
                                      <div class="col-md-12">
                                          <select class="form-control" name="designation_id" id="designation_id" required="">
                                              <?php
                                              $department_id= $data['department_id'];
                                              $sql_designation = "SELECT designations.id as id, designations.designation_name as designation_name, departments.department_name as department_name FROM `designations` INNER JOIN `departments` on `designations`.department_id=`departments`.id WHERE department_id=$department_id"; 
                                              $designation_query = mysqli_query($connection, $sql_designation);
                                              while ($designation = mysqli_fetch_array($designation_query)) {
                                                  ?>
                                                  <option value="<?php echo $designation['id']; ?>" <?php if($designation['id']==$data['designation_id']){echo "selected";} ?> ><?php echo $designation['designation_name']; ?></option>
                                              <?php } ?>
                                              </option>
                                          </select>
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label for="password-confirm" class="col-md-12 col-form-label  ">Father Name <i class="red">*</i></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['father_name']; ?>"
                                                 name="father_name" class="form-control" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label for="password-confirm" class="col-md-12 col-form-label  ">Mother Name <i class="red">*</i></label>
                                      <div class="col-md-12">
                                          <input type="text" name="mother_name"
                                                 value="<?php echo $data['mother_name']; ?>" class="form-control"
                                                 required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Spouse Name</label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['spouse_name']; ?>"
                                                 class="form-control" name="spouse_name">
                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Is Married <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <select name="is_married" class="form-control" required>
                                              <option value="">Select Marital Status</option>
                                              <option <?php if ($data['is_married'] == 'married') {
                                                  echo 'selected';
                                              } ?> value="married">Married
                                              </option>
                                              <option <?php if ($data['is_married'] == 'unmarried') {
                                                  echo 'selected';
                                              } ?> value="unmarried">UnMarried
                                              </option>
                                          </select>
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Personal Phone <i class="red">*</i></label>
                                      <div class="col-md-12">
                                          <input type="number" value="<?php echo $data['personal_phone']; ?>"
                                                 class="form-control" name="personal_phone" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Official Phone</label>
                                      <div class="col-md-12">
                                          <input type="number" value="<?php echo $data['official_phone']; ?>"
                                                 class="form-control" name="official_phone">
                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Current Address <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['current_address']; ?>"
                                                 class="form-control" name="current_address" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Permanent Address <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['permanent_address']; ?>"
                                                 class="form-control" name="permanent_address" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Status <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <select class="form-control" name="user_status" required="">
                                              <option <?php if ($data['user_status'] == '1') {
                                                  echo 'selected';
                                              } ?> value="1">Active
                                              </option>
                                              <option <?php if ($data['user_status'] == '2') {
                                                  echo 'selected';
                                              } ?> value="2">Inactive
                                              </option>

                                          </select>
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Work Type <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <select class="form-control" name="work_type" required="">
                                              <option value="">Select One</option>
                                              <option value="1" <?php if ($data['work_type'] == '1') { echo 'selected'; } ?>>Part Time Employee</option>
                                              <option value="2" <?php if ($data['work_type'] == '2') { echo 'selected'; } ?>>Full Time Employee</option>

                                          </select>
                                      </div>
                                  </div><!--END-->

                              </div>
                              <div class="col-md-6">
                                  <div class="form-group row">
                                      <label for="password" class="col-md-12 col-form-label">Password</label>

                                      <div class="col-md-12">
                                          <input  type="hidden" value="<?php echo $data['password']; ?>" class="form-control"  name="old_password" >
                                          <input id="password" type="text"  onkeyup="checkPassword();" value="" class="form-control" name="password">
                                          <small>password need to be Alphanumeric.EX: [A-Z][0-9] &nbsp; <span id="pass_message"></span>
                                          </small>
                                          </small>
                                      </div>
                                  </div>


                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">National Id <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['national_id']; ?>"
                                                 class="form-control" name="national_id" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Passport No</label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['passport_no']; ?>"
                                                 class="form-control" name="passport_no">
                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Blood Group</label>
                                      <div class="col-md-12">

                                          <input type="text" value="<?php echo $data['blood_group']; ?>"
                                                 class="form-control" name="blood_group">


                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Emergency Contact Person Name </label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['emergency_contact_person']; ?>"
                                                 class="form-control" name="emergency_contact_person">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Emergency Contact Person Relations</label>
                                      <div class="col-md-12">
                                          <input type="text"
                                                 value="<?php echo $data['emergency_contact_person_relations']; ?>"
                                                 class="form-control" name="emergency_contact_person_relations">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Emergency Contact Person Phone</label>
                                      <div class="col-md-12">
                                          <input type="number"
                                                 value="<?php echo $data['emergency_contact_person_phone']; ?>"
                                                 class="form-control" name="emergency_contact_person_phone">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">Previous Working Experience</label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['previous_working_experience']; ?>"
                                                 class="form-control" name="previous_working_experience">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">References</label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['references']; ?>"
                                                 class="form-control" name="references">
                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label  ">DOB <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php echo $data['dob']; ?>" class="form-control datepicker"
                                                 name="dob" required="">
                                      </div>
                                  </div><!--END-->
                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Join Date  <span class="red">*</span></label>
                                      <div class="col-md-12">
                                          <input type="text" value="<?php  echo  $data['join_date'];   ?>"  class="form-control datepicker"  name="join_date" required="">
                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Photo </label>
                                      <div class="col-md-12">

                                          <img src="<?php echo $global_url;?>/employee/images/<?php echo $data['photo']; ?>" width="70px" height="70px">
                                          <input type="hidden" class="form-control" name="oldphoto"
                                                 value="<?php echo $data['photo']; ?>">
                                          <input type="file" class="form-control" name="photo">

                                      </div>
                                  </div><!--END-->

                                  <div class="form-group row">
                                      <label class="col-md-12 col-form-label">Resume</label>
                                      <div class="col-md-12">
                                          <input type="hidden" name="oldresume" value="<?php echo $data['resume']; ?>">
                                          <input type="file" class="form-control" name="resume">

                                          <a href="<?php echo $global_url;?>/employee/resumes/<?php echo $data['resume']; ?>" download><?php echo $global_url;?>/employee/resumes/<?php echo $data['resume']; ?></a>

                                      </div>
                                  </div><!--END-->

                              </div>
                          </div>


                          <div class="form-group row mb-0 text-center">

                              <div class="col-md-12">
                                  <br><br>
                                  <input type="submit" name="submit" value="Update" class="btn btn-info">
                              </div>
                          </div>
                      </form>
                  <?php }else{ ?>
                    <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                          enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $emp_id;?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label ">Full Name <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="name"
                                               value="<?php echo $data['name']; ?>" required="">
                                    </div>
                                </div>





                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Father Name <i class="red">*</i></label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php echo $data['father_name']; ?>"
                                               name="father_name" class="form-control" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 col-form-label  ">Mother Name <i class="red">*</i></label>
                                    <div class="col-md-12">
                                        <input type="text" name="mother_name"
                                               value="<?php echo $data['mother_name']; ?>" class="form-control"
                                               required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Spouse Name</label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php echo $data['spouse_name']; ?>"
                                               class="form-control" name="spouse_name">
                                    </div>
                                </div><!--END-->


                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Personal Phone <i class="red">*</i></label>
                                    <div class="col-md-12">
                                        <input type="number" value="<?php echo $data['personal_phone']; ?>"
                                               class="form-control" name="personal_phone" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Official Phone</label>
                                    <div class="col-md-12">
                                        <input type="number" value="<?php echo $data['official_phone']; ?>"
                                               class="form-control" name="official_phone">
                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Current Address <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php echo $data['current_address']; ?>"
                                               class="form-control" name="current_address" required="">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Permanent Address <span class="red">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php echo $data['permanent_address']; ?>"
                                               class="form-control" name="permanent_address" required="">
                                    </div>
                                </div><!--END-->


                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="password" class="col-md-12 col-form-label">Password</label>

                                    <div class="col-md-12">
                                        <input  type="hidden" value="<?php echo $data['password']; ?>" class="form-control"  name="old_password" >
                                        <input id="password" type="text"  onkeyup="checkPassword();" value="" class="form-control" name="password">
                                        <small>password need to be Alphanumeric.EX: [A-Z][0-9] &nbsp; <span id="pass_message"></span>
                                        </small>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Emergency Contact Person Name </label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php echo $data['emergency_contact_person']; ?>"
                                               class="form-control" name="emergency_contact_person">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Emergency Contact Person Relations</label>
                                    <div class="col-md-12">
                                        <input type="text"
                                               value="<?php echo $data['emergency_contact_person_relations']; ?>"
                                               class="form-control" name="emergency_contact_person_relations">
                                    </div>
                                </div><!--END-->
                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label  ">Emergency Contact Person Phone</label>
                                    <div class="col-md-12">
                                        <input type="number"
                                               value="<?php echo $data['emergency_contact_person_phone']; ?>"
                                               class="form-control" name="emergency_contact_person_phone">
                                    </div>
                                </div><!--END-->



                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Photo </label>
                                    <div class="col-md-12">

                                        <img src="<?php echo $global_url;?>/employee/images/<?php echo $data['photo']; ?>" width="70px" height="70px">
                                        <input type="hidden" class="form-control" name="oldphoto"
                                               value="<?php echo $data['photo']; ?>">
                                        <input type="file" class="form-control" name="photo">

                                    </div>
                                </div><!--END-->

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Resume</label>
                                    <div class="col-md-12">
                                        <input type="hidden" name="oldresume" value="<?php echo $data['resume']; ?>">
                                        <input type="file" class="form-control" name="resume">

                                        <a href="<?php echo $global_url;?>/employee/resumes/<?php echo $data['resume']; ?>" download><?php echo $global_url;?>/employee/resumes/<?php echo $data['resume']; ?></a>

                                    </div>
                                </div><!--END-->

                            </div>
                        </div>


                        <div class="form-group row mb-0 text-center">

                            <div class="col-md-12">
                                <br><br>
                                <input type="submit" name="submit" value="Update Profile" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                    <?php } ?>
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
   // var $select1 = $('#select1'), $select2 = $('#select2'), $options = $select2.find('option');
    //$select1.on('change', function () {
     //   $select2.html($options.filter('[ref="' + this.value + '"]'));
    //}).trigger('change');

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
<script>
    $(document).ready(function () {
         
            
        $("#department_id").change(function (e) {
            $("#designation_id").empty();

            var deptID = $(this).val();
             //alert(deptID);
            $.ajax({
                type: 'POST',
                url: 'ajax-find-users-under-department.php',
                data: {id: deptID},
                success: function (response) {
                   //console.log(response);
                    var data = JSON.parse(response);
                    var len = data.length;
                    console.log(len)
                    for(var i=0; i<len; i++){
                         var tr_str ="<option value="+ data[i].id +">" + data[i].name + "</option>";
                        $("#designation_id").append(tr_str);
                    }
                },
            });
        });
    });
</script>
<?php
include_once '../inc/footer.php';
?>
</body>
</html>
