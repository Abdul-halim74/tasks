<?php error_reporting(0);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
 $userid =$_SESSION['user_id'];

 $month_and_year = $_POST['start'];




?>
<body>

<div id="app" class="app">
    <?php include_once  '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid">
        <div class="container-fluid">
          
            <div class="row">
            <div class="col-md-6 col-lg-6">
              <?php
            echo  $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Target Fillup Marks</div>
                    <div class="panel-body">
                        <form method="POST" action="" accept-charset="UTF-8" class="create_form_area" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">

                                   

                                   <?php
                                    $kpi_para_sql = "SELECT * FROM `kpi_parameter`";
                                    $kpi_q =mysqli_query($connection, $kpi_para_sql);

                                    $kpi_f = mysqli_fetch_array($kpi_q);

                                    if ($kpi_f['marks_generate'] == 1) {
                                       
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">Select Month and Year<i class="red">*</i></label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="month" id="start" name="start" min="2019-01" value="" required="">

                                       		<small> Month-Year</small>
                                        </div>
                                    </div><!--END-->

                                    <?php

                                     }elseif ($kpi_f['marks_generate'] == 0) {


                                        ?>
                                         
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">From date<i class="red">*</i></label>
                                        <div class="col-md-12">

                                            <input class="form-control" type="date" id="from_date" name="from_date" value="" required="">

                                           
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label">To date<i class="red">*</i></label>
                                        <div class="col-md-12">

                                            <input class="form-control" type="date" id="to_date" name="to_date" value="" required="">

                                           
                                        </div>
                                    </div>

                                    <?php

                                     }

                                   ?>
                                  

                                    
                                </div>

                            </div>
                            <div class="form-group row mb-0 ">
                              <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn  btn-info" name="search">
                                        &nbsp;&nbsp;&nbsp; <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp; Search &nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          
            </div>
  
            
		   </form>

            


            <?php
            if ($kpi_f['marks_generate'] == 1) {

                ?>

            <form action="<?php echo $global_url; ?>/kpi/others_mark_insert.php?month_and_year=<?php echo 
            $month_and_year; ?> " method="post" style="margin-bottom: 30px;">
            <?php
                if (isset($_POST['search'])) {

                        
                        $month_and_year = $_POST['start'];
                     $montOfTheYear = date('m', strtotime($month_and_year));
                      $year = date('Y', strtotime($month_and_year));

                    
                        

                     ?>
                

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> Others Mark :<?php  echo $month_and_year; ?></div>
                            <div class="panel-body">

                                <table class="table table-bordered">
                                    <tr>
                                        
                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        

                                        <th>Reporting / Shedule Marks</th>
                                        
                                        <th>Dress Code / Office Decorum Marks </th>

                                       
                                    </tr>

                                  
                                        
                                   <?php

                                   $select_emp_sql ="SELECT `id`, `name` FROM users";
                                   $select_emp_q = mysqli_query($connection, $select_emp_sql);
                                   
                                   $sl=0;
                                   while ($select_emp_f =mysqli_fetch_array($select_emp_q)) {
                                     $sl++;
                                   
                                        ?>

                                    <tr>
                                        
                                         <td><?php echo $sl; ?></td>

                                        <td><?php echo $select_emp_f['name']; ?></td>

                                       
                                       
                                        <td>6</td>

                                        <td>2</td>

                                        


                                    </tr>

                                    <?php

                                   }

                                   ?>


                                    
                                </table>

                                


                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" name="submit" class="btn btn-success">

          <?php  


            }

        
            ?>

            
           </form>

           <?php



        }
           ?>


          <!--  for weekly or daily  -->


           <?php
            if ($kpi_f['marks_generate'] == 0) {

                ?>

            <form action="<?php echo $global_url; ?>/kpi/others_mark_weekly_insert.php?from_date=<?php echo 
            $_POST['from_date']; ?>&to_date=<?php echo $_POST['to_date']; ?>&reporting=<?php  echo $_POST['reporting_marks']; ?> " method="post" style="margin-bottom: 30px;">

            <?php

                if (isset($_POST['search'])) {

                        
                      $from_date = $_POST['from_date'];
                      $to_date = $_POST['to_date'];

                     // $montOfTheYear = date('m', strtotime($month_and_year));
                     //  $year = date('Y', strtotime($month_and_year));

                    
                     ?>
                

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>From</strong> <?php echo $from_date ." <strong>to</strong> ". $to_date; ?> </div>
                            <div class="panel-body">

                            
                                <table class="table table-bordered">
                                    <tr>

                                        <th>Sl </th>
                                        <th>Emp Name </th>
                                        

                                        <th>Reporting / Shedule Marks</th>
                                        
                                        <th>Dress Code / Office Decorum Marks </th>

	                          </tr>

	                          	<?php

                                   $select_emp_sql ="SELECT `id`, `name` FROM users";
                                   $select_emp_q = mysqli_query($connection, $select_emp_sql);
                                   
                                   $sl=0;
                                   while ($select_emp_f =mysqli_fetch_array($select_emp_q)) {
                                     $sl++;
                                   
                                        ?>

                                    <tr>
                                        
                                         <td><?php echo $sl; ?></td>

                                        <td><?php echo $select_emp_f['name']; ?></td>

                                       
                                       
                                        <td>6</td>

                                        <td>2</td>

                                        


                                    </tr>

                                    <?php

                                   }

                                   ?>

                                </table>

                                


                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" name="submit" class="btn btn-success">

          <?php  


            }

        
            ?>

            
           </form>

           <?php

        
        }
           ?>

        </div>
    </div>
</div>

</div>
<?php
include_once '../inc/footer.php';
?>
</body>
</html>
