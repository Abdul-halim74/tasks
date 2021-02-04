<?php 
 session_start(); 
session_destroy();  
unset($_SESSION['employee_role']);
unset($_SESSION['user_id']);
unset($_SESSION['name']); 
unset($_SESSION['email']);
unset($_SESSION['department_id']);
header("Location: index.php");
