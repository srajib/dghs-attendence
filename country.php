<?php
include('db.php');
 $cdate=$_GET['cdate'];
 $date2=$_GET['date2'];
 $bd='Bangladesh';
?>
<table width="900" align="center" cellpadding="5px">
    <tr bgcolor="#8BB5EB">
        <td width="20px" >SL</td>
		<td align="center">Division</td>
		<td width=65px; align="center">Total Staff</td>
        <td width=65px; align="center">Total Present</td>
		<td width=65px; align="center">Total Absent</td>
		<td width=65px; align="center">Total Weekend</td>
		<td width=65px; align="center">Total Holiday </td>
		<td width=65px; align="center">Leave </td>
		<td width=65px; align="center">Late </td>
    </tr>

   <?
 	

        $diff = (strtotime($date2) - strtotime($cdate));
		$diff1=round(($diff/86400)+0.5);
		 
	    $weekday1 = strtotime("$date2",5) - strtotime("$cdate",5);
	    $weekfri = floor($weekday1 / 604800);
	    $weekday2 = strtotime("$date2",6) - strtotime("$cdate",6);
	    $weeksat = floor($weekday2 / 604800);
	    $totalweekday = $weekfri + $weeksat;
	
	$totaldaycount=$diff1;
				
			$res_emp = mysql_query("SELECT d.divname as divname,COUNT(distinct(logs.staffid)) as PRESENT FROM logs
			INNER JOIN hospitals AS h ON (logs.`hosid`=h.`hosid`)
			INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
			INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
			INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
			where d.`divid`=ds.`divid` AND  DATE(logs.timing)>='$cdate'
 			AND DATE(logs.timing) <='$date2' group by d.divname");
			
			$sqlHoliday=mysql_query("select hdate from holidays where hdate between '$cdate' and '$date2' ");
	         $hd = mysql_num_rows($sqlHoliday);
			 				
             $i=1;
			 while($row_emp = mysql_fetch_assoc($res_emp))
            {
			    $divnm=$row_emp['divname'];
				$emp_count=mysql_query("select e.staffid as staff FROM employees e
				INNER JOIN hospitals AS h ON (e.`hosid`=h.`hosid`)
				INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
				INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
				INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
				WHERE d.divname='$divnm' and e.status=1 ");
				//$absent= $t1 - $row_emp['PRESENT'];
			
			 $totalemp=mysql_num_rows($emp_count);
			 if($i%2==0)
                {
                ?>
                <tr style="background-color: #BDD9FD;">
                <?php 
                }else
				{?>
				<tr style="background-color: #E6F2FF;">
                <?php
                } ?>
			    <td> <?php echo $i;$i++; ?></td>
				<td align="left" ><?php echo $row_emp['divname'];?></td> 
				<td align="left" ><?php echo  $totalemp; ?></td>
				<td align="left" style="padding-left:10px;"><?php echo $row_emp['PRESENT']; ?></td>
				<td align="center" style="padding-left:10px;"><?php echo $totalemp - ($row_emp['PRESENT']+ $totalweekday + $hd); ?></td>
				<td align="center"><?php echo $totalweekday; ?></td>
				<td align="center"><?php echo $hd; ?></td>
				<td align="center"><?php echo 0; ?></td>
				<td align="center"><?php echo 0; ?></td>
                    
      </tr>	
	  <?php
	  }?>
		
<div id="colorbox" style="border:double; border-color:#AFDBFE; width:882px; padding:5px;margin:0 auto;" >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >Country Wise Attendance Summery Report</font></strong>"; ?> </div>
	<div><?php echo " <strong> Country : </strong> $bd "; ?></div>
	<div><?php echo " <strong> Report Date  : </strong> $cdate"," To $date2 "; ?></div>
	
</div>
</table>
