<?php


include_once "functions.php";

if(isset($_POST['submit'])) {
//session_start();
$error = array();
	if(isset($_POST['password'])){
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); 
// Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}
}

 
?>

 <form action="<?php echo "index.php"; ?>" method="post"> 
 <table border="0"> 
 <tr><td colspan=2></td></tr> 
 <tr><td>Username:</td><td> 
 <input class = "text" type="text" name="username" maxlength="40"> 
 </td></tr> 
 <tr><td>Password:</td><td> 
 <input class = "text" type="password" name="password" maxlength="50"> 
 </td></tr> 
  <tr> 
  <td>&nbsp;</td> 
  <td align="center"><a  href="mailto:sarunac@clemson.edu" >Forgot Password? </a></td> 
  </tr>
 <tr><td colspan="2" align="right"> 
 <input type="submit" name="submit" value="Login">
 <input type="button" value="register" onClick="window.location.href='register.php'"> 
 </td></tr> 
 </table> 
 </form> 
 
 <?php 
 if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
 ?>
 <!-- end #login -->