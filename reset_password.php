<?php error_reporting(1);
session_start();
include_once 'inc/connection.php';
include_once 'inc/head.php';
?>
<body>
<div id="app" class="app">
    <?php  include_once 'inc/sidebar.php'; ?>
</div>
<?php
if(isset($_POST['submit'])){
    extract($_REQUEST);
    $old_password=md5($old_password);
    $new_password=md5($new_password);
    $user_id=$_SESSION['user_id'];
    //echo "<script>alert('$user_id')</script>";die;
    $old_pass_sql="SELECT `password` FROM `users` WHERE password='$old_password' AND id='$user_id' ";
    $old_pass_query=mysqli_query($connection,$old_pass_sql);
    $result=mysqli_num_rows($old_pass_query);
    //echo "<script>alert('$result')</script>";die;
    if($result==1){
        $update_pass_sql="UPDATE `users` SET `password`='$new_password' WHERE id='$user_id'";
        $new_pass_query=mysqli_query($connection,$update_pass_sql);
        if($new_pass_query==true){
            // echo "<script>alert('sucess')</script>";
            // exit();
            $_SESSION['query'] = '
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>password</strong> updated successfully .
        </div>';
            header('location:reset_password.php');
        }
    }
    else{
        $_SESSION['query'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>Old</strong> password does not match!
        </div>';
        header('location:reset_password.php');
    }
}
?>
<div class="content-area">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Change Password</div>
                        <div class="panel-body">
                            <?php
                            echo $_SESSION['query'];
                            $_SESSION['query'] = null;
                            ?>
                            <form method="POST" action="" accept-charset="UTF-8" class="create_form_area"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $emp_id;?>">
                                <div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="name" class="col-md-12 col-form-label ">Old Password <span class="red">*</span></label>
                                            <div class="col-md-12">
                                                <input type="password" class="form-control" name="old_password"
                                                       required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-md-12 col-form-label ">New Password <span class="red">*</span></label>
                                            <div class="col-md-12">
                                                <input type="password" class="form-control" name="new_password"
                                                       required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="submit" name="submit" value="Update" class="btn btn-info">
                                            </div>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
include_once 'inc/footer.php';
?>
</body>
</html>