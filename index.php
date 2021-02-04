<?php error_reporting(1);
session_start();
include_once 'inc/connection.php';
include_once 'inc/head.php';
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
$message = "";

if (isset($_POST['email'])) {
    extract($_REQUEST);
    $password = md5($password);
    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password' LIMIT 1";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $data['email'];
        $_SESSION['name'] = $data['name'];
        $user_id = $data['id'];
        $_SESSION['user_id'] = $user_id;
        $employee_role_id = $data['employee_role'];
        $_SESSION['employee_role'] = $employee_role_id;
        $_SESSION['department_id'] =  $data['department_id'];

        if ($_SESSION['employee_role'] == '1') {
            $_SESSION['message'] = '<div class="alert alert-success">
    <a class="close" href="#" data-dismiss="alert">
    <i class="fa fa-times-circle"></i>
    </a>
    You  have  Successfully Log In.
    </div>';
            echo "<script>window.location.href='dashboard.php';</script>";
            //header('location: http://task.venturenxt.com/dashboard.php');
            exit();

        } elseif ($_SESSION['employee_role'] == "2") {
            $_SESSION['message'] = '<div class="alert alert-success">
    <a class="close" href="#" data-dismiss="alert">
    <i class="fa fa-times-circle"></i>
    </a>
    You  have  Successfully Log In.
    </div>';
            echo "<script>window.location.href='dashboard.php';</script>";
            //header('location: http://task.venturenxt.com/dashboard.php');
            exit();
        }elseif ($_SESSION['employee_role'] == "3") {
            $_SESSION['message'] = '<div class="alert alert-success">
    <a class="close" href="#" data-dismiss="alert">
    <i class="fa fa-times-circle"></i>
    </a>
    You  have  Successfully Log In.
    </div>';
            echo "<script>window.location.href='dashboard.php';</script>";
            exit();
        }
    }
    $message = '<div class="alert alert-warning">
    <a class="close" href="#" data-dismiss="alert">
    <i class="fa fa-times-circle"></i>
    </a>
    Username or Password  is  wrong.Please try again....
    </div>';
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <?php if ($message) { ?>
                        <div class="alert alert-warning">
                            <a class="close" href="#" data-dismiss="alert">
                                <i class="fa fa-times-circle"></i>
                            </a>
                            Email Or Password Error.
                        </div>
                        <?php
                    }
                    ?>
                    <form class="form-horizontal" method="POST" action="">
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required
                                       autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<body>
<?php
include_once 'inc/footer.php';
?>
</body>
</html>