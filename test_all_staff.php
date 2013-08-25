<html>
<head>
<script src="js/jscal2.js"></script>
    <script src="js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jscal2.css"/>
    <link rel="stylesheet" type="text/css" href="css/border-radius.css"/>
    <link rel="stylesheet" type="text/css" href="css/steel/steel.css"/>
</head>

<body>

<form method="post" action="" name="form1" id="form1">
<table width="1024px" align="center">
      <tr>
        <td width="85">Date From </td>
        <td width="158"><input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
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
        <td width="39" align="right"> To </td>
        <td width="198"><input size="15" id="f_date2" name="f_date2" value="<?php echo @$_POST['f_date2'];?>"/>
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
        <td width="206"><input name="submit" type="submit" value="Execute" /></td>
        <td width="144">&nbsp;</td>
        <td width="162"></td>
      </tr>
      <tr>
	   <td><?php echo '<a href="../index.php">Home</a>'; ?></td>
	   <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table>
</form>
<?php
include('db.php');
// $hosid=$_GET['hosid'];
 $cdate='2013-04-01';
 $date2='2013-04-30';
 
 
// $staffid=$_GET['staffid'];
 if(isset($_POST['f_date1']))
    {  
	
	    $cdate=$_POST['f_date1'];
	    $date2=$_POST['f_date2'];
 
    
	    $diff = (strtotime($date2) - strtotime($cdate));
		$diff1=round(($diff/86400)+0.5);	
		
	function getfri($startDate, $endDate, $weekdayNumber)
    {
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $dateArr = array();

    do
    {
        if(date("w", $startDate) != $weekdayNumber)
        {
            $startDate += (24 * 3600); // add 1 day
        }
    } while(date("w", $startDate) != $weekdayNumber);


    while($startDate <= $endDate)
    {
        $dateArr[] = date('Y-m-d', $startDate);
        $startDate += (7 * 24 * 3600); // add 7 days
    }

    return count($dateArr);
}
	$weekfri = getfri($cdate, $date2, 5);
	
	function getsat($startDate, $endDate, $weekdayNumber)
   {
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $dateArr = array();

    do
    {
        if(date("w", $startDate) != $weekdayNumber)
        {
            $startDate += (24 * 3600); // add 1 day
        }
    } while(date("w", $startDate) != $weekdayNumber);


    while($startDate <= $endDate)
    {
        $dateArr[] = date('Y-m-d', $startDate);
        $startDate += (7 * 24 * 3600); // add 7 days
    }

    return count($dateArr);
}
	$weeksat = getsat($cdate, $date2, 6);


    $totalweekday=	$weekfri + $weeksat;
   //echo "total weekend : $totalweekday";
  
   $month = date("m",strtotime($date2));
	 $year = date("Y",strtotime($date2));
	
	$delAttnd="Delete from summary_attendance where amonth='$month' and ayear='$year' ";
       mysql_query($delAttnd);
   
    
	  $sql_emp = "SELECT e.* FROM employees e
            INNER JOIN hospitals AS h ON (e.`hosid`=h.`hosid`)
            INNER JOIN upozilas AS u ON (h.`upoid`=u.`upoid`)
 			INNER JOIN districts AS ds ON (u.`disid`=ds.`disid`)
 			INNER JOIN divisions AS d ON (ds.`divid`=d.`divid`)
			WHERE d.divid=ds.divid and ds.disid= u.disid and u.upoid= h.upoid and e.status=1 order by e.hosid";   
			 $res_emp = mysql_query($sql_emp);
	 
        if(mysql_num_rows(@$res_emp)>0)
        {
		    $i=1;
			
			$empcount=mysql_num_rows(@$res_emp); 
					
			$sqlHoliday=mysql_query("select count(hdate) as holiday from holidays where hdate between '$cdate' and '$date2'  ");
			$sqlHoliday_row = mysql_fetch_object($sqlHoliday);
	        $hd = $sqlHoliday_row->holiday;
				//$sum=0; 
			while($row_emp = mysql_fetch_object($res_emp))
            {  
			 $staffid=$row_emp->staffid;
			 $hosid=$row_emp->hosid;
				 $sql_cnt = "SELECT count(distinct(date(timing))) as PRESENT FROM logs  WHERE hosid = $row_emp->hosid AND staffid = $row_emp->staffid AND date(timing) >= '$cdate'  AND date(timing) <= '$date2' ";
			  // print_r($sql_cnt);
                //echo $sql_cnt;
				$res_cnt = mysql_query($sql_cnt);
                $row_cnt = mysql_fetch_object($res_cnt);
				$present=$row_cnt->PRESENT;
				
				
				 $wk_present = mysql_query("SELECT count(distinct(date(timing))) as wkend_present FROM logs  WHERE hosid = '$hosid'  AND staffid = '$staffid' AND date(timing) >= '$cdate'  AND date(timing) <= '$date2' and dayofweek(date(timing)) in (6,7)");
			  // print_r($sql_cnt);
                //echo $sql_cnt;
				$row_wknd = mysql_fetch_object($wk_present);
				$wknd_present=$row_wknd->wkend_present;
				//$sum += $row_cnt->PRESENT;
							
				$totalweekday1=	$totalweekday - $wknd_present;
				 // echo "total : $sum <br>" ;
				
				$sqlLeave=mysql_query("select sum(assign_day) as assign from leave_app where lv_fromdate>= '$cdate' and lv_todate<='$date2' and staffid= $row_emp->staffid and hosid=$row_emp->hosid ");
	            $leave=mysql_fetch_object($sqlLeave);
				$lv=$leave->assign;
				if(empty($lv)){
				$lv=0;
				}else {$lv=$lv;}
				
											
				$absent=$diff1 - ($present+$lv+$hd+$totalweekday1);
				
				if($absent<0){
				$absent=0;
				}
               
			    
		mysql_query("insert into summary_attendance(hosid,staffid,daysinmonth,t_present,t_absent,t_weekend,t_leave,t_holiday,amonth,ayear)
		values('$hosid','$staffid','$diff1','$present','$absent','$totalweekday1','$lv','$hd','$month','$year')");
            }	
        }
		}
       ?>

</body>
</html>