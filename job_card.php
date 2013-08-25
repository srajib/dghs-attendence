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
<table bgcolor="#047C0C" width="1050px" align="center" >
<tr>
<td style="padding-left:5px">
<img src="images/bangladesh-logo.png" alt=""  />
</td>
<td ><img src="images/bangladesh-mis.png" alt="" align="left" /><td>
<td width="450px" ></td>
<tr>
</table>
<table bgcolor="#DF4C17" width="1050px" align="center">
<tr>
<td ></td>
</tr>
</table>
<table  bgcolor="#EEF5FD" width="1050px" align="center">

</table>
<script src="js/jscal2.js"></script>
    <script src="js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jscal2.css"/>
    <link rel="stylesheet" type="text/css" href="css/border-radius.css"/>
    <link rel="stylesheet" type="text/css" href="css/steel/steel.css"/>
<script type="text/javascript"> 
function loadXL() 
{ 
var f_date1=document.form1.f_date1.value; 
var f_date2=document.form1.f_date2.value; 
var empcode=document.form1.empcode.value; 
var department=document.empcode.department.value;
var xmlhttp; 
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else 
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("mydiv").innerHTML=xmlhttp.responseText; 
    } 
  } 
xmlhttp.open("GET","export1.php?f_date1="+f_date1+"&f_date2="+f_date2+"&empcode="+empcode,true); 
xmlhttp.send(); 
} 

</script>

