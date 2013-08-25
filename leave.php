<?php
include('db.php');
$hosid=$_GET['hosid'];
$cdate=$_GET['cdate'];
$date2=$_GET['date2'];
$staffid=$_GET['staffid'];

    $headerinfo=mysql_query("select v.divname,d.disname,u.uponame,h.hosname from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	inner join hospitals as h on h.upoid=u.upoid where h.hosid='$hosid'");
	
	$row_header=mysql_fetch_assoc($headerinfo);
	$divname=$row_header['divname'];
	$disname=$row_header['disname'];
	$uponame=$row_header['uponame'];
	$hosname=$row_header['hosname'];
		   
	
?>
<div id="colorbox" style="border:double; border-color:#AFDBFE; width:950px; padding:5px;margin:0 auto;" >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >Leave Report</font></strong>"; ?> </div>
	<div><?php echo " <strong> Division : </strong> $divname | ","<strong> District : </strong> $disname |"," <strong> Upozila : </strong> $uponame |"," <strong> Oranization : </strong> $hosname"; ?></div>
	<div><?php echo " <strong> Report Date : </strong> $cdate  to $date2  ";?>
</div>

<table cellpadding="5px" width="955" style="margin-top:7px;" align="center">
    <tr bgcolor="#8BB5EB">
        <td width="18" >SL</td>
		<td width="65" align="center"><strong>Staff ID</strong></td>
		<td width="158" align="center"><strong>Name of Staff </strong></td>
        <td width=170 align="center"><strong>Designation</strong></td>
        <td width=80 align="center">Date from </td>
		<td width=80 align="center"><strong>Date to</strong> </td>
		<td width=50 align="center"><strong> Leave name</strong> </td>
		<td width=50 align="center"><strong>Total Day</strong> </td>
		<td width=50 align="center"><strong>Day Taken</strong> </td>
		<td width=65px; align="center">Available Leave</td>
		<td width=103 align="center"><strong> Reason</strong> </td>
		
    </tr>

    <?php	
if(!empty($staffid)){			
 $res_emp = mysql_query(" select * from leave_app where hosid='$hosid' and lv_fromdate>='$cdate' and lv_todate<='$date2' and leave_issued='A' and staffid in($staffid) order by staffid ");
 }else {
  $res_emp = mysql_query(" select * from leave_app where hosid='$hosid' and lv_fromdate>='$cdate' and lv_todate<='$date2' and leave_issued='A' order by staffid ");
 }
 
   
	         $i=1;
			 while($row_emp = mysql_fetch_assoc($res_emp))
            {
			$staffid=$row_emp['staffid'];
			$lvid=$row_emp['lvid'];
			$date1=$row_emp['lv_fromdate'];
			$date2=$row_emp['lv_todate'];
			$daysdiff= (strtotime($date2) - strtotime($date1));
		     $diff1=round(($daysdiff/86400)+0.5);	 
			$leav_name=mysql_query("select lvname,allocated_day from leave_info where lvid='$lvid'");
			$lvname_row=mysql_fetch_assoc($leav_name);
			$lvname=$lvname_row['lvname'];
			$allocatedday=$lvname_row['allocated_day'];
			
			$lv_avilable=$allocatedday - $diff1;
						
	        $res_absent = mysql_query("SELECT empname,staffid,designation FROM employees WHERE hosid ='$hosid' and staffid='$staffid'");
	      //$row_absent = mysql_fetch_assoc($res_absent);
		   while($row_absent = mysql_fetch_assoc($res_absent)){
		   $staffid=$row_absent['staffid'];
		   $name=$row_absent['empname'];
		   $designation=$row_absent['designation'];	
		}
				 			
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
					  <td align="left" style="padding-left:5px;"><? echo $row_emp['staffid'];?></td>
					  <td align="left"  style="padding-left:5px;"><? echo $name;?></td>
					   <td align="left"  style="padding-left:5px;"><? echo $designation ;?></td>
					  <td align="center"  style="padding-left:5px;"><? echo $row_emp['lv_fromdate'];?></td>
					  <td align="center"style="padding-left:5px;"><? echo $row_emp['lv_todate'];?></td>
					  <td align="center"style="padding-left:5px;"><? echo  $lvname;?></td>
					   <td align="center"style="padding-left:5px;"><? echo $allocatedday;?></td>
					   <td align="center"style="padding-left:5px;"><? echo  $diff1;?></td>
					    <td align="center"style="padding-left:5px;"><? echo $lv_avilable;?></td>
					  <td align="center"style="padding-left:5px;"><? echo  $row_emp['reason'];?></td>              
				</tr>				
			   <?php
}	
?>
</table>
	

	

	