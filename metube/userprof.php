<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Profile</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<?php
	session_start();
	include_once "functions.php";
?>
<script type="text/javascript" src="js/jquery-latest.pack.js">
	
</script>
<script type="text/javascript">
function addfriend()
{
	window.location = "friend.php"
} 

function message()
{
	window.location = "compose.php"
}
</script>

</head>

<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">

<?php

$uid= $_GET['uid'];
//echo $uid;

$usernamequery= "select * from account where userid='".$uid."'";
$usernamequeryresult = mysql_query($usernamequery) or die(mysql_error());
$usernamerow = mysql_fetch_array($usernamequeryresult);
$username= $usernamerow['name'];
//echo $username;



 
?>

<p>Hai this is <?php echo $username;?> Welcome to my page!!</p>

<?php
if ($username != $_SESSION['username'])
{

 ?>  
<button type="button" name = "Message" onClick="message()">Message me!</button>
<button type="button" name = "Add" onclick="addfriend()">Add me!</button>
</div>
<br/><br/>


<?php
}
else {
	
	?> 
	<a href= "userhome.php"> Update Profile </a>
	<?php
}


	$query = "SELECT * from media where userid = '".$uid."'"; 
	$result = mysql_query( $query ) or die(mysql_error());
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <br>
       <br>
          <br>
             <br>
    <div style="background:#339900;color:#FFFFFF; width:150px;height: 50px"> My Uploaded Media</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<tr> <td> Media id</td>  <td>Name of the Media</td></tr>
		<?php
			while ($result_row = mysql_fetch_row($result))
			{ 
		?>
        <tr valign="top">			
			<td>
					<?php 
						echo $result_row[0];
					?>
			</td>
            <td>
            	<a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[1];?></a> of type <?php echo $result_row[4]; ?>
            </td>
            <td>
            	<a href="<?php echo $result_row[3].$result_row[1];?>" target="_blank" onclick="saveDownload(<?php echo $result_row[0];?>);">Download</a>
            </td>
		</tr>
        <?php
			}
		?>
	</table>
</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->

	
</body>
</html>
