<nav class="navbar navbar-default navbar-fixed-top">

    <div class="container-fluid">
 
        <div id="navbar" class="navbar-collapse  right-top-menu">
   <button class="pull-left linebar" >
  <i class="fa fa-angle-double-right" aria-hidden="true"></i>
   </button>
            <ul class="nav navbar-nav navbar-right">

                <!-- Authentication Links -->

                <li class="notific" title="Task As Leader">

                    <img src="<?php echo $global_url ?>/images/bell-2.png">

                    <?php

                    $my_user_id=$_SESSION['user_id'];

                    $user_role=$_SESSION['employee_role'];

                   

                    $mytask_sql = "SELECT count(*) as cnt_leader FROM `developer_tasks` WHERE `created_user`=$my_user_id";

                    $mytask_sql_result = mysqli_query($connection, $mytask_sql);

                    $mytask=mysqli_fetch_array($mytask_sql_result);

                    ?>



                    <span class="one"><?php if($mytask['cnt_leader']>0){ echo $mytask['cnt_leader'] ;}else{ echo "0";} ?></span>

                </li>

                <li class="notific" title="In Progress Task">

                    <img src="<?php echo $global_url ?>/images/bell-progress.png">

                    <?php

                    if($user_role==3){

                         $inprogress_sql = "SELECT *,FIND_IN_SET($my_user_id,team_member) FROM developer_tasks WHERE (FIND_IN_SET($my_user_id,team_member)!=0 or task_manager=$my_user_id) AND status=1";

                        

                    }else{

                       $inprogress_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND `status`='1'";



                    }

                    

                   $inprogress_sql_result = mysqli_query($connection, $inprogress_sql);

                    $inprogress= mysqli_num_rows($inprogress_sql_result);

                    ?>

                    <span class="two"><?php if($inprogress>0){ echo $inprogress;}else{ echo "0";} ?></span>

                </li>



                <li class="notific" title="Completed Task">

                    <img src="<?php echo $global_url ?>/images/bell-green.png">

                    <?php

                    

                   if($user_role==3){

                    $complete_sql = "SELECT *,FIND_IN_SET($my_user_id,team_member) FROM developer_tasks WHERE (FIND_IN_SET($my_user_id,team_member)!=0 or task_manager=$my_user_id) AND status=2";

                    }else{

                      $complete_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND `status`='2'";

                    }

                    $complete__sql_result = mysqli_query($connection, $complete_sql);

                    $complete= mysqli_num_rows($complete__sql_result);

                    ?>

                    <span class="three"><?php if($complete>0){ echo $complete;}else{ echo "0";} ?></span>

                </li>

                <li class="notific" title="Date Expired Task">

                    <img src="<?php echo $global_url ?>/images/bell-4.png">

                    <?php

                    $curdate=date();

                    if($user_role==3) {

                        $expire_sql ="SELECT * FROM `developer_tasks` WHERE (delivery_date < CURRENT_DATE OR user_updated_date > delivery_date) AND (FIND_IN_SET($my_user_id,team_member) OR task_manager=$my_user_id)  AND status=1";  

                    }else{

                     

                      $expire_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND (delivery_date < CURRENT_DATE OR user_updated_date > delivery_date) AND status=1";

                   // $expire_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND `user_updated_date`=NUll OR `user_updated_date`>$curdate";

               

                    }

                    $expire_sql_result = mysqli_query($connection, $expire_sql);

                    $expire= mysqli_num_rows($expire_sql_result);

                    ?>

                    <span class="four"><?php if($expire>0){ echo $expire;}else{ echo "0";} ?></span>

                </li>

                <li class="dropdown mr15 hidden-xs">

                    <a id="navbarDropdown" class=" text-right nav-link dropdown-toggle  " href="#"

                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                        <?php

                        $emp_id = $_SESSION['user_id'];

                        $profile_sql = "SELECT `photo` FROM `employees` WHERE user_id='$emp_id'";

                        $profile_query = mysqli_query($connection, $profile_sql);

                        $profile_fetch = mysqli_fetch_array($profile_query);

                        ?>

                        <div class="pull-right"><img class="img-thumbnail img-circle ml10"

                                                     src="<?php echo $global_url; ?>/employee/images/<?php echo $profile_fetch['photo']; ?>"

                                                      style="width: 40px !important; height: 40px !important;"></div>

                        <div class="pull-right u-info">

                            Welcome <b>  <?php echo $_SESSION['name']; ?> </b> <br>

                            <?php

                            if ($_SESSION['employee_role'] == 1 || $_SESSION['employee_role'] == 2) {

                                ?>

                                <span class="position"><i class="fa fa-shield" aria-hidden="true"></i> Manager</span>

                            <?php } elseif ($_SESSION['employee_role'] == 3) {

                                echo "<span class='position'><i class=\"fa fa-shield\" aria-hidden=\"true\"></i> Executive</span>";

                            } else {

                            } ?>

                        </div>

                    </a>

                    <ul class="dropdown-menu " role="menu">

                        <li>

                            <a href="<?php echo $global_url; ?>/employee/myprofile.php">

                                <i class="fa fa-user-o" aria-hidden="true"></i> &nbsp; My Profile

                            </a>



                        </li>
                        <li>

                            <a href="<?php echo $global_url; ?>/reset_password.php">
                                <i class="fa fa-lock" aria-hidden="true"></i> &nbsp; Change Password
                            </a>

                        </li>

                        <?php if ($_SESSION['name']) { ?>

                            <li><a href="<?php echo $global_url; ?>/logout.php" class="nav-link"><i

                                            class="fa fa-sign-out"

                                            aria-hidden="true"></i> &nbsp; Logout</a></li>

                        <?php } ?>

                    </ul>



                </li>





            </ul>

        </div><!--/.nav-collapse -->

    </div>

