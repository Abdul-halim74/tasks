<?php error_reporting(1);
session_start();
include_once 'inc/connection.php';
include_once 'inc/head.php';
?>
<body>

<div id="app" class="app">
    <?php include_once 'inc/sidebar.php'; ?>
    <div class="content-area">
        <div class="container-fluid">
           <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">Task Status Chart</div>
                        <div class="panel-body">
                            <canvas id="AdminChart"></canvas>
                        </div>
                    </div>
                </div>   
                <div class="col-md-6">
                    <div class="panel panel-default">
                     <div class="panel-heading">Attendance Chart View</div>
                        <div class="panel-body"> 
                                <canvas id="myChart"></canvas>
                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


<?php
include_once 'inc/footer.php';


?>
<?php
//TASK AS CREATED  BY
$my_user_id=$_SESSION['user_id'];
$user_role=$_SESSION['employee_role'];
$mytask_sql = "SELECT count(*) as cnt_leader FROM `developer_tasks` WHERE `created_user`=$my_user_id";
$mytask_sql_result = mysqli_query($connection, $mytask_sql);
$mytask=mysqli_fetch_array($mytask_sql_result);
?>
<?php
//Completed  task  count
if($user_role==3){
    $complete_sql = "SELECT *,FIND_IN_SET($my_user_id,team_member) FROM developer_tasks WHERE (FIND_IN_SET($my_user_id,team_member)!=0 or task_manager=$my_user_id) AND status=2";
}else{
    $complete_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND `status`='2'";
}
$complete__sql_result = mysqli_query($connection, $complete_sql);
$complete= mysqli_num_rows($complete__sql_result);
?>
<?php
//Expired task  count
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
<?php
//IN PROGRESS TASK COUNT
if($user_role==3){
    $inprogress_sql = "SELECT *,FIND_IN_SET($my_user_id,team_member) FROM developer_tasks WHERE (FIND_IN_SET($my_user_id,team_member)!=0 or task_manager=$my_user_id) AND status=1";
}else{
    $inprogress_sql = "SELECT * FROM `developer_tasks` WHERE (`task_manager`='$my_user_id' OR `created_user`='$my_user_id') AND `status`='1'";
}
$inprogress_sql_result = mysqli_query($connection, $inprogress_sql);
$inprogress= mysqli_num_rows($inprogress_sql_result);

//Make  data  list  variable
if($mytask['cnt_leader']>0){
    $leader=$mytask['cnt_leader'] ;
}else{
    $leader=0;
}
if($inprogress>0){
    $inprogress=$inprogress ;
}else{
    $inprogress=0;
}
if($expire>0){
    $expire=$expire ;
}else{
    $expire=0;
}
if($complete>0){
    $complete=$complete ;
}else{
    $complete=0;
}
 $data=$leader.','.$inprogress.','.$complete.','.$expire;
?>

<script>
    var canvas = document.getElementById('AdminChart');
    var data = {
        labels: ["Leader Task", "In Progress", "Completed Task", "Date Expired Task"],
        datasets: [
            {
                label: "Task Status Chart",
                backgroundColor: ['rgba(142, 36, 170, .6)', 'rgba(251, 140, 0, .6)', 'rgba(56, 142, 60, .6)', 'rgba(255, 87, 34, .6)'],
                borderColor: ["rgba(142, 36, 170, .7)", "rgba(251, 140, 0, .7)", "rgba(56, 142, 60, .7)", "rgba(255, 87, 34, .7)"],
                borderWidth: 1,
                hoverBackgroundColor: ["rgba(142, 36, 170, .8)", "rgba(251, 140, 0, .8)", "rgba(56, 142, 60, .8)", "rgba(255, 87, 34, .8)"],
                hoverBorderColor: ["rgba(142, 36, 170, .7)", "rgba(251, 140, 0, .7)", "rgba(56, 142, 60, .7)", "rgba(255, 87, 34, .7)"],
                data: [<?php echo $data;?>],
                //data: [2, 3, 4, 5],
            }
        ]
    };
    var option = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }]
        },
        animation: {
            duration: 5000
        }
    };
    Chart.Bar(canvas, {
        data: data,
        options: option
    });


</script>
   <script>
 var data = {
    labels: ["Present", "Absent","Late"],
  datasets: [{
    data: [0, 0,0],
    backgroundColor: [
      "#388e3c",
      "#ff5722",
      "#fb8c00"
    ],
    hoverBackgroundColor: [
      //"#FF6384",
      //"#36A2EB",
      //"#FFCE56"
    ]
  }]
};
var ctx = $("#myChart");
var myChart = new Chart(ctx, {
  type: 'pie',
  data: data
});
 </script>
</body>
</html>
