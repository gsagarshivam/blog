<?php 

ob_start();
@session_start();
?>

<?php
require 'conn.php';
$_SESSION['userid'] = NULL;
$_SESSION['role']= NULL;
unset($_SESSION['userid']);
unset($_SESSION['role']);
session_destroy();
header('Refresh:0;URL=login.php');
?>