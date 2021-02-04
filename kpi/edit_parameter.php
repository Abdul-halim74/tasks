<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid =$_SESSION['user_id'];

if (isset($_POST['submit'])) {

 $select_emp = $_POST['select_emp'];

  $date = $_POST['date'];

  // $select_this_date_exist_data = "SELECT * FROM `offce_open_off` where `date`='$date'";

  // $exist_data_q = mysqli_query($connection, $select_this_date_exist_data);

  // if (mysqli_num_rows($exist_data_q)>0) {
  //       $_SESSION['result'] ='
  //       <div class="alert alert-danger fade in alert-dismissible" >
  //       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
  //       <strong>This Date Data  Already Exist !.</strong>  
  //       </div>
  //       ';

  //          echo "<script>window.location.href='office_open_off.php';</script>";
  //       exit();
  // }

   $insert_sql = "INSERT INTO `holiday_office` SET `emp_id`= '$select_emp', 
  `date`='$date', `entry_user`= '$userid' ";

  $insert_q = mysqli_query($connection, $insert_sql);

  if ($insert_q==1) {

            $_SESSION['result'] ='
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Data </strong>   Added Successfully.
        </div>
        ';

           echo "<script>window.location.href='holiday_office.php';</script>";
        exit();
  }
}

?>
<body>

<div id="app" class="app">
    <?php include_once  '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid">
        <div class="container-fluid">
          
            <div class="row">
           
            <div class="col-md-8">
                    <div class="panel panel-default bill-collection">
                        <div class="panel-heading">KPI Parameter Setup</div>
                        <div class="panel-body">

                          <form action="<?php echo $global_url; ?>/kpi/edit_parameter_submit.php" method="get">
                            
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                   
                                    <th>Marks Generate</th>
                                    <th>Holiday Office At least</th>
                                    <th>Overtime At least</th>
                                    
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $kpi_parameter_sql="SELECT * FROM `kpi_parameter`";

                                    $kpi_parameter_sql_query=mysqli_query($connection,$kpi_parameter_sql);
                                    
                                  $data=mysqli_fetch_array($kpi_parameter_sql_query);
                                   
                                    ?>
                                <tr>
                                    <td>  

                                      <input type="radio" name="month_or_date" 
                                        <?php   if($data['marks_generate']==1){echo "checked";}   ?> value="1"> 

                                        <label>Monthly : </label>

                                      <input type="radio" name="month_or_date"
                                      
                                        <?php if($data['marks_generate']==0){echo "checked";}  ?>

                                     value="0" > <label>Weekly / Daily :</label> 
                                    </td>

                                    <td><input type="text" name="holiday_office" value="<?php  echo $data['holiday_office']; ?>"> Days</td>

                                    <td><input type="text" name="hourse" value="<?php  echo $data['overtime']; ?>">   Hours  </td>

                                   
                                   <td><input type="submit" name="submit" class="btn btn-primary btn-sm" value="submit"></td>

                                </tr>
                                  

                                </tbody>
                            </table>

                          </form>
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
