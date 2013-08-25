<?php 
/* error_reporting(E_ALL);
ini_set('display_errors','On');*/

include('db.php');
 $f_date1=$_GET['f_date1'];
 $f_date2=$_GET['f_date2'];
 $empcode=$_GET['empcode'];
 $department=$_GET['department'];
 
 /*$f_date1='2012-11-21';
 $f_date2='2012-11-25';
 $empcode='65';
 $department='MIS';*/
 
 //echo $sdate = substr($f_date1,8,2);
 //echo $edate = substr($f_date2,8,2);
 
session_start();
$_SESSION['file'] = time();
$filename = $_SESSION['file']."export.csv";

$fp = fopen($filename, "w"); 

$sqlhos = mysql_query("SELECT * FROM employees WHERE staffid='$empcode' AND department='$department'");
$rowhos = mysql_fetch_array($sqlhos);

$hosid = $rowhos['hosid'];

		
 $res = mysql_query("SELECT empcode,event_date,in_time,out_time,status FROM job_card WHERE hosid='$hosid' AND empcode='$empcode' AND event_date>='$f_date1' 
 AND event_date<='$f_date2'"); 

// fetch a row and write the column names out to the file 
$row = mysql_fetch_assoc($res); 
//echo mysql_num_rows($res);

$line = ""; 
$comma = ""; 
foreach($row as $name => $value) { 
   $line .= $comma . '"' . str_replace('"', '""', $name) . '"'; 
   $comma = ","; 
} 
$line .= "\n"; 
fputs($fp, $line); 

// remove the result pointer back to the start 
mysql_data_seek($res, 0);

// and loop through the actual data 
while($row = mysql_fetch_assoc($res)) { 
   
   $line = ""; 
   $comma = ""; 
   foreach($row as $value) { 
       $line .= $comma . '"' . str_replace('"', '""', $value) . '"'; 
       $comma = ","; 
   } 
   $line .= "\n"; 
   fputs($fp, $line); 
} 

fclose($fp); 
header("Content-type: text/csv"); 
header("Content-description: File Transfer"); 
header('Content-Disposition: attachment; filename='.$filename);
header("Pragma: public"); 
header("Cache-control: max-age=0"); 
header("Expires: 0");
ob_start();
$data = file_get_contents($filename);
ob_end_flush();
//echo $data;


//echo file_get_contents($filename);
session_destroy();
?>
