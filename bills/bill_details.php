<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid = $_SESSION['user_id'];
$project_id=$_GET['project_id'];
?>
<body>

<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid bill-details">
        <div class="container-fluid">
            <?php
            echo $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
            <div class="row">
              
                
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Bill Details Show</div>
                        <div class="panel-body">
                        <div class="panel-group">
   
                      <div class="panel panel-warning ">
                        <div class="panel-heading"><?php  
                                                    $project_name="SELECT * FROM `bills` WHERE id='$project_id' ";
                                                    $project_name_query=mysqli_query($connection,$project_name);
                                                    $project_name_fetch=mysqli_fetch_array($project_name_query);
                    
                                                 ?>
                                                <h4>Project name : <span class="orange"><?php echo $project_name_fetch['project_name']; ?></span></h4>
                                                <h4>Total Recievable Amount : <b class="green"> &#2547; <?php echo formatInBDTStyle($project_name_fetch['receivable_amount']); ?></b></h4>
                                       </div>
                                        <div class="panel-body">
                                          <?php  
                                $project_name="SELECT * FROM `bills` WHERE id='$project_id' ";
                                $project_name_query=mysqli_query($connection,$project_name);
                                $project_name_fetch=mysqli_fetch_array($project_name_query);

                             ?>
                                  <table class="table table-reponsive table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bill Collection date</th>
                                        <th width="300px">Collected Amount</th>
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                      <?php
                                     $select_bill_details="SELECT * FROM `collect_bills`  inner  JOIN `bills` ON `collect_bills`.`project_id` = `bills`.`id` WHERE `bills`.id='$project_id' ";

                                    $select_bill_query=mysqli_query($connection,$select_bill_details);

                                    while($select_bill_fetch=mysqli_fetch_array($select_bill_query)){
                                        

                                        ?>
                                  

                                    <tr>
                                        
                                        <td><?php echo date('jS   F Y  ', strtotime($select_bill_fetch['collection_date'])); ?></td>
                                        <td><b class="orange"> &#2547; <?php echo formatInBDTStyle($select_bill_fetch['amount']);  ?></b></td>
                                        
                                    </tr>

                                    <?php

                                        }

                                    ?>
                                  <tr><th class="text-right">Total Collected Amount</th>
                                  <?php  
                                                    $total_bill_collected_sql="SELECT SUM(`amount`) as total_amount FROM `collect_bills` WHERE `project_id`='$project_id'";
                                                    $collection_query=mysqli_query($connection,$total_bill_collected_sql);
                                                    $total_bill_collection=mysqli_fetch_array($collection_query);
                    
                                                 ?>
                                  


                                   <th class="green">&#2547;  <?php echo formatInBDTStyle($total_bill_collection['total_amount']); ?></th></tr>
                                    <tr><th class="text-right"> Due Amount</th>
                                   <th class="red">&#2547; <?php echo formatInBDTStyle($project_name_fetch['receivable_amount']-$total_bill_collection['total_amount']); ?></th></tr>

                                </tbody>
                              
                            </table>
                                         </div>
                      </div>
</div>
                          
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
<script>
    $(document).ready(function () {

        $("#project_id").change(function (e) {
            var projectID = $(this).val();
            // alert(projectID);
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'ajax-find-project-bill.php',
                data: {id: projectID},
                success: function (response) {

                    var total_bill_amount = JSON.stringify(parseInt(response.total_bill_amount));
                    var collected_bill_amount = JSON.stringify(parseInt(response.total_collected_bill_amount));
                    //console.log(total_bill_amount,total_collected_bill_amount);
                    var total_pending_bill_amount = total_bill_amount - collected_bill_amount;
                    $('#show_total_bill_payment').val(total_bill_amount);
                    $('#total_pending_bill_amount').val(total_pending_bill_amount);
                },
            });
        });

        //check  bill  amount  is  less  than  pending amount
        //    $("#bill_amount").change(function() {
        //     console.log('ok');
        //     var total_pending_bill_amount =   $('#total_pending_bill_amount').val();
        //     var bill_amount =   $('#bill_amount').val();
        //     if(bill_amount>total_pending_bill_amount){
        //         alert("Bill Amount Can not  be big then  pending  bill  amount.")
        //     }
        // });
    });


</script>
</body>
</html>
