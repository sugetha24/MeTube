
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<title>MeTube-Group 6-Register</title>
</head>
	
<body>
<div id="wrapper">



<?php include('header_sanslogin.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">

<?php 
include ('functions.php');

//ini_set('SMTP',"g.clemson.edu");

define('EMAIL','sarunac@g.clemson.edu');
	DEFINE('WEBSITE_URL','http://localhost/php_site');

 if (isset($_POST['submit'])) { 
$error =array(); //declare an array to store any error message

 //This makes sure they did not leave any fields blank
 if (!$_POST['username'] | !$_POST['password'] | !$_POST['password2'] | !$_POST['email'] ) {
 		$error[]='You did not complete all of the required fields';
 	}
 // checks if the username is in use
 	if (!get_magic_quotes_gpc()) {
 		$_POST['username'] = addslashes($_POST['username']);
 	}
 $usercheck = $_POST['username'];
 $check = mysql_query("SELECT name FROM account WHERE name = '".$usercheck."'") or die(mysql_error());
 $check2 = mysql_num_rows($check);
 //if the name exists it gives an error
 if ($check2 != 0) {
 		$error[]='Sorry, the username '.$_POST['username'].' is already in use.';
		}
 if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST['email'])) {
//regular expression for email validation
  $Email = $_POST['email'];
 } 
else {
            $error[] = 'Your EMail Address is invalid  ';

        }
 

// this makes sure both passwords entered match
 	if ($_POST['password'] != $_POST['password2']) {
 		$error[]='Your passwords did not match. ';
 	}
 // here we encrypt the password and add slashes if needed
 	$_POST['password'] = $_POST['password'];
 	if (!get_magic_quotes_gpc()) {
 		$_POST['password'] = addslashes($_POST['password']);
 		$_POST['username'] = addslashes($_POST['username']);
 			}
 // now we insert it into the database
if(empty($error))
{
$query_verify_email = "SELECT * FROM account where email='$Email'";
$result_verify_email = mysql_query($query_verify_email);
if(!$result_verify_email)
{
//if query failed, similar to if($result_verify_email==false)
echo 'Database Error Occured';
}

if(mysql_num_rows($result_verify_email) == 0)
{
//if no previous user is using this email
//create a unique activation code:
//$activation = md5(uniqid(rand(),true));

 	$insert = "INSERT INTO account (name, password,email)VALUES ('".$_POST['username']."', '".$_POST['password']."','".$_POST['email']."')";
 	$add_member = mysql_query($insert);
if($add_member)
{

echo '<div class="success"> Thank you for registering!' ?> <p>you may now <a href=index.php> login</a>.</p></div> <?php 


}

}
}
else
{
//if the error array contains error msg, display them
echo ' <div class = "errormsgbox"> <ol>';
foreach($error as $key => $values)
{
echo ' <li>' .$values. '</li>';
}
echo '</ol></div>';
?>


<a href = "register.php" > register again</a>

<?php 
}

 } 
 else 
 {	
 ?>
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
 <tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table>
 </form>

 <?php
 }
 ?> 
	


</div> <!-- end #content -->


<?php// include('includes/sidebar.php'); ?>


<?php include('footer.php'); ?> 			
</div>
</div> <!-- End #wrapper -->

	

</body>



</html>

