
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include_once "functions.php";
static $query;
?>

<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<title>Playlists</title>

</head>
	<body>
		<div id="wrapper">

<?php include('header.php'); ?>

<?php include('nav.php'); ?>

<?php include('navindex.php'); ?>


<div id="content">


<?php

if(isset($_SESSION['username']))
	{
	    echo "<a href='new_playlist.php'>Create New Playlist</a><br><br><br>";
	    $username = $_SESSION['username'];
$query = "select * from account where name='$username'";
$result = mysql_query( $query );
$row = mysql_fetch_row($result);
$userid = $row[0];
	    if(isset($_GET['playlist']))
		{
			$play= $_GET['playlist'];
			$result = mysql_query( "SELECT * from playlists where name='".$play."'") or die(mysql_error());
	        if (!$result)
	        {
	           die ("Could not query the playlist table in the database: <br />". mysql_error());
	        }
			$result_row = mysql_fetch_row($result);
			$playlistid= $result_row[0];
			$mediaidquery="Select * from media_playlist where playlistid='".$playlistid."'";
			$mediaidquery1=mysql_query($mediaidquery) or die(mysql_error());
?>
<br><br><br>
    <div style="background:#339900;color:#FFFFFF; width:150px;"><b>List of Media in <?php echo"<b>". $_GET['playlist'];?> </b></div>
    
	<table width="50%" cellpadding="0" cellspacing="0">
<?php
			while ($mediaidrow = mysql_fetch_row($mediaidquery1))
			{ 
?>
        <tr valign="top">			
			<td>
<?php 
			$mediaid=$mediaidrow[1];
			$mediaquery="Select * from media where mediaid='".$mediaid."'";
			$mediaquery1=mysql_query($mediaquery) or die(mysql_error());
			$mediarow=mysql_fetch_row($mediaquery1);
						
?>
			</td>
            <td>
            	<a href="media.php?id=<?php echo $mediarow[0];?>" target="_blank"><?php echo $mediarow[1];?></a> 
            </td>
            <td>
            	<a href="<?php echo $mediarow[3].$mediarow[1];?>" onclick="Download()">Download</a>
            </td>
		</tr>
<?php
			}
        }
?>
	</table>
<br>

<p><b>List of Playlists</b></p>
<?php

        $playquery="select name from playlists where userid ='".$userid."' ORDER BY name ASC";
	    $playresult = mysql_query($playquery) ; 
	    if(!$playresult)
	    {
	        die('errrrrrrr'.mysql_error());
	    }
?>
	<table>
<?php 
    while($prow = mysql_fetch_array($playresult))
    {
	   $playlist=$prow['name'];
?>
	<tr>
	<td><a href="playlist.php?playlist=<?php echo $playlist; ?>"><?php echo $playlist; ?></td></tr>
<?php 
    }
}

else {
	echo"<h1>login to access</h1>";
} ?>
</table>

			

</div> <!-- End #wrapper -->
<?php include('footer.php'); ?> 
</div>
</body>
</html>

