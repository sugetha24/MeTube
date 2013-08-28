<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "functions.php";
	static $ratingimg;
	static $usuid;
static $pupr;
static $usuid;
static $userid;

?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<?php
if(isset($_GET['id'])) {
	$username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("errrrrrrr". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		$userid = $row[0];
	}
	$userid_view=$userid;
	$id=intval($_GET['id']);
	
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	$usuid=$result_row[2];
	$pupr=$result_row[8];
	updateMediaTime($_GET['id']);
}
else
	{
			print "<meta http-equiv='refresh' content='0;url=browse.php'>";
			}
$qwes="SELECT * from blocked_users where recipient='".$userid."' AND sender='".$usuid."';";
$rult = mysql_query($qwes) or die('error!');
$md_row= mysql_fetch_array($rult);
//$usuid=$mdia_row['_userid'];
if($md_row!=0)
{
//	echo "supre";
	print "<meta http-equiv='refresh' content='0;url=browse.php'>";
}
$priflag=0;
if($pupr==0 && $userid==$usuid) 
{
	$send_as_msg=1;
	$priflag=1;
}
else if($pupr==1)
{
	$priflag=1;
}?>
	<script type="text/javascript" language="javascript">
function confirm_box()
{
alert("Are you sure ?");
}
function added()
{
alert("Added to Playlist!");
}
function no_playlist() 
{
alert("No playlist Selected!");
}


</script> 
</head>
<body>
<?php	
    $query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	$filename=$result_row[1];
	$account_userid=$result_row[2];
	$description=$result_row[6];
	$category=$result_row[5];
	$timestamp=$result_row[9];
	$format=$result_row[7];
	$filepath=$result_row[3];
	$type=$result_row[4];
	$querymediaowner= "SELECT account.name FROM account, media WHERE account.userid = media.userid AND mediaid ='".$_GET['id']."'";
	$resultmediaowner=mysql_query($querymediaowner);
	$result_rowmediaownder=mysql_fetch_row($resultmediaowner);
	$mediaowner=$result_rowmediaownder[0];
	$viewquery="Update media set count=count+1 where mediaid='".$_GET['id']."'";
	$viewquery1=mysql_query($viewquery) or die(mysql_error());

	 if(isset($_POST['playlist_submit']))
{
	$plid=$_POST['playlist'];
	
	if($plid==6)
	{
	echo "<script language='javascript'> no_playlist(); </script>";	
    }else{
	$plsq = "insert into media_playlist(playlistid,mediaid) values (".$plid.",".$_GET['id'].");";
	$rees = mysql_query($plsq);
	echo "<script language='javascript'> added(); </script>";
	}
	
	}
if(isset($_POST['rate_media']))
{
	$rate=$_POST['rating'];
	
	$qw= "select * from media_rating where mediaid=".$id." and userid='".$userid."';";
	$qwres = mysql_query($qw); 
	$qwrow = mysql_fetch_array($qwres);
	$qwvalue=$qwrow['rating'];
    if(mysql_num_rows($qwres)==0)
	{
	$ratesq = "insert into media_rating(userid,rating,mediaid) values ('".$userid."',".$rate.",".$_GET['id'].");"; //check if its $_GET[mediaid] !!!!!
	$ratere = mysql_query($ratesq);
	}
	else
	{
	$ratesq = "UPDATE media_rating SET rating=".$rate." where userid='".$userid."' and mediaid=".$_GET['id'].";";
	$ratere = mysql_query($ratesq);
	}
	}

if(isset($_POST['delete_media']))
	{
		
$qy1="delete from media_playlist where mediaid=".$_GET['id'].";";
$result=mysql_query($qy1) or die('Error');

$qy1="delete from media_rating where mediaid=".$_GET['id'].";";
$result=mysql_query($qy1) or die('Error');
$qy1="delete from mediatags where mediaid=".$_GET['id'].";";
$result=mysql_query($qy1) or die('Error');

$qy1="delete from fav_media where mediaid=".$_GET['id'].";";
//echo $qy1;
$result=mysql_query($qy1) or die('Error');

$qy1="delete from downloads where mediaid=".$_GET['id'].";";
//echo $qy1;
$result=mysql_query($qy1) or die('Error');


$qy1="delete from media where mediaid=".$_GET['id'].";";
//echo $qy1;
$result=mysql_query($qy1) or die('Error');

print "<meta http-equiv='refresh' content='0;url=browse.php'>";

}
	
 
 if(isset($_POST['fav_submit']))
{
		$qw= "select * from fav_media where mediaid=".$id." and userid='".$userid."';";
	$qwres = mysql_query($qw); 
	$qwrow = mysql_fetch_array($qwres);
	
    if(mysql_num_rows($qwres)==0)
	{
	$fvsq = "insert into fav_media(userid,mediaid) values ('".$userid."',".$_GET['id'].");";
	$rees = mysql_query($fvsq);
	}
	
}
	

