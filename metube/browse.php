<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "functions.php";
//	include_once "tag_cloud.php";
	static $favrow;
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />



<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function Download()
{  // alert("I am an alert box!");
	window.location = "media_download_process.php"

} 

</script>
</head>

<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">


<p>Welcome <?php if(isset($_SESSION['username'])) { echo $_SESSION['username']; } ?></p>
   <p> Private media will not be displayed. The available Public Videos are..</p> 
<?php include_once "tag_cloud.php"; ?>  
   <br>
     <?php if(isset($_SESSION['username'])) {  ?>
     <a href='media_upload.php'  style="color:#FF9900;">Upload File</a>
<div id='upload_result'>
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{
		
		echo upload_error($_REQUEST['result']);

	}
?>
</div>
<?php } ?>

<br/><br/>

<?php

		if(isset($_GET['category']))
		{
			$cate= $_GET['category'];
			 $query = "SELECT * from media  where visibility='1' AND category='".$cate."' ORDER BY RAND() LIMIT 10;";
			}
		else if(isset($_GET['ru']))
		{
			$query ="select * from media order by `uploadtime` desc";
			echo "Most recently uploaded viedeos are";
		}
		else if(isset($_GET['rv']))
		{
			$query ="SELECT * FROM `media` order by count desc";
			echo "Most viewed viedeos are";
		}
	
		else {
 $query="select * from media where visibility='1' ORDER BY RAND() LIMIT 10;";
		}
		
		

	
	$result = mysql_query( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
 
    <div style="background:#339900;color:#FFFFFF; width:150px;">Available Media</div>
    
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			while ($result_row = mysql_fetch_row($result))
			{ //echo "Private media will not be displayed. The available Public Videos are..";
		?>
        <tr valign="top">			
			<td>
					<?php 
						echo $result_row[0];
						$mediauserid = $result_row[2];

$usname = "select * from account where userid='".$mediauserid."'";
						$resname= mysql_query($usname);
						$resrow = mysql_fetch_array($resname);
					?>
			</td>
            <td>
            	<a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[1];?></a> uploaded by <?php echo $resrow['name'];?>
            </td>
            <td>
            	<a href="<?php echo $result_row[3].$result_row[1];?>" onclick="Download()">Download</a>
            </td>
		</tr>
        <?php
			}
		?>
	</table>
    <h2>Categories</h2>
        <?php
    $catquery="select distinct category from media ORDER BY category ASC";
	$catresult = mysql_query($catquery) ; 
	if(!$catresult)
	{die('errrrrrrr'.mysql_error());
	}
	?>
	
	<table>
<?php 
while($crow = mysql_fetch_array($catresult))
{
	$category=$crow['category'];
	?>
	<tr>
	<td><a href="browse.php?category=<?php echo $category; ?>"><?php echo $category; ?></td></tr>
<?php } ?>
<tr><td><a href="browse.php">All</a></td></tr>
</table>
<br>
<br>
<a href = "browse.php?ru=1">Order the above media by <b><i>Most recently Uploaded</i></b></a> <br> <br>
<a href = "browse.php?rv=1">Order the above media by <b><i>Most Viewed</i></b></a>
<a href='friend.php'  style="color:#FF9900;">Members Area</a>

<?php  if(isset($_SESSION['username'])) {
	?>
	<h2> Favorite List</h2>
	<?php
$username = $_SESSION['username'];
	$query = "select * from account where name='".$username."'";
	$result = mysql_query( $query );
	$row = mysql_fetch_row($result);
	$userid = $row[0];
	$favquery= "select * from fav_media where userid='".$userid."'";
	$favresult= mysql_query($favquery) or die(mysql_error());

?>
	<table width="50%" cellpadding="0" cellspacing="0">
<?php
	while($favrow = mysql_fetch_row($favresult))
	{
?>
		<tr valign="top">			
			<td>
<?php
	$mediaid=$favrow[1];
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

</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>
