<?php 
  
include('db.php'); 
/*// Connect to the database 
$link = mysql_connect($host, $user, $pass); 
mysql_select_db($db,$link); 
  
include('exportcsv.inc.php'); 
  
$table="users"; // this is the tablename that you want to export to csv from mysql. 
  
exportMysqlToCsv($table);*/ 
 
$filename = 'export.csv'; 
 
$fp = fopen($filename, "w"); 
 
$res = mysql_query("SELECT * FROM "); 
 
// fetch a row and write the column names out to the file 
$row = mysql_fetch_assoc($res); 
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
  
?>
William Gomes
