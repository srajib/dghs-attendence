 <?php 
	include('db.php');
	$upoid=$_GET['upoid'];
	$result=mysql_query("select hosid, hosname from hospitals where upoid=$upoid");  
	
	 while($row=mysql_fetch_array($result)) {
     $hosid=$row['hosid']; 
	 $hosid=$row['hosname'];
  }?> 