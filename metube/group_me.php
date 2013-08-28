<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include("functions.php");
$username = $_SESSION['username'];
$query = "select * from account where name='$username'";
$result = mysql_query( $query );
$row = mysql_fetch_row($result);
$userid = $row[0];

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

<?php include('navindex.php'); ?>

<?php include('nav.php'); ?>
<?php

if(isset($_POST['make_group']))
{
    $gname= $_POST['gname'];
    $gcategory= $_POST['gcategory'];
    if($gname==NULL)
    {
        $nog=1;
        $error = TRUE;
    }
        
    else
    {
    
    $qwer= "INSERT INTO groups(group_name,category,userid) VALUES ('".$gname."','".$gcategory."','".$userid."')";
    $result = mysql_query($qwer) or die(mysql_error());
    $aw1 ="SELECT group_id FROM groups where userid='".$userid."' AND group_name='".$gname."'";
    $aw1res= mysql_query($aw1);
    $aw1row= mysql_fetch_array($aw1res);
    $aw1id=$aw1row['group_id'];
    
    $qwer2= "INSERT INTO acc_group(group_id,userid) VALUES (".$aw1id.",'".$userid."')";

    $result2 = mysql_query($qwer2) or die(mysql_error());
    }
}
?>          

<td width="50%">
<form name="groups_create" method="post" action="group_me.php">
<table width="99%" height="6%"  bgcolor="#FFFFFF"> <tr valign="top">
 
<td colspan="3"><h5>Create Groups</h5></td></tr>
<tr><td>
   
<input align="absmiddle" type="text" maxlength="25" name="gname" />

<?php 
/*if($nog==1)
{
    echo "<br /><font color=red>Please enter a valid Group</font>";
}
*/
?>

</td>
<td><select name="gcategory"> 
                    <option value="General" selected>General</option> 
                    <option value="Comedy">Comedy</option> 
                    <option value="Education">Education</option> 
                    <option value="Entertainment">Entertainment</option> 
                    <option value="Gaming">Gaming</option> 
                    <option value="Music">Music</option> 
                    <option value="Technology">Technology</option> 
                    <option value="Sports">Sports</option> 
            </select></td><td><input type="submit" name="make_group" value="create group"/></td></tr>
</table>
</form>
</td>


<?php include('footer.php'); ?> 

</div> <!-- End #wrapper -->
</body>
</html>