<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=700');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>
</head>
<body bgcolor="#EEF5FD">
<?php
include('db.php');
$hosid=$_GET['hosid'];
?>
  <label></label>
  <form method="post" action="" name="form1" id="form1">
    <table width="1024px" align="center">
      <tr>
        <td width="98">Date From </td>
        <td width="168"><input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
            <button id="f_btn1">...</button>
          <br />
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
    //]]></script>        </td>
        <td width="62" align="right"> To </td>
        <td width="162"><input size="15" id="f_date2" name="f_date2" value="<?php echo @$_POST['f_date2'];?>"/>
            <button id="f_btn2">...</button>
          <br />
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date2",
        trigger    : "f_btn2",
        onSelect   : function() { this.hide() },
         dateFormat : "%Y-%m-%d"
      });
    //]]></script>        </td>
        <td width="55">Staff ID</td>
        <td width="114"><input name="empcode" type='text' id="empcode" value="<?php echo @$_POST['empcode'];?>" size="15"></td>
        <td width="126"><input name="submit" type="submit" value="Show Report" /> <input name="hosid" type='hidden' id="hosid" value="<?php echo @$_GET['hosid'];?>" size="15"></td>
      </tr>
      <tr>
	   <td><a href="job_card11.php?f_date1=<?php echo $_POST['f_date1'] ;?>&f_date2=<?php echo $_POST['f_date2'] ;?>&empcode=<?php echo $_POST['empcode']; ?>&hosid=<?php echo $_POST['hosid'];?>" >Print prview </a></td>
	   <td>|<?php echo '<a href="../index.php">Home</a>'; ?> </td>
        <td ></td>
      </tr>
    </table>
	
  </form>

    <?php	
    if(isset($_POST['f_date1']))
    {  
	   $delAttnd="Delete from job_card ";
       mysql_query($delAttnd);
	  
	  //echo $hosid;
     	$empcode = $_POST['empcode'];
		$fromDatee   =   $_POST['f_date1'];
        $toDatee     =   $_POST['f_date2'];
		//echo $fromDatee;	
		$date1 = $fromDatee;
        $date2 = $toDatee;

        
		$diff = (strtotime($date2) - strtotime($date1));
		$diff1=round(($diff/86400)+0.5);
						
	//echo "day count : $diff1";
	
	$weekday1 = strtotime("$date2",5) - strtotime("$date1",5);
	$weekfri = floor(($weekday1 / 604800));
	$weekday2 = strtotime("$date2",6) - strtotime("$date1",6);
	$weeksat = floor(($weekday2 / 604800));
	
	$totalweekday=	$weekfri + $weeksat;
   //echo "total weekend : $totalweekday";

    $payableday = $diff1-$totalweekday;
				
	 $sql_emp = "SELECT * FROM employees WHERE status=1	and staffid ='$empcode' and hosid='$hosid'";
	 $res_emp = mysql_query($sql_emp);
	 //print_r($res_emp);
	 $row=mysql_fetch_array( $res_emp);
	 //print_r($row);
	 $name=$row['empname'];
	 $department=$row['department'];
	 $designation=$row['designation'];
	 $hosid=$row['hosid'];
			
?>
<div id="colorbox" style="border:double; border-color:#AFDBFE; width:1010px;margin-left:auto;margin-right:auto;">
<table width=1018 align="center">
<tr>
  <td width="302"><span class="style1"><font color="#0C75DE" size="+2">Monthly Attendance Report</font></span></td>
  <td width="276">&nbsp;</td>
  <td width="219">&nbsp;</td>
  <td width="100" rowspan="3">
   <input type="image" name="empimg" style="left:10px;top:15px;" border=1 src="images/blank.jpeg" accept="image/jpeg" type="file" />
  </td>
</tr>
<tr>
  <td><?php echo " <strong>Report Date from </strong> : $fromDatee "," <strong> To </strong>: $toDatee";?> </td> 
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td><?php echo " <strong >Department</strong> : $department ";?> </td>
  <td><?php echo "<strong >Name </strong > : $name  "; ?></td>
  <td><?php echo "<strong >Designation </strong > :  $designation ";?></td>
  </tr>
</table>
</div>
<div id='excel'> </div>
<table width=1024px; align="center">
    <tr bgcolor="#8BB5EB">
        <td  width=25px; align="center">SL</td>
		<td width=30px; align="center">Event Date</td>
        <td width=65px; align="center">In Time</td>
		<td width=65px; align="center">Out Time</td>
		<td width=65px; align="center">Working Hour</td>
		<td width=65px; align="center">Status</td>
    </tr>
  
<?PHP
	   	    $n=1;
			
			//echo mysql_num_rows(@$res_emp);
				 	  
				for($i=0; $i<=$diff1-1; $i++)
            	{
 		 			$date = $date1;
					$newdate = strtotime ( '+'.$i.' day' , strtotime ( $date ));
					$newdate = date ( 'Y-m-d' , $newdate ); 
					
					//echo $newdate;		
			 $sql_cnt2 = mysql_query("SELECT e.staffid,e.empname,e.hosid,DATE(t.timing) AS edate,MIN(TIME(t.timing)) AS entry, MAX(TIME(t.timing)) AS outs FROM employees e,logs t WHERE e.hosid=t.hosid AND DATE(t.timing) ='$newdate' and t.staffid ='$empcode' and e.department='$department' and t.hosid='$hosid'");       

				$row_cnt2 = mysql_fetch_array($sql_cnt2);
				//print_r($row_cnt2);  
				 $name=$row_cnt2['empname'];
				 $id=$row_cnt2['staffid'];
				 $evt_date=$row_cnt2['edate'];
				 $entry=$row_cnt2['entry'];
				 $outs=$row_cnt2['outs'];
							  
				  				 
				// $hosid=$row_cnt2->hosid;
				  $timediff=abs($outs - $entry);	
				// $offday=date(5,$newdate);
				
				 $sqlHoliday=mysql_query("select hdate from holidays where hdate='$newdate'");
	             $row_cntHD = mysql_fetch_assoc($sqlHoliday);
				 $hd= $row_cntHD['hdate'];
				 
				 
				 
				/* $Leave1=mysql_query("select event_date from leave_event where event_date ='$newdate' and hosid='$hosid' and staffid='$empcode' ");
	             $row_leave1 = mysql_fetch_assoc($Leave1);
				 $lv1= $row_leave1['event_date'];*/
				 
				 if($outs==$entry){
				  $outs='Not Checked Out';
				  } else
				  {
				  $outs=$outs;
				  }
				 
	         $wk=strtotime($newdate);
 			 $weekd=date('l',$wk);
				 	   				 
				 if($entry>'09:30:00')
				 {
				     $id=$empcode;
					 $status='Late';
				 }
				 else{
				 	 $id=$empcode;
					 $status='Present';
				 }
				 if(empty($entry) )
				 {
				     $id=$empcode;
					 $status='Absent';
					 $evt_date=$newdate;
					 $outs='';
				 } 
				 if($weekd=='Friday'){
				   $id=$empcode;
				   $status='Friday';
				   $evt_date=$newdate;
				   $outs='';
				 }elseif(($weekd=='Saturday') and (empty($entry))){
				   $id=$empcode;
				   $status='Saturday';
				   $evt_date=$newdate;
				   $outs='';
				 }elseif(($weekd=='Saturday') and (!empty($entry))){
				  $id=$empcode;
				  $status='Present';
				  $evt_date=$newdate;
				 }
				 if( $hd==$newdate){
				   $id=$empcode;
				   $status='Holiday';
				   $evt_date=$newdate;
				   $outs='';
				 }
				/* if($lv1==$newdate){
				   $id=$empcode;
				   $status='Leave';
				   $evt_date=$newdate; 
				 }*/
				
				 
				  
				
				  				
			 mysql_query("insert into job_card(empcode,event_date,in_time,out_time,status,hosid,wkhour) values('$id','$evt_date','$entry','$outs','$status',$hosid,$timediff)");
						
			  if($n%2==0)
                {
                ?>
                <tr style="background-color: #BDD9FD;">
                <?php 
                }else{
                    ?> 
                <tr style="background-color: #E6F2FF;">
                    <?php
                } ?>
				    <td align="center" width="20px"><?php echo $n;$n++; ?></td>
					<td align="left"  style="padding-left:20px;"><?php echo  $evt_date; ?></td>
					<td align="center" width="50px"><?php echo $entry; ?></td>
					<td align="center" width="50px"><?php echo $outs; ?> </td>
					<td align="center" width="50px"><?php echo $timediff; ?> </td>
					<td align="center" width="50px"><?php echo $status; ?> </td>
					
  				</tr>
	   
                <?php 	
            }
				$sql_cnt = "SELECT count(empcode) as PRESENT FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <='$toDatee' and status in('Present','Late')";
                //echo $sql_cnt;
				
                $res_cnt = mysql_query($sql_cnt);
                $row_cnt = mysql_fetch_object($res_cnt);
				$present=$row_cnt->PRESENT;
				
				$sql_weknd_present = mysql_query("SELECT count(empcode) as WEEKND_PRESENT FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <='$toDatee' and dayofweek(event_date) in (6,7) and in_time <>''");
                //echo $sql_cnt;
				
                $row_weknd_present = mysql_fetch_object($sql_weknd_present);
				$wkd_present=$row_weknd_present->WEEKND_PRESENT;
				
				$t_present=$present;
				
						            				
                $res_cnt1 = mysql_query("SELECT count(empcode) as LATE FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <=                '$toDatee' and in_time>'09:30:00'");
                $row_cnt1 = mysql_fetch_assoc($res_cnt1);
				@$late=$row_cnt1['LATE'];
				
				$res_cnt2 = mysql_query("SELECT sum(wkhour) as WHOUR FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode'
                 AND event_date >= '$fromDatee' AND event_date <= '$toDatee'");
                $row_cnt2 = mysql_fetch_assoc($res_cnt2);
				@$whour=$row_cnt2['WHOUR'];
				
				$res_HD= mysql_query("SELECT count(empcode) as holiday FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <= '$toDatee' and status='Holiday'");
                $row_cnt2 = mysql_fetch_assoc($res_HD);
				@$Holy=$row_cnt2['holiday'];
				
				$sqlLeave=mysql_query("SELECT count(empcode) as assign FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <= '$toDatee' and status='Leave'");
	            $leave=mysql_fetch_assoc($sqlLeave);
				$lv=$leave['assign'];
				
				
				$sqlWeekend=mysql_query("SELECT count(empcode) as wknd FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <= '$toDatee' and status in('Friday','Saturday')");
	            $weeknd_sql=mysql_fetch_assoc($sqlWeekend);
				$wknd=$weeknd_sql['wknd'];
				$twknd=$wknd;
										
				$totalDayofwork_hour=($diff1-($Holy +($totalweekday-$wkd_present)+$lv)) * 8;//Total Day of Working Hour
				
				$totalDayofwork=($diff1-($Holy +($totalweekday-$wkd_present)+$lv));
				
				$sqlAbsent=mysql_query("SELECT count(empcode) as absent FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <= '$toDatee' and status='Absent'");
	            $absent_sql=mysql_fetch_assoc($sqlAbsent);
				$ab=$absent_sql['absent'];
				$absent=$ab;
				
				$sqlwkh=mysql_query("SELECT sum(wkhour) as wkhour FROM job_card WHERE hosid ='$hosid' AND empcode ='$empcode' AND event_date >= '$fromDatee' AND event_date <= '$toDatee' and status in('Present','Late')");
	            $wkh_sql=mysql_fetch_assoc($sqlwkh);
				$whour1=$wkh_sql['wkhour'];
				//@$whour1=$t_present * 8;
				if($absent<0){
				$absent=0;
								
				}?>
				
			  <table border="0" width="500px" align="center">
			  <tr><td align="center"></td><td width="30px"></td></tr>
			  <tr> <td></td> <td></td>
			  <td></td>
			  </tr>
			  <tr>
			   <td></td>
			   <td></td>
			   <td></td>
			  </tr>
			  </table>
			  <div id="colorbox" style="border:double; border-color:#006600; width:650px;margin:0 auto;">
			  <table border="0" width="650px" align="center">
			  <tr><td ></td>
			  <td  align="center"><h3><strong>Total Summary</strong></td>
			  </tr>
			  <tr>
			  <td style="padding-left:5px"><?php echo " <strong> Days in Month </strong> : $diff1 Days ";?></td>
			  <td style="padding-left:5px"><?php echo " <strong> Present </strong> : $t_present Days","";?></td>
			  <td style="padding-left:5px"><?php echo " <strong> Leave </strong>   : $lv Days";?></td>
			  </tr>
			  <tr> 
			   <td style="padding-left:5px"><?php echo " <strong> Total Working Days :</strong> $totalDayofwork  Days";?></td>
			   <td style="padding-left:5px"><?php echo " <font color=red ><strong> Absent </strong> : $absent Days</font>";?></td>
			  <td style="padding-left:5px"><?php echo "<strong> Weekend </strong> : $twknd Days";?></td>
			  </tr>
			  <tr>
			  <td style="padding-left:5px"><?php echo " <strong> Allocated Working Hours :</strong> $totalDayofwork_hour Hours ";?></td>
			  <td style="padding-left:5px"><?php echo " <font color=#rsdyyy ><strong>Late </strong>   : $late  Days</font>";?></td>
			   <td style="padding-left:5px"><?php echo " <strong> Holiday </strong>   : $Holy Days";?></td>
			   </tr>
			   <tr>
			  <td style="padding-left:5px"><?php echo " <strong> Present Working Hours :</strong> $whour1  Hours";?></td><td></td><td></td>
			  </tr>
			  </table>
			  </div>
			  
			  
			  
	<?
	}

?>
<div id="printdiv" style="width:900px;"></div>
</table>
</body>
</html>
