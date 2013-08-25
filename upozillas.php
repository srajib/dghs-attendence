
    <?php 
	include('db.php');
	 $upoid=$_GET['upoid'];
	 $cdate=$_GET['cdate'];
	 $date2=$_GET['date2'];
	 $diff = abs(strtotime($date2) - strtotime($cdate));
	 $year = substr($date2,0,4);
	 $month = substr($date2,5,2);
		
	$headerinfo=mysql_query("select v.divname,d.disname,u.uponame,h.hosname from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	inner join hospitals as h on h.upoid=u.upoid where v.divid=d.divid and u.upoid='$upoid'");
	$row_header=mysql_fetch_assoc($headerinfo);
	$divname=$row_header['divname'];
	$disname=$row_header['disname'];
	$uponame=$row_header['uponame'];
	
   
    ?>
	<div id="colorbox" style="border:double; border-color:#AFDBFE;width:878px; padding:5px;margin:0 auto;" >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >District Attendance Summery Report</font></strong>"; ?> </div>
	<div><?php echo " <strong> Division : </strong> $divname "; ?></div>
	<div><?php echo " <strong> District  : </strong> $disname "; ?></div>
	<div><?php echo " <strong> Upozilla  : </strong> $uponame "; ?></div>
	<div><?php echo " <strong> Report Date  : </strong> $cdate"," To $date2 "; ?></div>
</div>	
	<table width="890px" border="1" cellpadding="10">
	<tr align="center" style="background-color:#3689E4">
	<td>Organization</td>
	<td>Total Staff</td>
	<td>TWDay</td>
	<td>Present</td>
	<td>Absent</td>
	<td>Offday</td>
	<td>Holiday</td>
	</tr>
	 <?php	
   	 	//echo $fromDatee;	
		
	
					
				$hos_sql=mysql_query("select hosid,hosname from hospitals where upoid='$upoid' ");
				while ($hos_row=mysql_fetch_array($hos_sql)){
				$h_name=$hos_row['hosname'];
				 @$hos_id=$hos_row['hosid'];
				
								  
			     $staff_sql=mysql_query("select count(staffid) as t_emp  from employees where hosid='$hos_id'");
				
				 while($row_emp = mysql_fetch_object($staff_sql))
                 {  
                 @$emp_cnt=$row_emp->t_emp;
				  "emp : $emp_cnt  </pre>";
				}
				$sum_att_sql2=mysql_query("select sum(daysinmonth) as dom,sum(t_present) as p,sum(t_absent) as a,sum(t_weekend) as w,sum(t_holiday) as h,hosid from summary_attendance where hosid='$hos_id' and amonth='$month' and ayear='$year'");
				//print_r($sum_att_sql2);
				
				while($sum_att_row2 = mysql_fetch_object($sum_att_sql2)){
				  $total_working_day=$sum_att_row2->dom;
				  $present=$sum_att_row2->p;
				 $absent=$sum_att_row2->a; 
				 $totalweekday=$sum_att_row2->w;
				 $hd=$sum_att_row2->h;
				
				?>
				<tr align="center">
				<TD><?php echo $h_name;?></TD>
				<TD><?php echo $emp_cnt;?></TD>
				<td><?php echo @$total_working_day ;?> </td>
				<td><?php echo $present;?></td>
				<td><?php echo $absent; ?></td>
				<td ><?php echo $totalweekday ; ?></td>
				<td ><?php echo $hd ; ?></td>
				</tr>
				<?
			 } 
		 } 
		 
?>
</table>
