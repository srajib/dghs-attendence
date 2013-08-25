
    <?php 
	include('db.php');
	 $disid=$_GET['disid'];
	 $cdate=$_GET['cdate'];
	 $date2=$_GET['date2'];
   /* $query="select disid,disname from districts where divid=$divid";
    $result=mysql_query($query);*/
      
    ?>
	<div id="colorbox" style="border:double; border-color:#AFDffE;width:880px; padding:5px;margin:0 auto;" >
	<table width="887px" align="center" cellpadding="3px">
    <tr bgcolor="#8BB5EB">
	 <td align="center">SL</td>
        <td align="center">District</td>
		<td width=65px; align="center">Total Staff</td>
		<td width=65px; align="center">Days in Month</td>
        <td width=65px; align="center">Total Present</td>
		<td width=65px; align="center">Total Absent</td>
		<td width=65px; align="center">Total Weekend</td>
		<td width=65px; align="center">Total Holiday </td>
		<td width=65px; align="center">Total Leave </td>
	</tr>

    <?php	
   	 	//echo $fromDatee;	
		$date1 = $cdate;
        $date2 = $date2;
		
        $diff = (strtotime($date2) - strtotime($date1));
		$diff1=round(($diff/86400)+0.5);	

     $month = date("m",strtotime($date2));
	 $year = date("Y",strtotime($date2));		
	
	
	$headerinfo=mysql_query("select v.divname,d.disname,u.uponame from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	where v.divid=d.divid and u.disid='$disid'");
	$row_header=mysql_fetch_assoc($headerinfo);
	$divname=$row_header['divname'];
	$disname=$row_header['disname'];
	
	 
	       		 
			
			$emp_count=mysql_query("SELECT u.uponame,COUNT(e.staffid) as empcount FROM employees e
				INNER JOIN hospitals AS h ON (e.`hosid`=h.`hosid`)
				INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
				INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
				INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
				WHERE d.divid=ds.divid AND ds.disid='$disid' AND e.status=1 GROUP BY u.upoid order by u.uponame ");
			$i=1;
			 while($row_emp = mysql_fetch_object($emp_count))
                 {  
				 @$u_name=$row_emp->uponame;		 
                 @$totalemp=$row_emp->empcount;
				// echo "emp : $totalemp  </pre>";
				
				$sql_present=mysql_query("SELECT sum(daysinmonth) as dom,SUM(s.t_present) as present,SUM(s.t_absent) as a,sum(t_weekend) as w,sum(t_holiday) as h,sum(t_leave) as l FROM summary_attendance s
				INNER JOIN hospitals AS h ON (s.`hosid`=h.`hosid`)
				INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
				INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
				INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
				WHERE u.uponame='$u_name' AND amonth='$month' and ayear='$year' GROUP BY u.upoid");	 
				
				while($row_present=mysql_fetch_array($sql_present)){
				$total_working_day=$row_present['dom'];
				$present=$row_present['present'];	
				$absent=$row_present['a'];	
				$totalweekday=$row_present['w'];
				$hd=$row_present['h'];
				$lv=$row_present['l'];				
				
	
				}				 			
             	
			 if($i%2==0)
                {
                ?>
                <tr style="background-color: #BDD9FD;">
                <?php 
                }else
				{
                    ?>
                    <tr style="background-color: #E6F2FF;">
                    <?php
                } ?>
				<td align="center"> <?php echo $i;$i++; ?></td>
			   	<td align="left" ><?php echo $u_name; ?></td> 
				<td align="center" ><?php echo $totalemp; ?></td>
				<td align="center" ><?php echo $total_working_day; ?></td>
				<td align="center" ><?php echo $present; ?></td>
				<td align="center" ><?php echo $absent; ?></td>
				<td align="center" ><?php echo $totalweekday; ?></td>
				<td align="center" ><?php echo $hd; ?></td>
				<td align="center" ><?php echo $lv; ?></td>
				</tr>				
			    <?php
				}
				
	   
?>
<div id="colorbox" style="width:870px; padding:5px;margin:0 auto;" >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >District Attendance Summary Report</font></strong>"; ?> </div>
	<div><?php echo " <strong> Division : </strong> $divname "; ?></div>
	<div><?php echo " <strong> District : </strong> $disname "; ?></div>
	<div><?php echo " <strong> Report Date  : </strong> $cdate"," To $date2 "; ?></div>
	
	</div>	
</table>
</div>
	
	
	
	


	
	

