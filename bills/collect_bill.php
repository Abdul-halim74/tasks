<?php error_reporting(1);
session_start();
include_once '../inc/connection.php';
include_once '../inc/head.php';
$userid = $_SESSION['user_id'];

if (isset($_POST['collect_bill'])) {
    extract($_REQUEST);
    $collection_date_value = date("Y-m-d", strtotime($collection_date));

    $sql = "INSERT INTO `collect_bills`(`project_id`,`amount`, `collection_date`) VALUES 
  ('$project_id','$amount','$collection_date_value')";
    $result = mysqli_query($connection, $sql);
    if ($result == 1) {
        $_SESSION['result'] = '
        <div class="alert alert-success fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Bill </strong>   Collection added Successfully.
        </div>
        ';
           echo "<script>window.location.href='collect_bill.php';</script>";
        //header('location:collect_bill.php');
        exit();

    } else {
        $_SESSION['result'] = '
        <div class="alert alert-danger fade in alert-dismissible" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong>Error</strong>   Check all field.
        </div>
          
        ';
        echo "<script>window.location.href='collect_bill.php';</script>";
        exit();
    }
}

?>
<body>

<div id="app" class="app">
    <?php include_once '../inc/sidebar.php'; ?>
</div>
<div class="content-area">

    <div class="container-fluid">
        <div class="container-fluid">
            <?php
            echo $_SESSION['result'];
            $_SESSION['result'] = null;
            ?>
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Collect Bill</div>
                        <div class="panel-body">
                            <form method="POST" action="" accept-charset="UTF-8" class="create_form_area bill-collect-form"
                                  enctype="multipart/form-data">

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label">Project Name <i class="red">*</i></label>
                                            <div class="col-md-12">
                                                <select name="project_id" id="project_id"
                                                        class="form-control text-capitalize" required>
                                                    <option value="">Select Project Name</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `bills`";
                                                    $result = mysqli_query($connection, $sql);
                                                    while ($list = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <option value="<?php echo $list['id']; ?>"><?php echo $list['project_name']; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div><!--END-->

                                        <div class="form-group row dependent">
                                            <label class="col-md-12 col-form-label">Total Bill Amount (TK). </label>
                                            <div class="col-md-12"> 
                                                 <div class="input-container green">
                                                 &#2547;
                                                    <input type="text" id="show_total_bill_payment"
                                                            class="input-field green readonly"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row dependent">
                                            <label class="col-md-12 col-form-label">Pending Bill Amount (TK).</label>
                                            <div class="col-md-12">
                                              <div class="input-container orange">
                                                 &#2547;
                                                    <input type="text" id="total_pending_bill_amount"
                                                            class="orange readonly"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label">Collected Bill Amount (TK).<i class="red">*</i></label>
                                            <div class="col-md-12">
                                                <input type="number" id="bill_amount"
                                                       placeholder="Collected  Bill Amount" name="amount"
                                                       class="form-control" required >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label">Collected Bill Date <i class="red">*</i></label>
                                            <div class="col-md-12">
                                                <input type="text" placeholder="Collected  Bill Date"
                                                       name="collection_date" class="form-control datepicker" value="<?php echo date('d-m-Y') ?>" required>
                                                <small> Day-Month-Year</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row mb-0">
                                    <br>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn  btn-info" name="collect_bill" id="collect_bill_btn">
                                            &nbsp;&nbsp;&nbsp; <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                              &nbsp;&nbsp;&nbsp;
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="panel panel-default bill-collection">
                        <div class="panel-heading">Bill Collection List Summary Last (10)</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Amount</th>
                                    <th>Collection Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $select_collect_bill="SELECT * FROM `collect_bills` INNER JOIN `bills` ON `collect_bills`.`project_id`=`bills`.`id` ORDER BY `collect_bills`.`id` DESC LIMIT 10";

                                    $collect_bill_query=mysqli_query($connection,$select_collect_bill);
                                    
                                    while ($data=mysqli_fetch_array($collect_bill_query)) {
                                      

                                      ?>
                                   
                                    
                                <tr>
                                    <td><a href="bill_details.php?project_id=<?php echo $data['id']; ?>"><?php echo $data['project_name']; ?></a></td>
                                    <td><b class="orange"> &#2547; <?php echo formatInBDTStyle($data['amount']); ?></b></td>
                                    <td><?php  echo date('jS   F Y  ', strtotime($data['collection_date'])); ?></td>
                                </tr>
                                   <?php
                                        }
                                      
                                        ?>

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
<?php
include_once '../inc/footer.php';
?>

<script>
    $(document).ready(function () {
      $(".dependent").hide();
        $("#project_id").change(function (e) {
            $(".dependent").hide();
            var projectID = $(this).val();
            if(projectID!==''){
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
             $(".dependent").show();
             }
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
        
        //CHECK Collected  bill amount  more  than  Amount

        
   
$('#bill_amount').keyup(function(){
    var pendingBill= $("#total_pending_bill_amount").val();
    var collectedAmount= $(this).val();
     if (parseInt(collectedAmount)>parseInt(pendingBill)){
         alert("Collected Bill Amount can not  be  greter than Pending Amount " + pendingBill);
        $(this).val(pendingBill);
     }else{
        
     }
});

</script>
</body>
</html>
