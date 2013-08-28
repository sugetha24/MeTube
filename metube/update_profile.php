<?php
session_start();
include_once "functions.php";


$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$password2=$_POST['password2'];
$error =array(); //declare an array to store any error message

 //This makes sure they did not leave any fields blank
 if (!$username | !$password | !$password2 | !$email ) 
 {
        $error[]='You did not complete all of the required fields';
    }
 // checks if the username is in use
    if (!get_magic_quotes_gpc()) 
    {
        $_POST['username'] = addslashes($_POST['username']);
    }
 $usercheck = $_POST['username'];
 $check = mysql_query("SELECT name FROM account WHERE name = '".$usercheck."'") or die(mysql_error());
 $check2 = mysql_num_rows($check); 
 if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST['email'])) 
 {
//regular expression for email validation
  $Email = $_POST['email'];
 } 
else {
            $error[] = 'Your EMail Address is invalid  ';

        }
 

// this makes sure both passwords entered match
    if ($_POST['password'] != $_POST['password2']) 
    {
        $error[]='Your passwords did not match. ';
    }
 // here we encrypt the password and add slashes if needed
    $_POST['password'] = $_POST['password'];
    if (!get_magic_quotes_gpc()) 
    {
        $_POST['password'] = addslashes($_POST['password']);
        $_POST['username'] = addslashes($_POST['username']);
            }
	$query = "select * from account where name='$username'";
	$result1 = mysql_query( $query )  or die(mysql_error());
	$row = mysql_fetch_row($result1);
		$userid = $row[0];
 // now we insert it into the database
if(empty($error))
{

$insert = "UPDATE account SET name='".$username."', password = '".$password."',email = '".$email."' WHERE name = '".$_SESSION['username']."'";
$add_member = mysql_query($insert) or die(mysql_error());
if($add_member)
{

echo '<div class="success"> Thank you for updating! </div>';


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
}

?>
<?php

echo "<table border = 0 cellpadding = 10>";
//echo "<tr><td>".$userid."</td><td>".$userid."</td></tr>"; 
echo "<tr><td>name</td><td>".$username."</td></tr>";  
echo "<tr><td>email</td><td>".$email."</td></tr>"; 
//echo "<tr><td>dob</td><td>".$dob."</td></tr>"; 
echo "</table>"; 
?>
<p> <a href=userhome.php> Back</a>.</p>

