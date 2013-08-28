<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include "functions.php";
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

<div id="content">

<?php 
if(isset($_SESSION['username']))
{
$q = mysql_query('SELECT * FROM account WHERE name="'.$_SESSION['username'].'"') or die(mysql_error()); 
while($row = mysql_fetch_array($q))
{
    $userid = $row['userid'];
    $name = $row['name'];
    $email = $row['email'];
    $dob = $row['dob'];
}

echo "<table border = 0 cellpadding = 10>";
//echo "<tr><td>".$userid."</td><td>".$userid."</td></tr>"; 
echo "<tr><td>name</td><td>".$name."</td></tr>";  
echo "<tr><td>email</td><td>".$email."</td></tr>"; 
//echo "<tr><td>dob</td><td>".$dob."</td></tr>"; 
echo "</table>"; 

?>

<h1>update profile information</h1>
<form action="update_profile.php" method="post">
 <table border="0">
 <tr><td>Username:</td><td>
 <input type="text" name="username" maxlength="60">
 </td></tr>
 <tr><td>Email:</td><td>
  <input type="text" name="email" maxlength="60">
 </td></tr>
 <tr><td>Password:</td><td>
 <input type="password" name="password" maxlength="10">
 </td></tr>
 <tr><td>Confirm Password:</td><td>
 <input type="password" name="password2" maxlength="10">
 </td></tr>


 <tr><th colspan=2><input type="submit" name="submit" value="Update"></th></tr></table>
 </form>
<?php }
else
{
    echo "<h1>login to gain access</h1>";
} ?>
</div> <!-- end #content -->


<?php //include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
</body>
</html>
