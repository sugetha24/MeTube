<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
session_start();
include_once "functions.php";
    $username = $_SESSION['username'];
    $query = "select * from account where name='$username'";
    $result = mysql_query( $query );
    $row = mysql_fetch_row($result);
    $userid = $row[0];
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

</head>

<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <?php include('nav.php'); ?>

    <?php include('navindex.php'); ?>
    
    <div id="content">

<script type="text/javascript">
<!--
function MM_validateForm() { 
      if (document.getElementById){
      var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
      for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
      if (p<1 || p==(val.length-1)) errors+='- '+nm+' should have an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
      if (isNaN(val)) errors+='- '+nm+' must have a number.\n';
      if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
      min=test.substring(8,p); max=test.substring(p+1);
      if (num<min || max<num) errors+='- '+nm+' must have a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is compulsory.\n'; }
      } if (errors) alert('The following error(s) occurred:\n'+errors);
      document.MM_returnValue = (errors == '');
} }
//-->
</script>
</head>
<?php
if(isset($_SESSION['username']))
{
if(isset($_POST['uploadmedia']))
{
  $userid = $_SESSION['userid'];
  $mediadesc = $_POST['mediadesc'];
  $access = $_POST['access'];
  $mediacat = $_POST['category'];
  $title = $_POST['medianame'];
  $type = $_POST['type'];
  $tags = $_POST['mediatags'];
 $allowed_filetypes = array('.jpg','.JPG','.MPG','.gif','.bmp','.png','.avi','.mov','.wmv','.mp3','.mp4','.mpeg','.jpeg'); 
  $max_filesize=10485760;
  if($access==1)
  {
	$access=1;
	}else
	{
	$access=0;	
	}
 if($type==2)
  {
  $upload_path = "/var/www/spring13/g6/metube/uploads/";
  $upload_location="uploads/";
$type='image';
}elseif($type==3)
  {
    $upload_path = "/var/www/spring13/g6/metube/uploads/";
    $upload_location="uploads/";
  $type='video';
  }elseif($type==1)
  {
    $upload_path= "/var/www/spring13/g6/metube/uploads/";
	  $upload_location="uploads/";
  $type='audio';
  }
   if($type == NULL)
  {
  	$errmsg ="PLEASE ENTER THE TYPE";
  }
  $upload_file= $upload_path.basename( $_FILES['mediafile']['name']) ; 
  
  $filename=$_FILES['mediafile']['name'];
 $ext=substr($filename, strpos($filename,'.')+1, strlen($filename)-1); 						  
$fname=substr($filename,0,strpos($filename,'.'));

 $ok=1; 
  if ($uploaded_size > $max_filesize) 
 { 
 echo "Too large!<br>"; 
 $ok=0; 
 } 
  if ($ok==0) 
 { 
 echo "Could not upload!"; 
 } 
 else {
	 if(!is_writable($upload_path))
	{
        
	echo "<br/>cannot write to location<br/>";
	}
if(move_uploaded_file($_FILES['mediafile']['tmp_name'], $upload_file)) 
 {
	     $username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result1 = mysql_query( $query );
		
	if (!$result1)
	{
	   die ("errrrrrrr". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result1);
		$userid = $row[0];
	}
				$insquery="insert into media(name,userid,path,type,category,description,format,visibility)"."values('".$_FILES["mediafile"]["name"]."','$userid','$upload_location','$type','".$mediacat."','".$mediadesc."','".$_FILES["mediafile"]["type"]."','".$access."')";
					$result = mysql_query($insquery) or die("Failed to insert".mysql_error());
				$id = mysql_insert_id();
			if(!isset($id))
				{
				die("Insert Failed");
				}
$tagid = mysql_insert_id();	
echo $tagid;	
$words = preg_split('/[,\s]+/', $tags, -1, PREG_SPLIT_NO_EMPTY);
foreach($words as &$val)
{
$sql= "INSERT INTO tag_count (tags) VALUES ('".$val."');";
    $result = mysql_query($sql) or die(mysql_error());
    //echo $val;
}
$sql= "INSERT INTO tags (tags_id,tags) VALUES ('".$tagid."','".$tags."');";
	
		$result = mysql_query($sql) or die(mysql_error());
		//$tagid = mysql_insert_id();
		if(!isset($tagid))
			die("Tag Insert Failed");
				$mediaquery="Select * from media where path='".$upload_location."' and name='". $_FILES["mediafile"]["name"]."'";
		$mediaquery1=mysql_query($mediaquery) or die(mysql_error());
		$mediarow=mysql_fetch_row($mediaquery1);
		$mediaid=$mediarow[0];	
		//echo $mediaid;	
		
		$sql = "insert into mediatags(tags_id,mediaid) values('".$tagid."','".$mediaid."')";
		$result = mysql_query($sql) or die(mysql_error());
		$msg = 1;
	}
	else
     	{
			echo 'Error occured. Please try again.';  
		}
 
 }
}
?>

<center><b>Upload the Media!
</b></center>
<br />
<p>
<?php 
if(isset($msg))
{
	echo "<h3 align='center'>Success!</h3>";
}
?>
</p>
<?
if(isset($errmsg))
{
	echo "<h2>".$errmsg."</h2>";
}



?>
<form method="post" action="media_upload1.php" enctype="multipart/form-data" onsubmit="MM_validateForm('medianame','','R','mediatags','','R','mediadesc','','R');return document.MM_returnValue">
<table border="3" bordercolor="" cellpadding="0" cellspacing="6" style="" width="60%" align="center" >
	<tbody>
    
        <tr>
       	  <td id="td"><label>Media Name:</label>
          </td>
        </tr>
        <tr>
            <td id="td"><input name="medianame" type="text" id="medianame" size="60" />
            </td>
        </tr>
        <tr>
        	<td id="td"><label>Media Description:</label>
            </td>
		</tr>
        <tr>            
            <td id="td"><textarea name="mediadesc" rows="4" id="mediadesc"></textarea>
            </td>
        </tr>
                <tr>
        	<td id="td"><label>Tags:</label>
            </td>
		</tr>
        <tr>            
            <td id="td"><input name="mediatags" type="text" id="mediatags" size="40" />
            </td>
        </tr>
        <tr>
        	<td id="td"><label>Category:</label>
            </td>
        </tr>
        <tr>
            <td id="td">
            <select name="category"> 
					 <option value="Nature">Nature</option> 
<option value="Sports" >Sports </option> 
<option value="Music" >Music</option> 
<option value="Education" >Education</option>
 <option value="Animals" >Animals</option>
<option value="Arts" >Arts</option> 
<option value="Fashion" >Fashion</option> 
<option value="People" >People</option> 
<option value="News" >News</option>
<option value="Science and tech" >Science and Technology</option> 
<option value="Travel" >Travel</option> 
<option value="Fitness" >Fitness</option> 
<option value="Entertainment" >Entertainment</option>
<option value="Other" >Other</option>
			</select>
            </td>
        </tr>
        <tr>
        	<td id="td"><label>Media Type:</label>
            </td>
        </tr>
        <tr>
            <td id="td">
            <select name="type"> 
					<option value="" selected>Please Select type:</option> 
                    <option value="1">Audio</option> 
                    <option value="2">Picture</option> 
                    <option value="3">Video</option> 
			</select>
            </td>
        </tr>
         <tr>
        	<td id="td"><label>Media Access:</label>
            </td>
        </tr>
        <tr>
            <td id="td">
            <select name="access"> 
					<option value="" selected>Access Control:</option> 
                    <option value="1">Public</option> 
                    <option value="2">Private</option> 
			</select>
            </td>
        </tr>
    	<tr>
        	<td id="td" valign="top">Add a Media:
            </td>
        </tr>
        <tr>
		    <td id="td">
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
                <input  name="mediafile" type="file" size="50" />
			</td>
		</tr>
        <tr>
        	<td id="td" align="center">
	        <input value="Upload" name="uploadmedia" type="submit" />
            </td>
        </tr>
	</tbody>
</table>
</form>
<?php
}
else {
	
}


?>


</div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
