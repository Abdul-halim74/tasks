<?php
$connection = mysqli_connect("dev.mysql.venturenxt.com","task","1qweqwe23");
//$connection = mysqli_connect("localhost", "root", "");
if (!$connection) {
    die("Database connection failed: " . mysqli_error());
}
$db_select = mysqli_select_db($connection,'task_management');
if (!$db_select) {
    die("Database selection failed: " . mysqli_error());
}

//live  server  connection
//$connection = mysqli_connect("localhost","root","Admin12345");
//if (!$connection) {
//    die("Database connection failed: " . mysqli_error());
//}
//$db_select = mysqli_select_db($connection,'vsl');
//if (!$db_select) {
//    die("Database selection failed: " . mysqli_error());
//}




  