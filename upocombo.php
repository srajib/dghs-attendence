
    <?php 
	include('db.php');
	$disid=$_GET['disid'];
		
   	$query="select upoid,uponame from upozilas where disid = $disid";
    $result= mysql_query($query);
	//print_r($result);
		
	?>
	
	<?php
	  echo "1111" ;
	?>

	


