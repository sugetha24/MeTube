
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include "functions.php";

$username = $_SESSION['username'];
$query = "select * from account where name='$username'";
$result = mysql_query( $query );
$row = mysql_fetch_row($result);
$userid = $row[0];
$email = $row[3];
$own=0;
$mediaid = $_GET['mid'];
//echo "$mediaid";
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

<?php include('navindex.php'); ?>




<script type="text/javascript" language="javascript">

function confirm_box()
{
alert("Are you sure ?");
}

</script> 

<div id="content">
<?php
if(isset($_SESSION['username']))
{
    if($mediaid)
    {
    

        if(isset($_POST['submit']))
        {
           $contents=$_POST['contents']; 
           //$mediaid=$id;
           $accountid=$userid; 
           $dquery="INSERT INTO  comments_tutor (name ,email, message ,mediaid) VALUES('".$username."','".$email."','".$contents."','".$mediaid."');";
           $dresult = mysql_query($dquery) or die('Error: ' . mysql_error()); 
           //print "<meta http-equiv='refresh' content='0;url=comments_new.php'>";
           
        }
        

        
        if(isset($_POST['delete_disc']))
        {
        
            $qy7="delete from comments_tutor where id=".$_POST['comment'].";";
            $qqq="delete from comments_tutor where parent=".$_POST['comment'];
            $result7=mysql_query($qy7) or die(mysql_error());
            $resultqqq=mysql_query($qqq) or die(mysql_error());

        }
        
         
        $query  = "Select * from comments_tutor where mediaid=".$mediaid.";"; 
        $result = mysql_query($query);
       

?>
<table>
<tr><td width="5%" align="left">



</td>
 


</tr>
<tr>
     
 <?php
        
        ?>  

<table width="364" height="115">
<tr>
<form name="groups_discussions.php" method="post">
<td width="279">
<textarea name="contents" cols="80" rows="5" id="contents"> Enter your views here...</textarea>
</td><td align="center" width="122">
<input name="submit" type="submit" id="submit" value="discuss"/>
        
</td>
</form>
</tr>
</table>
<?php
            
            $bg=0;
            while($row=mysql_fetch_array($result))
            {
                echo "<table  width='100%' border='0'>";
                if($bg==0)
                {
                        $bg=$bg+30;
                        $bgcolor="#c4e5c1";
                }
                
                else
                {
                    $bg=0;
                    $bgcolor="#FFFFFF";
                }
                
                $cid = $row['id'];
                $email_owner = $row['email'];
                $parent = $row['parent'];
                $comment = $row['message'];
                $cown = $row['name'];
                $timestamp = $row['date'];
                if($parent !=0)
                {
                    $a = "SELECT message FROM comments_tutor WHERE id ='".$parent."'";
                    $a1 = mysql_query($a);
                    $r = mysql_fetch_array($a1);
                    $mess = $r['message'];
                    echo "<tr bgcolor=".$bgcolor."> <td width='50%'><font size='-1'>";
                    echo "reply for&nbsp <i>".$mess."</i>&nbsp is <br></br>";
                    echo $comment."</font></td> <td width='30%'> <font color="."#333333"." size='-3'><a href='user.php?username=".$cown."'>".$cown."</a></font></td>  <td width='20%'>  <i> <font color="."#333333"."size='-3'> posted at ".$timestamp."</font></i></td> <td width='20%'>  <i> <font color="."#333333"." size='-3'>";  
                    echo    "<form name='reply' method='post' action='reply.php?cid=".$cid."&mediaid=".$mediaid."'><table align='right'><tr><td><input type='hidden' name='rep' value='".$cid."'/></td><td><input type='submit' name='reply' value='Reply  ' onclick='confirm_box()'/></td></tr></table>
                      </form></font></i></td></tr>";
                      
                    if($username == $cown)
                    {
                    echo    "<form name='delete_disc' method='post'><table align='right'><tr><td><input type='hidden' name='comment' value='".$cid."'/></td><td><input type='submit' name='delete_disc' value='Delete' onclick='confirm_box()'/></td></tr></table>
                      </form></font></i></td></tr>";
                    }
               
                }
                else 
                {
                    echo "<tr bgcolor=".$bgcolor."><td width='50%'><font size='-1'>";
                    echo $comment."</font></td><td width='30%'> <font color="."#333333"." size='-3'><a href='user.php?username=".$cown."'>".$cown."</a></font></br></td><td width='20%'>  <i> <font color="."#333333"." size='-3'> posted at ".$timestamp."</font></i></td><td width='20%'>  <i> <font color="."#333333"." size='-3'>";  
                    echo    "<form name='reply' method='post' action='reply.php?cid=".$cid."&mediaid=".$mediaid."'><table align='right'><tr><td><input type='hidden' name='rep' value='".$cid."'/></td><td><input type='submit' name='reply' value='Reply  ' onclick='confirm_box()'/></td></tr></table>
                          </form></font></i></td></tr>";
                          
                    if($username == $cown)
                    {
                        echo    "<form name='delete_disc' method='post'><table align='right'><tr><td><input type='hidden' name='comment' value='".$cid."'/></td><td><input type='submit' name='delete_disc' value='Delete' onclick='confirm_box()'/></td></tr></table>
                        </form></font></i></td></tr>";
                    }
  
                }
                          
                
                echo "</table>";
            }
            
            
    }
    
     else 
    {
     
       print "<meta http-equiv='refresh' content='0;url=comments_new.php'>";
     
    }
 
    
}

else 
{
     
echo "<center><b><i><a href='index.php'>Login</a> or <a href='register.php'>Register</a> to Gain access to Groups! </i></b></center>";

}    
?>
 
</tr>
</table>
  
</div> <!-- end #content -->

<?php// include('sidebar.php'); ?>


<?//php include('footer.php'); ?>             
        
</td>
</form>
</tr>
</table>

<?php include('footer.php'); ?>             

</div> <!-- End #wrapper -->
</body>
</html>

