<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include "functions.php";

$username = $_SESSION['username'];
$query = "select * from account where name='$username'";
$result = mysql_query( $query );
$row = mysql_fetch_row($result);
$userid = $row[0];
$email = $row[3];
$own=0;
//$mediaid = $_GET['mid'];
//echo "$mediaid";
?>

<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<title>MeTube-Group 6</title>
</head>
    <body>
        <div id="wrapper">

<?php include('header.php'); ?>

<?php include('nav.php'); ?>

<?php include('navindex.php'); ?>

<div id="content">
<?php    
if(isset($_POST['submit']))
{
      $dquery11="INSERT INTO  comments_tutor (name ,email, message ,parent, mediaid) VALUES('".$username."','".$email."','".$_POST['contents']."','".$_GET['cid']."','".$_GET['mediaid']."');";
      $dresult = mysql_query($dquery11) or die('Error: ' . mysql_error()); 
      
}
?>    
<table width="364" height="115">
<tr>
<form name="reply.php" method="post">
<td width="279">
<textarea name="contents" cols="80" rows="5" id="contents"> Enter your views here...</textarea>
</td><td align="center" width="122">
<input name="submit" type="submit" id="submit" value="discuss"/>
 
</td>
</form>
</tr>
</table>
<?php
print "<a href='comments_new.php?mid=".$_GET['mediaid']."'>go back to see all comments </a>";
?>

</div> <!-- end #content -->

<?php// include('sidebar.php'); ?>


<?//php include('footer.php'); ?>             
        
</td>
</form>
</tr>
</table>

<?php include('footer.php'); ?>             

</div> <!-- End #wrapper -->
</body>
</html>
