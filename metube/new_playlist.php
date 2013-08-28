

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include_once "functions.php";
?>

<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<title>New Playlist</title>
<?php

if(isset($_POST['submit']))
{
	$playlistname= $_POST['Playlist'];
	$username = $_SESSION['username'];
	$query = "select * from account where name='".$username."'";
	$result = mysql_query( $query ) or die(mysql_error());
	$row = mysql_fetch_row($result);
	$userid = $row[0];
	
	$pquery="Insert into playlists (name,userid)Values ('".$playlistname."', '".$userid."');";
	$add_playlist = mysql_query($pquery) or die(mysql_error());
	if($add_playlist)
	{
		echo "Play List Created!!";
	}
}




?>
</head>
	<body>
		<div id="wrapper">

<?php include('header.php'); ?>

<?php include('navindex.php'); ?>

<?php include('footer.php'); ?> 			
<form name = 'playlist' action='new_playlist.php' method='post'>
	<table><tr><td>New Playlist Create </td>
<td><input type='text' name='Playlist' /></td></tr>
<tr><td><input type ='submit' value='Create!' name='submit'></td></tr>
</table>
	
</form>
<a href='playlist.php'  style="color:#FF9900;">Go back..!!</a>
</div> <!-- End #wrapper -->
</body>
</html>