if(isset($_POST['mediarec']))
{
	$accid=$_POST['reco'];
	$mmid=$_POST['mediaid'];
	
	$qmedrec= "select * from media_rec where mediaid='".$mmid."' and userid='".$accid."';";
	//echo $qmedrec;
	$qwresult = mysql_query($qmedrec); 
	$qwrow1 = mysql_fetch_array($qwresult);
	//echo mysql_num_rows($qwresult);
	if(mysql_num_rows($qwresult)!= 1){
	$qy= "INSERT INTO media_rec (userid,mediaid) VALUES ('".$accid."', '".$mmid."' );";;
	//echo $qy;
	$result=mysql_query($qy) or die('Error');
}
else {echo "<font size='-1'><b>Already added to Recommended Media</b></font>";}
}
	?>
	<script type="text/javascript" language="javascript">

function Confirm()
{
alert("Sure?");
}

</script> 
 <?php
  if($priflag==0)
{
	
if(isset($_SESSION["username"]))
{
	$privsql="select * from blocked_users where receipient='".$usuid."'";
	$privres = mysql_query($privsql) or die('error!');
	if(mysql_num_rows($privres)==0)
	{
	echo "<center><h4>You dont have access to this media!! </h4></center>";
	}else{
	while($priv = mysql_fetch_array($privres))
	{
		$allowid=$priv['receipient'];
	    if($allowid== $userid)     
		{
			  ?>
  <table width="100%">
  <tr>
       <td width="50%"> <font size="-1">MediaOwner:</font> </td><td width="50%"> <font size="-1"><?php echo $mediaowner; ?></font></td>
     </tr>
     
     <tr>
       <td> <font size="-1">Category:</font></td><td> <font size="-1"> <?php echo $category;?></font></td>
     </tr>
     
     <?php
    $query= "select avg(rating) from media_rating where mediaid=".$id;
    ?>
    <tr>
    <td> <font size="-1">Rating:</font></td><td> <?php
	$result = mysql_query($query);
	$rating = mysql_fetch_array($result);
	$num_rating = mysql_num_rows($result);
	if(!isset($rating[0]))
	{
        for($i=0 ; $i<5 ; $i++) 
        { 
        	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' height='20'/>";
        }
    }
	else
	{
		$temp = $rating[0];
		$temp = explode(".", $temp);
		for($i=0 ; $i<$temp[0] ; $i++) 
        { 
        	$ratingimg =  $ratingimg."<img src='star.png' width='20' height='20'/>";
        }
		if($temp[1] != 0)
		{
			$ratingimg = $ratingimg."<img src='star.png' width='20' height='20'/>";
			$t = 5- ($temp[0] + 1);
			for($i=0 ; $i<$t ; $i++) 
	        {	 
    	    	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' height='20'/>";
        	}	
		}
		else
		{
			$t = 5- ($temp[0]);
			for($i=0 ; $i<$t ; $i++) 
	        {	 
    	    	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' heigth='20'/>";
        	}
		}
	}
	echo $ratingimg;
  ?></td>
    </tr>  
     <tr>
       <td> <font size="-1">Description:</font></td><td><font size="-1"> <?php echo $description; ?></font></td>
     </tr>
    </table>
    <!-- end of sidebar1 ??--> </div>
<div id="sidebar2">

  <table width="100%" height="90">
    <td width="50%" align="left" bgcolor="#CCCCCC"><font size="-1"> Add to playlist: </font></td><td valign="middle" width="50%" align="left" bgcolor="#CCCCCC">
      
<?php if(isset($userid))
{
	$sql = "SELECT * FROM playlists WHERE userid = '".$userid."'; ";
	$res = mysql_query($sql);
	$plst = "<form method='post'><select name='playlist'>";
	while($playlist = mysql_fetch_array($res))
	{		
		$plst =$plst."<option value='".$playlist[0]."'>".$playlist[1]."</option>";
	}
	$plst =$plst."<option value='6' selected='selected'>--------</option>
				  </select>
			<input type='submit' name = 'playlist_submit' value='Select'/>
				</form>";


?><?php //echo $plst;?></td>
       <tr>
          <td bgcolor="#FFFFCC" width="50%" align="right"><font size="-1"> Add Rating: </font></td>
         
          <td bgcolor="#FFFFCC" width="50%" align="center" valign="middle">
      
<?php if(isset($userid))
{
	$qw= "select * from media_rating where mediaid=".$id." and userid='".$userid."';";
	
/* Before the query used was this
$qw= "select * from media_rating where mediaid=".$id.";";*/
	$qwres = mysql_query($qw); 
	$qwrow = mysql_fetch_array($qwres);
	$qwvalue=$qwrow['rating'];
	  
	  echo "	<form method='post'>
	  <select name='rating' id='rating'>";
	  if($qwvalue==0){
		echo "<option value='0' selected='selected'> 0 </option>";
	  }else 
	  {
		echo "<option value='0'> 0 </option>";	  
	  }
	    if($qwvalue==1){
		echo "<option value='1' selected='selected'> 1 </option>";
	  }else 
	  {
		echo "<option value='1'> 1 </option>";	  
	  }
	    if($qwvalue==2){
		echo "<option value='2' selected='selected'> 2 </option>";
	  }else 
	  {
		echo "<option value='2'> 2</option>";	  
	  }
	    if($qwvalue==3){
		echo "<option value='3' selected='selected'> 3 </option>";
	  }else 
	  {
		echo "<option value='3'> 3 </option>";	  
	  }
	    if($qwvalue==4){
		echo "<option value='4' selected='selected'> 4 </option>";
	  }else 
	  {
		echo "<option value='4'> 4 </option>";	  
	  }
	    if($qwvalue==5){
		echo "<option value='5' selected='selected'> 5 </option>";
	  }else 
	  {
		echo "<option value='5'> 5 </option>";	  
	  }

	echo"  </select>
	  <input type='submit' name = 'rate_media' value='Rate'/>
	 </form>";
	 
	 	//	}
	 
}

?></td> </tr>
 <tr>
 <td bgcolor="#FFFFCC" align="left" width="50%"><font size="-1"> Add to Favourites: </font></td>
 <td width="50%" bgcolor="#FFFFCC" valign="middle" align="center">
      
<?php if(isset($userid))
{
	
	$qfavmed= "select * from fav_media where mediaid=".$id." and userid='".$userid."';";
	$qwres = mysql_query($qfavmed); 
	$qwrow = mysql_fetch_array($qwres);
		if(mysql_num_rows($qwres)!=0)
	{	
		
		echo "<font size='-1'><b>Added to favorites</b></font>";
	}
	else {
		echo " <form method='post'><input type='submit' name = 'fav_submit' value='Add'/></form>";
}
}
?> 
</td></tr>


<tr>
         <?php
    $vquery= "select * from media where mediaid=".$id;
    $vresult = mysql_query($vquery);
$row= mysql_fetch_array($vresult);
	$views= $row["count"];

    ?>
     
       <td align="right" width="50%" bgcolor="#CCCCCC"	><font size="-1"> Views: </font></td><td bgcolor="#CCCCCC" width="50%" align="center" valign="middle">  <?php echo $views;  ?></td>
    </tr> 

<?php
if (isset($userid))
{
?>
<!--<tr><td bgcolor="#CCCCCC"><font size='-1'>Download Media</font></td><td bgcolor="#CCCCCC"><form><input type="button" value="Download Media" onClick="window.location.href='<?php echo 'http://mmlab.cs.clemson.edu/spring12/g4';echo $path;echo $file_name;echo '.';echo $format; ?>'"></form></td></tr>-->
<!--
<<tr><td colspan='2' align='center'bgcolor="#CCCCCC"><font size='-3'>Right click and hit save as</font></td></tr>
-->
<?php
echo "<tr><td>"; 
	
   echo "<form name='mediarec' method='post'>";
   echo"<input type='hidden' name='reco' value='".$userid."' />";
    echo"<input type='hidden' name='mediaid' value='".$id."' />";
   
   echo "<input type='submit' name='mediarec' value='Recommend' onclick='Confirm()'/>
  </form>";
 echo "</td> </tr>";
?>

<?php }  ?>

     </table>
    
    <h3>Comments</h3>
<?php
}
$userid = $userid;
//echo $userid;


if(isset($userid))
{

?>	
<a href ='comments_new.php?mid=<?php echo $_GET['id'] ?>' > Click here to contribute comments to this video</a>
 

<?php
}
echo "<table width='100%' border='0'>";
$bg=0;

echo "</table>";
?>
    &nbsp;
    <br/>
	  <?php	
			break;
			}else{$xx=1;
			 }
	}//end of outer else
	if($xx==1)
				{
				echo "<center><h4>Yous dont have access to this media!! </h4></center>";
				}
	
	}
	//echo "<center><h4>You dont have access to this media!! </h4></center>";
	
  ?>
  
   &nbsp;
    <br/>
   
   <!-- end #sidebar2 -->
</div>
  
<div id="mainContent">
 
  <table width="400" height="537">
    <tr><td><i><?php echo "<h3>".$media_name."</h3>";?></i>
</td>
<?php 
if($userid==$usuid)
{
?>	<td align="right" colspan="3">
<?php
echo "<form name='delete_media' method='post'><table align='right'><tr><td>";
echo "Delete Media</td><td><input type='submit' name='delete_media' value='Delete'/></td></tr></table>
  </form>";

?></td><?php
} //endif
?>
</tr>
<tr>
    <td colspan="8" height="500">
	<?php if($type=='image')
	{
	echo "<img src='".$filepath.$media_name."' />" ;
	//echo $filepath.$filename;
//echo "<img src='".$filepath.$filename."'/>";
}else 
    {	
   
    ?>
	<object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $filepath.$filename;  ?>">
<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

<embed type="application/x-mplayer2" src="<?php echo $filepath.$filename;  ?>" name="MediaPlayer" width=320 height=240></embed>

</object>
    </td>
</tr>
  </table>
  
<?php } ?>
  <h2>Recommended Media Similar to this one</h2>
  <?php
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	$medianame = $result_row[1];
	$mediadesc = $result_row[6];
	$mediatype = $result_row[4];
	$mediacat = $result_row[5];	
				
			$srch= "select * from media where name like '%".$medianame."%' or description like '%".$mediadesc."%' or type='".$mediatype."' or category='".$mediacat."'";
			//echo $srch;
			$search_result = mysql_query($srch) or die('error'.mysql_error());
			
			//echo $sr['mediaid'];
			?>
			<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			while ($result_row = mysql_fetch_row($search_result))
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
            	<a href="<?php echo $result_row[3].$result_row[1];?>" onclick="Download()">Download</a>
            </td>
		</tr>
        <?php
			}
		?>
	</table>
		
    ?>
  
  
  <!--
      <table>
<tr><td align="left"> <h4>Recommended Media</h4></td></tr>
   <tr><td><table><tr> 
//ENTER RECOMMENDED MEDIA HERE
    </tr></table></td></tr></table> -->
    
  <?php  }else {?>

<!-- <meta http-equiv="REFRESH" content="0;url=http:index.php"> -->
<?php   } 
 } else { //CASE FOR PUBLIC MEDIA! ?>
  <table width="100%">  
  <tr>
       <td width="50%"> <font size="-1">MediaOwnder:</font> </td><td width="50%"> <font size="-1"><?php echo $mediaowner; ?></font></td>
     </tr>
     <tr>
       <td> <font size="-1">Category:</font></td><td> <font size="-1"> <?php echo $category;?></font></td>
     </tr>
     
     <?php
    $query= "select avg(rating) from media_rating where mediaid=".$id;
    ?>
     <tr>
       <td> <font size="-1">Rating:</font></td><td> <?php
	$result = mysql_query($query);
	$rating = mysql_fetch_array($result);
	$num_rating = mysql_num_rows($result);
	if(!isset($rating[0]))
	{
        for($i=0 ; $i<5 ; $i++) 
        { 
        	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' height='20'/>";
        }
    }
	else
	{
		$temp = $rating[0];
		$temp = explode(".", $temp);
		for($i=0 ; $i<$temp[0] ; $i++) 
        { 
        	$ratingimg =  $ratingimg."<img src='star.png' width='20' height='20'/>";
        }
		if($temp[1] != 0)
		{
			$ratingimg = $ratingimg."<img src='star.png' width='20' height='20'/>";
			$t = 5- ($temp[0] + 1);
			for($i=0 ; $i<$t ; $i++) 
	        {	 
    	    	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' height='20'/>";
        	}	
		}
		else
		{
			$t = 5- ($temp[0]);
			for($i=0 ; $i<$t ; $i++) 
	        {	 
    	    	$ratingimg =  $ratingimg."<img src='nostar.png' width='20' height='20'/>";
        	}
		}
	}
	echo $ratingimg;
  ?></td>
    </tr>  
     <tr>
       <td> <font size="-1">Description:</font></td><td><font size="-1"> <?php echo $description; ?></font></td>
     </tr>
    </table>
    <!-- end of sidebar1 ??--> </div>
<div id="sidebar2">

  <table width="100%" height="90">
<?php if(isset($userid)) { ?>
  <tr><td width="50%" align="left" bgcolor="#CCCCCC"><font size="-1"> Add to playlist: </font></td><td valign="middle" width="50%" align="left" bgcolor="#CCCCCC">
      
<?php 	$sql = "SELECT * FROM playlists WHERE userid = '".$userid."'; ";
	$res = mysql_query($sql);
	$plst = "<form method='post'><select name='playlist'>";
	while($playlist = mysql_fetch_array($res))
	{		
		$plst =$plst."<option value='".$playlist[0]."'>".$playlist[1]."</option>";
	}
	$plst =$plst."<option value='6' selected='selected'>--------</option>
				  </select>
			<input type='submit' name = 'playlist_submit' value='Select'/>
				</form>";
 echo $plst;
 ?></td></tr>
       <tr>
          <td bgcolor="#FFFFCC" width="50%" align="left"><font size="-1"> Add Rating: </font></td>
         
          <td bgcolor="#FFFFCC" width="50%" align="center" valign="middle">
      
<?php

$qw= "select * from media_rating where mediaid=".$id." and userid='".$userid."';";

/* Before the query used was this
$qw= "select * from media_rating where mediaid=".$id.";";*/
	$qwres = mysql_query($qw); 
	$qwrow = mysql_fetch_array($qwres);
	$qwvalue=$qwrow['rating'];
/*	
	if(mysql_num_rows($qwres)!=0) // Condition we used before -> if($qwrow['mediaid']==$id)
		{
		echo "<font size='-1'><b>Already rated</b></font>";
		}
		else{
*/
echo "	<form method='post'>
	  <select name='rating' id='rating'>";
	  if($qwvalue==0){
		echo "<option value='0' selected='selected'> 0 </option>";
	  }else 
	  {
		echo "<option value='0'> 0 </option>";	  
	  }
	    if($qwvalue==1){
		echo "<option value='1' selected='selected'> 1 </option>";
	  }else 
	  {
		echo "<option value='1'> 1 </option>";	  
	  }
	    if($qwvalue==2){
		echo "<option value='2' selected='selected'> 2 </option>";
	  }else 
	  {
		echo "<option value='2'> 2</option>";	  
	  }
	    if($qwvalue==3){
		echo "<option value='3' selected='selected'> 3 </option>";
	  }else 
	  {
		echo "<option value='3'> 3 </option>";	  
	  }
	    if($qwvalue==4){
		echo "<option value='4' selected='selected'> 4 </option>";
	  }else 
	  {
		echo "<option value='4'> 4 </option>";	  
	  }
	    if($qwvalue==5){
		echo "<option value='5' selected='selected'> 5 </option>";
	  }else 
	  {
		echo "<option value='5'> 5 </option>";	  
	  }
		
	echo"  </select>
	  <input type='submit' name = 'rate_media' value='Rate'/>
	 </form>";
	
	//	}
	 
?></td> </tr>
     <tr>
       <td bgcolor="#FFFFCC" align="left" width="50%"><font size="-1"> Add to Favourites: </font></td><td width="50%" bgcolor="#FFFFCC" valign="middle" align="left">
      
<?php if(isset($userid))
{
/*	$qfavmed= "select * from fav_media where mediaid=".$id.";";
	$qwresult = mysql_query($qfavmed) or die('error');
	$qwroww = mysql_fetch_array($qwresult);
	//echo $qwroww['mediaid']." ".$id;
	if($qwroww['mediaid']==$id)*/
	$qfavmed= "select * from fav_media where mediaid=".$id." and userid='".$userid."';";
	$qwres = mysql_query($qfavmed); 
	$qwrow = mysql_fetch_array($qwres);
	
	if(mysql_num_rows($qwres)!=0)
		{	
		
		echo "<font size='-1'><b>Added to favorites</b></font>";
	}
	else {
		echo " <form method='post'>
		<input type='submit' name = 'fav_submit' value='Add'/>	
				</form>";
}
}
?></td></tr>

<?php } else {
?>
<tr><td colspan="2"><font size="-1"><i>Login to Add to playlist,&nbsp;Rating & Favourites</i></font></td></tr>


<?php } ?>

<tr>
         <?php
    $vquery= "select * from media where mediaid=".$id;
    $vresult = mysql_query($vquery);
$row= mysql_fetch_array($vresult);
	$views= $row["count"];
    ?>
     
       <td align="right" width="50%" bgcolor="#CCCCCC"	><font size="-1"> Views: </font></td><td bgcolor="#CCCCCC" width="50%" align="center" valign="middle">  <?php echo $views;  ?></td>
    </tr>
<?php
if (isset($userid))
{
?>    
<tr><td bgcolor="#CCCCCC"><!--<font size='-1'>Download Media</font></td><td bgcolor="#CCCCCC"><form><input type="button" value="Download Media" onClick="window.location.href='<?php echo 'http://mmlab.cs.clemson.edu/spring12/g4';echo $path;echo $file_name;echo '.';echo $format; ?>'"></form></td></tr>-->
<tr><td colspan='2' align='center'bgcolor="#CCCCCC"><font size='-3'><a href="<?php echo $row[3].$row[1];?>">Right click and hit save  as to download</a></font></td></tr>
<?php
echo "<tr><td>"; 
	
   echo "<form name='mediarec' method='post'>";
   echo"<input type='hidden' name='reco' value='".$userid."' />";
    echo"<input type='hidden' name='mediaid' value='".$id."' />";
   
   echo "<input type='submit' name='mediarec' value='Recommend' onclick='Confirm()'/>
  </form>";
 echo "</td> </tr>";
?>


<?php }  ?>
</table>


    <h3>Comments</h3>
 <?php
$userid = $userid;

?>
<a href="comments_new.php?mid=<?php echo $_GET['id'] ?>"> click here to contribute to comments</a>
 
<?php



echo "</table>";
?>

    &nbsp;
    <br/>
    
   &nbsp;
    <br/>
  
    
   
   <!-- end #sidebar2 -->
</div>
  
<div id="mainContent">


<table width="400" height="537">
    <tr><td><?php echo "<h3>".$filename."</h3>";?>
</td>
<?php 
if($userid==$usuid)
{
?>	<td align="right" colspan="3">
<?php
echo "<form name='delete_media' method='post'><table align='right'><tr><td>";
echo "Delete Media</td><td><input type='submit' name='delete_media' value='Delete'/></td></tr></table>
  </form>";

?></td><?php
}
?>
</tr>
<tr>
    <td colspan="8" height="500">
	<?php if($type=='image')
	{
	echo "<img src='".$filepath.$filename."' />" ;
	//echo $filepath.$filename;
//	echo "<img src='".$filepath.$filename."'/>";

}else 
    {	
 
	?>
	<object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $filepath.$filename;  ?>">
<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

<embed type="application/x-mplayer2" src="<?php echo $filepath.$filename;  ?>" name="MediaPlayer" width=320 height=240></embed>

</object>

    </td>
</tr>
  </table>
 <?php } ?>
  <h2>Recommended Media Similar to this one</h2>
  <?php
		$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	$medianame = $result_row[1];
	$mediadesc = $result_row[6];
	$mediatype = $result_row[4];
	$mediacat = $result_row[5];	
				
			$srch= "select * from media where name like '%".$medianame."%' or description like '%".$mediadesc."%' or type='".$mediatype."' or category='".$mediacat."'";
			//echo $srch;
			$search_result = mysql_query($srch) or die('error'.mysql_error());
			
			//echo $sr['mediaid'];
			?>
			<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			while ($result_row = mysql_fetch_row($search_result))
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
            	<a href="<?php echo $result_row[3].$result_row[1];?>" onclick="Download()">Download</a>
            </td>
		</tr>
        <?php
			}
		?>
	</table>
    
<!--end of main content-->
</div> 

  <?php }  // end of priflag ?>

	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
 
<!-- end #container --></div>


</body>
</html>
