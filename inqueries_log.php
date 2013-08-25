<?php
include('db.php');
  $cdate=$_GET['cdate'];
 //$hosid=$_GET['hosid'];
 	
?>

<table cellpadding="5px" width="887" style="margin-top:7px;" align="center">
    <tr bgcolor="#8BB5EB">
        <td width="18" >SL</td>
		<td width="221" align="center"><strong>District </strong></td>
		<td width="221" align="center"><strong>Upozillas </strong></td>
		<td width="221" align="center"><strong>hospital </strong></td>
        <td width=128 align="center"><strong>Punched </strong> </td>
		<td width=128 align="center"><strong>Action </strong> </td>
    </tr>
    <?php	
$rs_result = mysql_query("SELECT DISTINCT(employees.hosid),hospitals.hosname FROM employees
LEFT JOIN hospitals ON employees.hosid=hospitals.hosid");

   $i=1;
   while ($row = mysql_fetch_assoc($rs_result)){
    $hosid = $row['hosid'];
  
   $headerinfo=mysql_query("select v.divname,d.disname,u.uponame,h.hosname from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	inner join hospitals as h on h.upoid=u.upoid where h.hosid='$hosid'");
	
	$row_header=mysql_fetch_assoc($headerinfo);
	$divname=$row_header['divname'];
	$disname=$row_header['disname'];
	$uponame=$row_header['uponame'];
	$hosname=$row_header['hosname'];
	
   $res_emp = mysql_query("SELECT hosid,COUNT(DISTINCT(staffid)) as emp_count FROM logs WHERE date(timing)= '$cdate' AND hosid = '$hosid' GROUP BY hosid");
  
		while($row_emp = mysql_fetch_assoc($res_emp))
        {
		
			$emp=$row_emp['emp_count'];
			 if($i%2==0)
                {
                ?>
                <tr style="background-color: #BDD9FD;">
                <?php 
                }else{
                    ?> 
                <tr style="background-color: #E6F2FF;">
                    <?php
                } ?>
					  <td> <?php echo $i;$i++; ?></td>
					  <td align="left" style="padding-left:5px;"><? echo $disname;?></td>
					  <td align="left" style="padding-left:5px;"><? echo $uponame;?></td>
					  <td align="left" style="padding-left:5px;"><? echo $hosname;?></td>
					  <td align="center"style="padding-left:5px;"><? echo $emp ?></td>    
					  <td align="center"style="padding-left:5px;"><a href="inqueries.php?cdate=<?php echo $cdate ;?>&hosid=<?php echo $hosid;?>">Detail</a></td>    					  
				</tr>				
			   <?php
			 
}	
}

?>

</table>

	

	

	