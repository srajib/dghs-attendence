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

<table width=1025px align="center">
<tr>
<td><img src="../../attend/images/bangladesh-logo.png" alt="" />
</td>
<td><img src="images/bangladesh-header-name.png" alt=""  />
</td>
</tr>
</table>
<table width=1025px bgcolor="#DF4C17" align="center" >
<tr>
<td ></td>
</tr>
</table>
<table width=1025px align="center">
<tr>
<td ></td>
</tr>
</table>
<script src="../../attend/js/jscal2.js"></script>
    <script src="../../attend/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../../attend/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../../attend/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../../attend/css/steel/steel.css" />

</head>
<body  >
<?php
include('db.php');
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * 20;
extract($_POST);
$hosid;
$f_date1;

    $headerinfo=mysql_query("select v.divname,d.disname,u.uponame,h.hosname from divisions as v 
	inner join districts as d on d.divid=v.divid inner join upozilas as u on u.disid=d.disid
	inner join hospitals as h on h.upoid=u.upoid where h.hosid='$hosid'");
	
	$row_header=mysql_fetch_assoc($headerinfo);
	$divname=$row_header['divname'];
	$disname=$row_header['disname'];
	$uponame=$row_header['uponame'];
	$hosname=$row_header['hosname'];
	
	    $res_absent = mysql_query("SELECT department FROM employees	WHERE hosid ='$hosid'  and empname<>'' ORDER BY empname ASC LIMIT $start_from, 70");
		$row_absent = mysql_fetch_assoc($res_absent);
		@$dept=$row_absent['department'];
		
		$total_emp=mysql_query("select staffid from employees where hosid=$hosid");
		$totemp=mysql_num_rows($total_emp);
		$res_emp1 = mysql_query("select  distinct(logs.staffid) as PRESENT FROM logs  WHERE hosid = $hosid 
		AND date(timing) >= '$f_date1' ");
	
	 $res_emp_late = mysql_query("select distinct(staffid) from logs where hosid=$hosid and time(timing)>'09:30:00' and date(timing)='$f_date1'");
	 	
	 @$late_emp=mysql_num_rows($res_emp_late);
	
		   $presnt=mysql_num_rows($res_emp1);
		   $absent_emp=$totemp-$presnt;
		   
		   
		   if($totemp==0){$perpre=0;}
	else{ $perpre=($presnt*100)/$totemp;}
	 $perabs=100-$perpre;
	 	
?>
<div align="left" style="width:1015px;margin:0 auto;"><?php echo '<a href="javascript:window.print()">Print</a>','| <a href="../attend/index.php">Home</a>'; ?></div>
<div id="colorbox" style="border:double; border-color:#AFDBFE; width:878px; padding:5px;margin:0 auto;" >
<table width="878px">
<tr>
<td>
<div id="colorbox" style=" width:530px; padding:5px;margin:0 auto; " >
	<div><?php echo " <strong><font color='#0C75DE' size=5px >Daily Attendance Report</font></strong>"; ?> </div>
	<div><?php echo " <strong> Division : </strong> $divname "; ?></div>
	<div><?php echo " <strong> District : </strong> $disname"; ?></div>
	<div><?php echo " <strong> Upozila : </strong> $uponame"; ?></div>
	<div><?php echo " <strong> Oranization : </strong> $hosname"; ?></div>
	<div><?php echo " <strong> Report Date : </strong> $f_date1  |  "," <strong>Total Staff : $totemp </font> | ","<font color='green' size='3em'> Present: $presnt </font> |"," <font color='red' size='3em'>Absent :$absent_emp  </font> |"," <font color='#4642BA' size='2em'>Late: $late_emp </font>";?></div></td>
  <td><?php echo '<div style="width:330px; height:140px; padding:3px;margin:0 auto;">
   <img style="float: left;" src="http://chart.apis.google.com/chart?cht=p&chs=330x140&chdl=Present|Absent&chl=Present|Absent&chco=228822|ff3344&chd=t:'.$perpre.','.$perabs.'" >	
  </div>';?>  </td>
</tr>
</table>
</div>
<?php
$sql = "SELECT COUNT(empname) FROM employees where hosid='$hosid' and empname<>''";
$rs_result = mysql_query($sql);
$row = mysql_fetch_row($rs_result);
$total_records = $row[0];
$total_pages = ceil($total_records / 20);
  
for ($i=1; $i<=$total_pages; $i++) {
            echo "<a href='hospital.php?page=".$i."'>".$i."</a> ";
};
?>

<table cellpadding="5px" width="887" style="margin-top:7px;" align="center">
    <tr bgcolor="#8BB5EB">
        <td width="18" >SL</td>
		<td width="221" align="center"><strong>Name of Staff </strong></td>
        <td width=242 align="center"><strong>Designation</strong></td>
        <td width=104 align="center">In Time </td>
		<td width=98 align="center"><strong>Out Time</strong> </td>
		<td width=128 align="center"><strong>Status</strong> </td>
    </tr>

    <?php	
			
	
$res_emp = mysql_query("select 	coalesce(e.empid,i.staffid,o.staffid) as empid, ifnull(e.empname,'Not Registered') as empname,ifnull(e.designation,'Not Registered') as designation,ifnull(e.department,'Not Registered') as department,ifnull(e.branch,'Not Registered') as branch,ifnull(date_format(i.timing,'%r'),'No IN') as intime, ifnull(date_format(o.timing,'%r'),'<span class=\"nco\">Not checkout</span>') as outtime	from (select hosid,empid,empname,staffid,designation,department,branch from  employees where hosid='$hosid' and status=1) as e right join (select hosid,staffid,min(timing) as timing from logs where hosid=$hosid and date_format(timing,'%Y-%m-%d')='$f_date1' group by hosid,staffid) i on e.staffid=i.staffid left join (select hosid,staffid,max(timing) as timing from logs where hosid=$hosid and date_format(timing,'%Y-%m-%d')='$f_date1' group by hosid,staffid having count(*)>1) o on i.staffid=o.staffid  and empname<>'' ORDER BY e.empname ASC LIMIT $start_from, 100");
 
		  $event=mysql_num_rows($res_emp);
		  $absent_emp=$totemp-$presnt;
		  $perpre=($presnt*100)/$totemp;
	      $perabs=100-$perpre;
		  
	       
		   if($event==0){
		    echo '<div align="center" ><h2><strong>No Data Found</strong></h2></div>';
		   
		   }
	         $i=1;
			 while($row_emp = mysql_fetch_assoc($res_emp))
            {
			$entry=$row_emp['intime'];
			
			if($entry>'09:30:00')
				 {
					$status='Late';
				 }
				 else{
					$status='Present';
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
					  <td align="left" style="padding-left:5px;"><? echo $row_emp['empname'];?></td>
					  <td align="left"  style="padding-left:5px;"><? echo $row_emp['designation'];?></td>
					  <td align="center"  style="padding-left:5px;"><? echo $row_emp['intime'];?></td>
					  <td align="center"style="padding-left:5px;"><? echo $row_emp['outtime'];?></td>
					  <td align="center"style="padding-left:5px;"><? echo $status;?></td>                 
				</tr>				
			   <?php
}
	
?>
</table>

</body>
</html>	

	

	