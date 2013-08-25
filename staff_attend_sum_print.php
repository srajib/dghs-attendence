
<html>
<head>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>

<table width="1015px" align="center" >
<tr>
<td style="padding-left:5px">
<img src="images/bangladesh-logo.png" alt=""  />
</td>
<td ><img src="images/bangladesh-mis1.png" alt="" align="left" /><td>
<td width="450px" ></td>
<tr>
</table>
<table bgcolor="#DF4C17" width="1015px" align="center">
<tr>
<td ></td>
</tr>
</table>
<table  bgcolor="#EEF5FD" width="1015px" align="center">

</table>
<script src="../../attend/js/jscal2.js"></script>
    <script src="../../attend/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../../attend/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../../attend/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../../attend/css/steel/steel.css" />

</head>
<body bgcolor="#EEF5FD" >
<div align="left" style="width:1015px;margin:0 auto;"><?php echo '<a href="javascript:window.print()">Print</a>'; ?></div>
<?php
include('db.php');
 
 extract($_POST);

 $f_date1;
 $f_date2;
 $hosid;
 $staffid;
 
    $headerinfo=mysql_query("select v.divname,d.disname,u.uponame,h.hosname from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	inner join hospitals as h on h.upoid=u.upoid where h.hosid='$hosid'");
	
	 $row_header=mysql_fetch_assoc($headerinfo);
	 $divname=$row_header['divname'];
	 $disname=$row_header['disname'];
	 $uponame=$row_header['uponame'];
	 $hosname=$row_header['hosname'];
?>
<table width="1025" align="center" border="1px" bordercolordark="#000000" style="border:thin">
    <tr bgcolor="#8BB5EB">
        <td width=25px; align="center"><strong>SL</strong></td>
		<td align="center"><strong>Staff ID</strong></td>
		<td><div align="center"><strong>Employee Name</strong></div></td>
        <td><div align="center"><strong>Designation</strong></div></td>
		<td width=65px; align="center">Days in Month </td>
		<td width=65px; align="center">Total Present</td>
		<td width=65px; align="center">Total Absent</td>
		<td width=65px; align="center">Total weekend</td>
		<td width=65px; align="center">Total Leave</td>
		
		<td width=65px; align="center">Total Holiday</td>
   </tr>

<?PHP

	    $diff = (strtotime($f_date2) - strtotime($f_date1));
		$diff1=round(($diff/86400)+0.5);	
		
	//echo "day count : $diff1";
	
	$weekday1 = strtotime("$f_date2",5) - strtotime("$f_date1",5);
	$weekday2 = strtotime("$f_date2",6) - strtotime("$f_date1",6);
	
	$weekfri = floor(($weekday1 / 604800)+0.5);
	$weeksat = floor(($weekday2 / 604800)+0.5);
	echo $totalweekday = $weekfri + $weeksat;
   //echo "total weekend : $totalweekday";

    $payableday = $diff1-$totalweekday ;
	 if(!empty($staffid)){	
         $sql_emp = "SELECT e.*,ds.disname FROM employees e
            INNER JOIN hospitals AS h ON (e.`hosid`=h.`hosid`)
            INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
 			INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
 			INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
			WHERE d.divid=ds.divid and ds.disid= u.disid and u.upoid= h.upoid and h.hosid='$hosid' and e.status=1 and e.staffid in($staffid)";      
		//echo $sql_emp;   	
	   $res_emp = mysql_query($sql_emp);
	   }else
	   {
	    $sql_emp = "SELECT e.*,ds.disname FROM employees e
            INNER JOIN hospitals AS h ON (e.`hosid`=h.`hosid`)
            INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
 			INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
 			INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
			WHERE d.divid=ds.divid and ds.disid= u.disid and u.upoid= h.upoid and h.hosid='$hosid' and e.status=1 ";   
			 $res_emp = mysql_query($sql_emp);
	   }
	 
        if(mysql_num_rows(@$res_emp)>0)
        {
		    $i=1;
			
			$empcount=mysql_num_rows(@$res_emp); 
			?>
			
			<div id="colorbox" style="border:double; border-color:#AFDBFE; width:1015px; padding:5px;margin:0 auto;" >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >Staff Attendance Summary Report</font></strong>"," From : $f_date1"," To $f_date2"; ?> </div>
	<div><?php echo " <strong> Division : </strong> $divname  "?></div>
	<div><?php echo " <strong> District : </strong> $disname"; ?></div>
	<div><?php echo " <strong> Upozila : </strong> $uponame"; ?></div>
	<div><?php echo " <strong> Oranization : </strong> $hosname |"," <font-size=12px><strong>Total Staff :</strong> $empcount </font>"; ?></div>
	</div>
			<?php
			
			$sqlHoliday=mysql_query("select count(hdate) as holiday from holidays where hdate between '$f_date1' and '$f_date2'");
			//print_r($sqlHoliday);
			$sqlHoliday_row = mysql_fetch_object($sqlHoliday);
	         $hd = $sqlHoliday_row->holiday;
				
            while($row_emp = mysql_fetch_object($res_emp))
            {  
			 
				 $sql_cnt = mysql_query("SELECT count(distinct(date(timing))) as PRESENT FROM logs  WHERE hosid =$row_emp->hosid AND staffid = $row_emp->staffid AND date(timing) between '$f_date1' AND '$f_date2'");
			    // print_r($sql_cnt);
                //echo $sql_cnt;
				$row_cnt = mysql_fetch_object($sql_cnt);
				 $present=$row_cnt->PRESENT;	

				$wk_present = mysql_query("SELECT count(distinct(date(timing))) as WK_PRESENT FROM logs  WHERE hosid = $row_emp->hosid AND staffid = $row_emp->staffid AND date(timing) between '$f_date1' AND '$f_date2' and dayofweek(date(timing)) in (6,7)");
			 	$row_wkpresent = mysql_fetch_object($wk_present);
				$wk_present=$row_wkpresent->WK_PRESENT;	
			
				$sqlLeave=mysql_query("select sum(assign_day) as assign from leave_app where lv_fromdate>= '$f_date1' and lv_todate<='$f_date2' and staffid= $row_emp->staffid and hosid=$row_emp->hosid ");
	            $leave=mysql_fetch_object($sqlLeave);
				$lv=$leave->assign;
				if(empty($lv)){
				$lv=0;
				}else {$lv=$lv;}
							
				$absent=$diff1 - ($present+$lv+$hd+($totalweekday-$wk_present));
				if($absent<0){
				$absent=0;
				}
                if($i%2==0)
                {
                ?>
                <tr style="background-color: #F2FBFF;">
                <?php 
                }else{
                    ?>
 		 <tr style="background-color: #CDE8FC;">
                    <?php
                } ?>
				
	                <td width=25px; align="center"><?php echo $i;$i++; ?></td>
					<td align="center"><?php echo $row_emp->staffid; ?></td>
					<td style="padding-left:10px"><?php echo $row_emp->empname; ?></td>
                    <td style="padding-left:10px"><?php echo $row_emp->designation; ?></td>
					<td align="center"><?php echo $diff1; ?></td>
					<td align="center"><?php echo $present; ?></td>
					<td align="center"><?php echo $absent; ?></td>
					<td align="center"><?php echo $totalweekday-$wk_present; ?></td>
					<td align="center"><?php echo $lv; ?></td>
					<td align="center"><?php echo $hd; ?></td>
  </tr>
                <?php        
                
            }
        }
        
?>
</table>

</body>
</html>

