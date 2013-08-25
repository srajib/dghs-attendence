<html>
<head>
<table bgcolor="#047C0C" width="1200px" align="center" >
<tr>
<td style="padding-left:5px">
<img src="images/bangladesh-logo.png" alt=""  />
</td>
<td ><img src="images/bangladesh-mis.png" alt="" align="left" /><td>
<td width="450px" ></td>
<tr>
</table>
<table bgcolor="#DF4C17" width="1200px" align="center">
<tr>
<td ></td>
</tr>
</table>
<table  bgcolor="#EEF5FD" width="1200px" align="center">
<tr>
<td width="1200px" ><?php include'menu.php';?></td>
</tr>
</table>

    <script src="js/jscal2.js"></script>
    <script src="js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jscal2.css"/>
    <link rel="stylesheet" type="text/css" href="css/border-radius.css"/>
    <link rel="stylesheet" type="text/css" href="css/steel/steel.css"/>
	<!--<link rel="stylesheet" type="text/css" href="css/style.css"/>	--> 
	<link rel="stylesheet" href="treeview/jquery.treeview.css"/>
	<link rel="stylesheet" href="treeview/screen.css"/>
	<!-- Menue Part -->
	<link rel="stylesheet" href="superfish/css/superfish-modified.css"/>
	<link rel="stylesheet" href="superfish/css/superfish-navbar.css"/>
	<link rel="stylesheet" href="superfish/css/superfish-vertical.css"/>
	<link rel="stylesheet" href="superfish/css/superfish.css"/>
	
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview/demo.js"></script>
	
<!-- calculate date and time -->
<script type="text/javascript">
function showDis()
{
var disid=document.form1.disid.value;
var cdate=document.form1.f_date1.value;

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
    document.getElementById("disid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","dist.php?disid="+disid+"&cdate="+cdate,true);
xmlhttp.send();
}

function showhos()
{
var hosid=document.form1.hosid.value;
var cdate=document.form1.f_date1.value;

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
    document.getElementById("hosid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","hospital.php?hosid="+hosid+"&cdate="+cdate,true);
xmlhttp.send();
}

</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD" >
<?php
include('db.php');
$tree = @mysql_query("SELECT * from divisions");
?>
<div id="disid"></div>

<form method="post" action="" name="form1" id="form1">         
<table width="1200" align="center">
 <tr>
 <td width="89" height="33">Date From </td>
  <td width="282">
   <input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
   <button id="f_btn1">...</button>
   <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
    //]]></script>	<input name="submit" type="button" value="Show Report" /></td>
	<td width="90">&nbsp;</td>
	<td colspan="2">&nbsp;</td>
	<td width="209"></td>	
 </tr>
 <tr>
   <td colspan="2"><?php echo '<a href="javascript:window.print()">Print</a>'; ?> | <?php echo '<a href="../index.php">Home</a>'; ?> </td>
   <td>&nbsp;</td>
   <td width="217">&nbsp;</td>
   <td width="109">&nbsp;</td>
   <td width="209">&nbsp;</td>
 </tr>
 <tr>
   <td colspan="2"><div id="main" style="width:300px; background-color:#EEF5FD">
	<ul id="navigation" style="border:double; border-color:#AFDBFE">
		<li style="background-color:#EEF5FD"><a href="cont.php?bd=<?php echo $bd;?>">Bangladesh</a>
			<ul>
<?php
    while($row = mysql_fetch_array($tree))
            {
                ?>
				<li style="background-color:#EEF5FD"><a href="div.php?divid=<?php echo $row['divid'];?>"><?php echo $row['divname']; ?></a>
					<ul>
                <?php
                $divid = $row['divid'];
                $dist = @mysql_query("SELECT * FROM districts WHERE divid='$divid'");
                while($rowdist = @mysql_fetch_array($dist))
               {  
                ?>
						<li style="background-color:#EEF5FD"><a href="#" ><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = @mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = @mysql_fetch_array($upo)){
							?>
                                <li style="background-color:#EEF5FD"><a href="upo_attend.php?upoid=<?php echo $row['upoid'];?>"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= @mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = @mysql_fetch_array($hos)){
									?>
										<li style="background-color:#EEF5FD"><a href="hos.php?hosid=<?php echo $rowhos['hosid'];?>"><?php echo $rowhos['hosname']; ?></a></li>
									<?php }?></ul>
								</li>
                               <?php }?> </ul>
               		  </li>
                    <?php
                }?>
					</ul>
				</li>
                <?php
            }?>
			</ul>
		</li>
	</ul>

</div></td>
   <td colspan="4">&nbsp;</td>
   </tr>
	</table>	


	
    <?php
    /*mysql_connect("103.247.238.173","root","mistestdb");
    mysql_select_db("org_registry");*/
    $tree = mysql_query("SELECT * from divisions");
	
    ?>

</form>
</body>
</html>