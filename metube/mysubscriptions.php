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

<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">
<table width="100%" align="center">
<?php
if(isset($_SESSION['username']))
    {

  $username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result = mysql_query( $query );
	$row = mysql_fetch_row($result);
	$userid = $row[0];
echo"Media I have subscribed to";

$mysubquery="Select DISTINCT mediaid from account_channel where `subid`='".$userid."'";
$mysubresult=mysql_query($mysubquery) or die(mysql_error());
$numberofsubscriptions = mysql_num_rows($mysubresult);
if($numberofsubscriptions!=0)
{
	 while($mediarow=mysql_fetch_array($mysubresult))
{ $mediaid=$mediarow['mediaid'];
$query= "select * from media where mediaid='".$mediaid."' and visibility='1';";
 $result = mysql_query($query);
 $count=0;
$total = mysql_num_rows($result);
if($total!=0){
while($mrow= mysql_fetch_array($result))
{
	$count=$count+1;

$acid =$mrow['userid'];
//$name=$mrow['filename'];
$nme=$mrow['name'];
$type=$mrow['type'];
$utime=$mrow['uploadtime'];
       $format=$mrow['format'];
       $path=$mrow['path'];
	   $usernamequer="Select * from account where userid='".$acid."'";
	   $usernameresult= mysql_query($usernamequer) or die(mysql_error());
	   $usernamerow= mysql_fetch_array($usernameresult);
	   $usernameup = $usernamerow[1];
	  
	   if($count>5)
	   {
		$count=0;   
		echo "</tr><tr>";   
	   }
       if($type=='audio'){
       print "<td><table><tr><td><a href='media.php?id=".$mediaid."'>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$mediaid."'><br/><br/>$nme</a><br/><br/><br/><i> uploaded by ".$usernameup."<br/> on ".$utime."</font></i> </td>"; }
else if($type=="video"){
       print "<td><table><tr><td><a href='media.php?id=".$mediaid."'></a></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$mediaid."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$usernameup."<br/> on ".$utime."</font></i> </td>";        }
       else
       {
               print "<td><table><tr><td><a href='media.php?id=".$mediaid."'></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$mediaid."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$usernameup."<br/> on ".$utime."</font></i> </td>";}

}

    }else{
		echo "<h2 align='center'>No Media!</h2>";
		}
 echo "</tr></table></table> ";

}}
else if($numberofsubscriptions==0){echo 'NO SUBSCRIPTIONS';}
}
else
{
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
