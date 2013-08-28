
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unsubscribe</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

</head>

<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">





<table width="100%" align="center">

               <?php
               session_start();
include_once "functions.php";

$username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result = mysql_query( $query );
	$row = mysql_fetch_row($result);
	$userid = $row[0];
	
            $subuserid = $_GET['sub_id'];
   $unsubquery="Select userid from account_channel where subid=".$userid;
   $unsubqueryresult=mysql_query($unsubquery);
   $resultrow= mysql_num_rows($unsubqueryresult);
   if($resultrow==0)
   {
   	echo'Nothing to subscribe from , you are yet to be subscribed to this user. If interested go back and subscribe';
	
   }
   else {
       $delquery="Delete from account_channel where userid='".$subuserid."'and subid='".$userid."'";
	   mysql_query($delquery);
	   echo "successfully unsubscribed ";
   }
   
      ?>
</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>
