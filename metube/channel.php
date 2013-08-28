
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Channels</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<?php 
session_start();
include_once "functions.php";
?>
</head>
<body class="BB" bgcolor="#FFFFFF">
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">
 
  <h4><font>Channels on MeTube</font></h4>
   
<?php 
if(isset($_SESSION['username']))
    {

$cq="SELECT * FROM account";
$cr = mysql_query($cq) or die(mysql_error());
   echo "<table>";
while($crw= mysql_fetch_array($cr))
{
       $aid=$crw['userid'];
	   $username= $crw['name'];
       echo "<tr>
       <td><a href='channel.php?channel_category=".$aid."'
style='text-decoration:none' >".$username."</td>";
echo "<td> <a href='subscribe.php?sub_id=".$aid."'> Subscribe </a>  <a href='unsubscribe.php?sub_id=".$aid."'> UnSubscribe </a> </tr>"; 
}
echo "</table>";

       ?>

   <h3 ><font>Channels</font></h3>
 <table width="100%" align="center">

               <?php

               if(!isset($_GET['channel_category']))
 {

       

echo " Select a channel from the left!";

 }
 else{
       
echo "<table>
<tr><td align='left'> <h4><i><font >".$_GET['channel_category']." Channel is chosen</font></i></h4></td></tr>
  <tr><td><table><tr>";
$query= "select * from media where userid='".$_GET['channel_category']."' and visibility='1';";
 $result = mysql_query($query);
 $count=0;
$total = mysql_num_rows($result);
if($total!=0){
while($mrow= mysql_fetch_array($result))
{
	$count=$count+1;
$id=$mrow['mediaid'];
$acid =$mrow['userid'];
//$name=$mrow['filename'];
$nme=$mrow['name'];
$type=$mrow['type'];
$utime=$mrow['uploadtime'];
       $format=$mrow['format'];
       $path=$mrow['path'];
	   if($count>5)
	   {
		$count=0;   
		echo "</tr><tr>";   
	   }
       if($type=='audio'){
       print "<td><table><tr><td><a href='media.php?id=".$id."'>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i> uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>"; }
else if($type=="video"){
       print "<td><table><tr><td><a href='media.php?id=".$id."'></a></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>";        }
       else
       {
               print "<td><table><tr><td><a href='media.php?id=".$id."'></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>";}

}

    }else{
		echo "<h2 align='center'>No Media!</h2>";
		}
 echo "</tr></table></table> ";
}
}
else {
	echo"<h1>login to access</h1>";
}
?>
</table>



</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>

