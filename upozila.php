 <?php 
	include('db.php');
	$disid=$_GET['disid'];
		
	$result=mysql_query("select upoid, uponame from upozilas where disid=$disid");  
	
	 echo "<pre>";
	 print_r($result);
	 echo "</pre>";
	?>
  
   <select name = "upoid" id="upoid" onchange="showHospital()>
    <option> Select Upozilas  </option>
	 <? while($row=mysql_fetch_array($result)) { ?>
       <option value="<? echo $row['upoid']; ?>"><? echo $row['uponame']; ?></option>
    <? }?> </select>