</nav>
    <?php
    $emp_id = $_SESSION['user_id'];
    $profile_sql = "SELECT `photo` FROM `employees` WHERE user_id='$emp_id'";
    $profile_query = mysqli_query($connection, $profile_sql);
    $profile_fetch = mysqli_fetch_array($profile_query);
    ?>
<div id="sidebar" class="text-center">
    <a href="<?php echo $global_url; ?>/dashboard.php" class="logo"><img
                src="http://venturesolutionsltd.com/wp-content/themes/ventureWp/assets/images/logo.png"
                height="57px" alt="Logo"></a>
    <div class="menus">
        <ul>
              <li class="visible-xs">  Welcome <b>  <?php echo $_SESSION['name']; ?> </b> <br>

                            <?php

                            if ($_SESSION['employee_role'] == 1 || $_SESSION['employee_role'] == 2) {

                                ?>

                                <span class="position"><i class="fa fa-shield" aria-hidden="true"></i> Manager</span>

                            <?php } elseif ($_SESSION['employee_role'] == 3) {

                                echo "<span class='position'><i class=\"fa fa-shield\" aria-hidden=\"true\"></i> Executive</span>";

                            } ?>
                            <br />
                            </li>
            <?php

            $user_id = $_SESSION['user_id'];

            $sql = "SELECT * FROM `page_roles`  WHERE user_id=$user_id";

            $result = mysqli_query($connection, $sql);

            $data = mysqli_fetch_assoc($result);

            $id_lists = $data['pages_id_list'];

            ?>



            <!--SIDEBAR ACTIVE CLASSS DEPENDING ONLY FILE NAME  NO  FOLDER OR  OTHER THINGS SO FILENAME NEED TO BE UNIQUE-->

            <?php

            $my_role_Array = explode(',', $id_lists);

            if (in_array('5', $my_role_Array)) {

                ?>

                <li class="nl1 <?php if (basename($_SERVER['PHP_SELF']) == "dashboard.php") {

                    echo "active";

                } ?> "><a href="<?php echo $global_url; ?>/dashboard.php"><i class="fa fa-bar-chart"

                                                                             aria-hidden="true"></i> Dashboard</a></li>

            <?php } ?>



            <?php

            if (in_array('7', $my_role_Array) || in_array('8', $my_role_Array)) {

                ?>

                <li class="smenu  <?php if (basename($_SERVER['PHP_SELF']) == "index.php" || basename($_SERVER['PHP_SELF']) == "new_employee.php") {

                    echo "active";

                } ?>">

                    <a href="#" class="green open "><i class="fa fa-users" aria-hidden="true"></i> Employee <i

                                class="fa fa-angle-down pull-right mr10"></i></a>

                    <ul class="subs">

                        <?php

                        if (in_array('7', $my_role_Array)) {

                            ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "index.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/employee/index.php"><i class="fa fa-user-o"

                                                                                             aria-hidden="true"></i> All

                                    Employee List </a></li>

                        <?php }

                        if (in_array('8', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "new_employee.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/employee/new_employee.php"><i

                                            class="fa fa-plus-square-o"

                                            aria-hidden="true"></i> Add New Employee </a></li>

                        <?php } ?>





                    </ul>

                </li>

            <?php } ?>



            <?php

            if (in_array('1', $my_role_Array) || in_array('2', $my_role_Array) || in_array('16', $my_role_Array) || in_array('18', $my_role_Array)) {

                ?>

                <li class="smenu  <?php if (basename($_SERVER['PHP_SELF']) == "index-task.php" || basename($_SERVER['PHP_SELF']) == "create_developer_task.php") {

                    echo "active";

                } ?>">

                    <a href="#" class="green open "><i class="fa fa-tasks" aria-hidden="true"></i> Tasks <i

                                class="fa fa-angle-down pull-right mr10"></i></a>

                    <ul class="subs">
 

                        <?php 
                        
                        if (in_array('18', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "index-task.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/task/index-developer.php"><i

                                            class="fa fa-circle-thin"

                                            aria-hidden="true"></i> All Task</a></li>

                        <?php } ?>





                        <?php if (in_array('1', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "create_developer_task.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/task/create_developer_task.php"><i

                                            class="fa fa-circle-thin" aria-hidden="true"></i> Create New Tasks</a></li>

                        <?php } ?>



                    </ul>

                </li>

            <?php } ?>





            <?php

            if (in_array('9', $my_role_Array) || in_array('10', $my_role_Array) || in_array('11', $my_role_Array) || in_array('12', $my_role_Array)) {

                ?>



                <li class="smenu  <?php if (basename($_SERVER['PHP_SELF']) == "index-bill.php" || basename($_SERVER['PHP_SELF']) == "index-bill-collection.php" || basename($_SERVER['PHP_SELF']) == "collect_bill.php" || basename($_SERVER['PHP_SELF']) == "create_bill.php") {

                    echo "active";

                } ?>">

                    <a href="#" class="green open "><i class="fa fa-file-text-o" aria-hidden="true"></i> Bills <i

                                class="fa fa-angle-down pull-right mr10"></i></a>

                    <ul class="subs">



                        <?php if (in_array('11', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "index-bill.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/bills/index-bill.php"><i class="fa fa-tags"

                                                                                               aria-hidden="true"></i>

                                    All Bill

                                    List</a></li>

                        <?php } ?>



                        <?php if (in_array('10', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "create_bill.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/bills/create_bill.php"><i

                                            class="fa fa-plus-square-o"

                                            aria-hidden="true"></i> Add New

                                    Bill</a></li>

                        <?php } ?>
 

                        <?php if (in_array('12', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "index-bill-collection.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/bills/index-bill-collection.php"><i

                                            class="fa fa-tags"

                                            aria-hidden="true"></i>

                                    All Collected Bill List</a></li>

                        <?php } ?>

                        <?php if (in_array('9', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "collect_bill.php") {

                                echo "active";

                            } ?>"><a href="<?php echo $global_url; ?>/bills/collect_bill.php"><i

                                            class="fa fa-plus-square-o"

                                            aria-hidden="true"></i> New

                                    Bill Collect</a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
  
            <!--Start sub-->
                <?php
            if (in_array('29', $my_role_Array) || in_array('30', $my_role_Array) || in_array('31', $my_role_Array)) {
                ?>
                <li class="smenu  <?php if (basename($_SERVER['PHP_SELF']) == "attendance.php" || basename($_SERVER['PHP_SELF']) == "attendance_list.php" || basename($_SERVER['PHP_SELF']) == "attendance_report.php") {
                    echo "active";
                } ?>">
                    <a href="#" class="green open "><i class="fa fa-address-book-o" aria-hidden="true"></i> Attendance <i class="fa fa-angle-down pull-right mr10"></i></a>
                    <ul class="subs">
                        <?php
                        if (in_array('29', $my_role_Array)) {
                            ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "attendance.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/attendance/attendance.php"><i class="fa fa-user-o" aria-hidden="true"></i> Give Attendance </a></li>
                        <?php }
                        if (in_array('30', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "attendance_list.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/attendance/attendance_list.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Attendance List </a></li>
                        <?php }  if (in_array('31', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "attendance_report.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/attendance/attendance_report.php"><i class="fa fa-circle-o" aria-hidden="true"></i> Attendance Report </a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>


          
            <!--end sub-->


             <!--Start kpi-->

              <?php

            if (in_array('33', $my_role_Array) || in_array('35', $my_role_Array) || in_array('39', $my_role_Array) || in_array('45', $my_role_Array) || in_array('48', $my_role_Array) 
                || in_array('51', $my_role_Array) || in_array('52', $my_role_Array) || in_array('57', $my_role_Array)) {

                ?>
                <li class="smenu  <?php if ( basename($_SERVER['PHP_SELF']) == "attendance_mark.php" || basename($_SERVER['PHP_SELF']) == "daily_time.php"  || basename($_SERVER['PHP_SELF']) == "holiday_office_marks.php" || basename($_SERVER['PHP_SELF']) == "overtime_marks.php" || basename($_SERVER['PHP_SELF']) == "target_fillup_marks.php" || basename($_SERVER['PHP_SELF']) == "regular_support_marks.php" || basename($_SERVER['PHP_SELF']) == "others_mark.php" || basename($_SERVER['PHP_SELF']) == "all_mark.php") {
                    echo "active";
                } ?>">
                    <a href="#" class="green open "><i class="fa fa-address-card" aria-hidden="true"></i> KPI <i class="fa fa-angle-down pull-right mr10"></i></a>
                    <ul class="subs">

                

                      <?php
                       
                        if (in_array('33', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "attendance_mark.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/attendance_mark.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Attendance Marks </a></li>

                      <?php }

                      if (in_array('35', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "daily_time.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/daily_time.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Daily Time Marks</a></li>
                      <?php } ?>


                     

                      <?php

                      if (in_array('39', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "holiday_office_marks.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/holiday_office_marks.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Holiday Office Marks </a></li>
                      <?php } ?>


                      <?php

                      if (in_array('45', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "overtime_marks.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/overtime_marks.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Overtime Marks </a></li>
                      <?php } ?>

                       <?php

                      if (in_array('48', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "target_fillup_marks.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/target_fillup_marks.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Target Fillup Marks </a></li>
                      <?php } ?>


                       <?php

                      if (in_array('51', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "regular_support_marks.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/regular_support_marks.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Regular Support Marks</a></li>

                      <?php } ?>

                      <?php

                      if (in_array('52', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "others_mark.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/others_mark.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Others Mark</a></li>

                      <?php } ?>

                      <?php

                      if (in_array('57', $my_role_Array)) { ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "all_mark.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/all_mark.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> All Marks</a></li>

                      <?php } ?>
                                                
                       
                    </ul>
                </li>
           
<?php  } ?>
            <!--end kpi-->


             <!--Start kpi-->

             <?php

            if (in_array('38', $my_role_Array) || in_array('32', $my_role_Array) || in_array('37', $my_role_Array)  || in_array('64', $my_role_Array) ) {

                ?>
               
                <li class="smenu  <?php if (basename($_SERVER['PHP_SELF']) == "office_open_off.php"  || basename($_SERVER['PHP_SELF']) == "holiday_office.php" || basename($_SERVER['PHP_SELF']) == "parameter.php" || basename($_SERVER['PHP_SELF']) == "overtime.php" || basename($_SERVER['PHP_SELF']) == "on_duty.php") {

                    echo "active";
                } ?>">
                    <a href="#" class="green open "><i class="fa fa-cogs" aria-hidden="true"></i> Setting <i class="fa fa-angle-down pull-right mr10"></i></a>
                    <ul class="subs">

                         <?php

                      if (in_array('38', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "parameter.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/parameter.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> KPI Parameter Setup </a></li>
                      <?php } ?>


                      <?php
                        if (in_array('32', $my_role_Array)) {
                            ?>

                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "office_open_off.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/office_open_off.php"><i class="fa fa-user-o" aria-hidden="true"></i> Office Open / Off </a></li>
                         <?php } ?>
                     
                            <?php

                      if (in_array('37', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "holiday_office.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/holiday_office.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Holiday Office </a></li>
                      <?php } 

                      ?>  

                       <?php

                      if (in_array('64', $my_role_Array)) { ?>
                            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "on_duty.php") {
                                echo "active";
                            } ?>"><a href="<?php echo $global_url; ?>/kpi/on_duty.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i> On Duty </a></li>

                      <?php } 

                      ?>  
                       
                       
                    </ul>
                </li>
           
                <?php  } ?>

          
            <!--end kpi-->


              <!--Start sub-->
<!--            --><?php
//            if (in_array('31', $my_role_Array) || in_array('32', $my_role_Array)|| in_array('33', $my_role_Array)|| in_array('34', $my_role_Array)|| in_array('35', $my_role_Array)|| in_array('36', $my_role_Array)) {
//                ?>
<!--                <li class="smenu  --><?php //if (basename($_SERVER['PHP_SELF']) == "leave.php" || basename($_SERVER['PHP_SELF']) == "leave_lists.php" || basename($_SERVER['PHP_SELF']) == "approved_leave_lists.php" || basename($_SERVER['PHP_SELF']) == "decline_leave_lists.php" || basename($_SERVER['PHP_SELF']) == "pending_leave_lists.php") {
//                    echo "active";
//                } ?><!--">-->
<!--                    <a href="#" class="green open "><i class="fa fa-address-book-o" aria-hidden="true"></i> Leave <i class="fa fa-angle-down pull-right mr10"></i></a>-->
<!--                    <ul class="subs">-->
<!--                        --><?php
//                        if (in_array('33', $my_role_Array)) {
//                            ?>
<!--                            <li class="--><?php //if (basename($_SERVER['PHP_SELF']) == "leave.php") {
//                                echo "active";
//                            } ?><!--"><a href="--><?php //echo $global_url; ?><!--/leave/leave.php"><i class="fa fa-circle-thin" aria-hidden="true"></i> Take Leave  </a></li>-->
<!--                        --><?php //}
//                        if (in_array('35', $my_role_Array)) { ?>
<!--                            <li class="--><?php //if (basename($_SERVER['PHP_SELF']) == "leave_lists.php") {
//                                echo "active";
//                            } ?><!--"><a href="--><?php //echo $global_url; ?><!--/leave/leave_lists.php"><i class="fa fa-circle-thin" aria-hidden="true"></i> Leave List </a></li>-->
<!--                        --><?php //} if (in_array('31', $my_role_Array)) { ?>
<!--                            <li class="--><?php //if (basename($_SERVER['PHP_SELF']) == "approved_leave_lists.php") {
//                                echo "active";
//                            } ?><!--"><a href="--><?php //echo $global_url; ?><!--/leave/approved_leave_lists.php"><i class="fa fa-circle-thin" aria-hidden="true"></i>Approve  Leave List </a></li>-->
<!--                        --><?php //} if (in_array('32', $my_role_Array)) { ?>
<!--                            <li class="--><?php //if (basename($_SERVER['PHP_SELF']) == "decline_leave_lists.php") {
//                                echo "active";
//                            } ?><!--"><a href="--><?php //echo $global_url; ?><!--/leave/decline_leave_lists.php"><i class="fa fa-circle-thin" aria-hidden="true"></i>Decline   Leave List </a></li>-->
<!--                        --><?php //} if (in_array('36', $my_role_Array)) { ?>
<!--                            <li class="--><?php //if (basename($_SERVER['PHP_SELF']) == "pending_leave_lists.php") {
//                                echo "active";
//                            } ?><!--"><a href="--><?php //echo $global_url; ?><!--/leave/pending_leave_lists.php"><i class="fa fa-circle-thin" aria-hidden="true"></i>Pending   Leave List </a></li>-->
<!--                        --><?php //} ?>
<!--                    </ul>-->
<!---->
<!--                </li>-->
<!--            --><?php //} ?><!-- -->
            <!--end sub-->
      <!--SMALL MOBILE MENU-->
               <li class="visible-xs">
                    <a href="<?php echo $global_url; ?>/employee/myprofile.php">
                        <i class="fa fa-user-o" aria-hidden="true"></i> &nbsp; My Profile
                    </a>
                </li>
                <li class="visible-xs">
                    <a href="<?php echo $global_url; ?>/reset_password.php">
                        <i class="fa fa-lock" aria-hidden="true"></i> &nbsp; Change Password
                    </a>
                </li>
                <?php if ($_SESSION['name']) { ?>
                     <li class="visible-xs"><a href="<?php echo $global_url; ?>/logout.php" class="nav-link"><i
                                    class="fa fa-sign-out"
                                    aria-hidden="true"></i> &nbsp; Logout</a></li>
                <?php } ?>
                <!--END SMALL MOBILE MENU--> 
        </ul>
    </div>
</div>