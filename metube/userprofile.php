<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "functions.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />



<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function saveDownload()
{
	$.post("media_download_process.php",
	{
       id: id,
	}, function(message){} );
} 

function addfriend(id)
{
	window.location = "useradd.php"
}
</script>
</head>

<body>
<div id="wrapper">



<?php include('header_sanslogin.php'); ?>

<?php include('navindex.php'); ?>

<div id="content">


<p>Hai this is <?php echo $_SESSION['username'];?> Welcome to my page!!</p>
<button type="button" name = "Message">Message me!</button>
<button type="button" name = "Add" onclick="addfriend(id)">Add me!</button>
</div>
<br/><br/>
<?php


	$query = "SELECT * from media"; 
	$result = mysql_query( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <br>
       <br>
          <br>
             <br>
    <div style="background:#339900;color:#FFFFFF; width:150px;height: 50px">Uploaded Media</div>
	<table width="50%" cellpadding="0" cellspacing="0">
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
            	<a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[1];?></a> stored in <?php echo $result_row[3].$result_row[1];?>
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
