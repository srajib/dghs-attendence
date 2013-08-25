<?php
$host = "10.10.10.5";
$user = "root";
$password = "M1$DB@2012'";
$dbname = "attendance_new_db";
$con = mysql_connect($host, $user, $password) or die(mysql_error());
mysql_select_db($dbname, $con);
?>