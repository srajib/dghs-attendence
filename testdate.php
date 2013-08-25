
    <?php 

	 $st=strtotime('2013-01-01');
	$en=strtotime('2013-01-05');
	for ($i = $st; $i <= $en; $i = $i + 86400) {
   echo $thisDate = date('Y-m-d ', $i);
	}
	

	?>
	
	
	
	


	
	

