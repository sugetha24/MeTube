<?php
session_start();
include "mysqlClass.inc.php"
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
<script type="text/javascript">
<!--
function uploadmediavalid() { 
      if (document.getElementById){
      var i,p,q,nm,test,num,min,max,errors='',args=uploadmediavalid.arguments;
      for (i=0; i<(args.length-2); i+=3) 
      { test=args[i+2]; 
      	val=document.getElementById(args[i]);
      if (val) 
      { 
      	nm=val.name; 
      	if ((val=val.value)!="") 
      	{
      	if (test.indexOf('isEmail')!=-1) 
      	{ 
      		p=val.indexOf('@');
      		if (p<1 || p==(val.length-1)) 
      		errors+='- '+nm+' should have an e-mail address.\n';
        } 
        else if (test!='R') 
        { 
        	num = parseFloat(val);
        	if (isNaN(val)) errors+='- '+nm+' must have a number.\n';
      		if (test.indexOf('inRange') != -1) 
      		{ 
      			p=test.indexOf(':');
      			min=test.substring(8,p); 
      			max=test.substring(p+1);
      			if (num<min || max<num) errors+='- '+nm+' must have a number between '+min+' and '+max+'.\n';
      		} 
      	} 
      	} 
      	else if (test.charAt(0) == 'R') 
      	errors += '- '+nm+' is compulsory.\n'; 
      }
      } if (errors) alert('The following error(s) occurred:\n'+errors);
      document.MM_returnValue = (errors == '');
} 
}
//-->
</script>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>


<body>
	
<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">

	
	<p>Welcome <?php echo $_SESSION['username'];?></p>

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
	echo $errmsg;
}



?>
<table>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" onsubmit="uploadmediavalid('mname','','R','tags','','R','desc','','R');return document.MM_returnValue" >
  
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
<tr><td><label>Name : </label></td><td><input type="text" name="mname"/></td></tr>
<tr><td><label>Type : </label></td><td><input type="radio" name="type" value="Video">Video<input type="radio" name="type" value="Audio">Audio<input type="radio" name="type" value="Image">Image</td></tr>
<tr><td><label>Description : </label></td><td><input type="text" rows = "4" name="desc"/></td></tr>
<tr><td><label>Category : </label></td>
	<td><select name="category"/> 
<option value="Nature">Nature </option>
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
</td></tr>
<tr><td><label> Tags : </label></td><td><input type="text" name="tags"/></td></tr>
<tr><td><label>Visibility : </label><input type="radio" name="visibility" value="Public">Public<input type="radio" name="visibility" value="Private">Private
<tr><td>   <input  name="file" type="file" size="50" /></td><td><input value="Upload" name="submit" type="submit" /></td></tr>

 
                
 </form>
</table>
</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>
