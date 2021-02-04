<?php
require('global_url_setup.php');
require('taka_formatter.php');
date_default_timezone_set('Asia/Dhaka');

 $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($actual_link != $global_url . "/index.php") {
    if (!isset($_SESSION["name"])) {
        header("Location:" . $global_url . "/index.php");
        die();
    }else{
      //echo "string";die;
        //check  page access  for  all  users
      //if($_SESSION["employee_role"] !='1'){
         $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          $last_url_part = str_replace($global_url."/",'', $actual_link);

          if(strpos($last_url_part, "?") == true){
              $last_url_part = preg_replace('/.php.*/', '.php', $last_url_part);
          }else{
              $last_url_part;
          }

//$pagename= basename($_SERVER['PHP_SELF']);
           $pagename= $last_url_part;
          $find_page_sql = "SELECT * FROM `pages` WHERE `file_link` = '$pagename' ";
          $page_query = mysqli_query($connection, $find_page_sql);
          $pageinfo = mysqli_fetch_array($page_query);
           $this_page_id= $pageinfo['id'];


          $user_id=$_SESSION["user_id"];
          $access_sql = "SELECT * FROM `page_roles` WHERE `user_id`=$user_id";
          $access_query = mysqli_query($connection, $access_sql);
          $access_lists = mysqli_fetch_array($access_query);
          $role_ids= $access_lists['pages_id_list'];
          $my_role_Array = explode(',',$role_ids);


          if (in_array($this_page_id, $my_role_Array)) {
          }else{
              header('location:'.$global_url."/404.php");
              exit();
          }
     // }
    }
}


//?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <title>Venture Solutions LTD</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/f2988b3c12.js">
    </script>
    <script src="<?php echo $global_url; ?>/js/bootstrap-datepicker.js"></script>

    <script src="<?php echo $global_url; ?>/js/summernote.min.js"></script>
    <script src="<?php echo $global_url; ?>/js/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>

    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>-->
    <!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="<?php echo $global_url; ?>/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="<?php echo $global_url; ?>/css/datatables.min.css" rel="stylesheet">
    <link href="<?php echo $global_url; ?>/css/summernote.css" rel="stylesheet">
    <link href="<?php echo $global_url; ?>/css/custom.css" rel="stylesheet">


<!-- Abdul Halim code -->

    <script src="<?php  echo $global_url; ?>/js/bootstrap-select.min.js"></script>
<link href="<?php echo $global_url; ?>/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Abdul Halim code -->
</head>
<body>