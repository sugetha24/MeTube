<?php
/*if(isset($_GET['accountid']))
{
    $accountid=$_GET['accountid'];
//echo "MEDIA ID IS".$id."<br/>";
}
else
{
        print "<meta http-equiv='refresh' content='0;url=index.php'>";

}*/
session_start();
include "functions.php";

$username = $_SESSION['username'];
$query = "select * from account where name='$username'";
$result = mysql_query( $query );
$row = mysql_fetch_row($result);
$userid = $row[0];
$own=0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

<title>Untitled Document</title>
</head>

<body>
    <div id="wrapper">

        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>

        <?php include('navindex.php'); ?>

        <?//php include('footer.php'); ?> 


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
    if(intval($_GET['id']))
    {
    

       $query  = "Select * from account where userid=(select userid from groups where group_id=".$_GET['id'].");";
       $result = mysql_query($query);
       $row= mysql_fetch_array($result);
       $user= $row['name'];
       //$logo_path=$row["logo_path"];
       $email=$row['email'];
       $dob=$row['dob'];
       $q1= "select * from groups where group_id=".$_GET['id'].";"; 
       $r1 = mysql_query($q1);
       $row1= mysql_fetch_array($r1);
       $gowner=$row1['userid'];
       $gname=$row1['group_name'];
       $cat = $row1['category'];

        

        if(isset($_POST['submit']))
        {
           $contents=$_POST['contents']; 
           //$mediaid=$id;
           $accountid=$userid; 
           $dquery="INSERT INTO  discussion_forums (discussionid ,userid ,group_id ,discussion_message ,dtime) VALUES(NULL,'".$accountid."','".$_GET['id']."','".$contents."',CURRENT_TIMESTAMP);";
           $dresult = mysql_query($dquery) or die('Error: ' . mysql_error()); 
           
        }

        if(isset($_POST['join_group']))
        {
            $qy= "insert into acc_group(userid,group_id) values('".$userid."',".$_GET['id'].")";
            $result=mysql_query($qy) or die(mysql_error());

        }
        if(isset($_POST['leave_group']))
        {
           if($gowner==$userid)
           {
                  echo "<b>you cannot do that</b>";
           }
           else
           {
                $qy4= "delete from acc_group where group_id=".$_GET['id'].";";
                $result4=mysql_query($qy4) or die(mysql_error());
           }
        }

        if(isset($_POST['delete_disc']))
        {
        
            $qy7="delete from discussion_forums where discussionid=".$_POST['comment'].";";
            $result7=mysql_query($qy7) or die(mysql_error());

        }

        if(isset($_POST['delete_group']))
        {
        
            $qy1="delete from groups where group_id=".$_GET['id'].";";

            $result=mysql_query($qy1) or die(mysql_error());

            $qy= "delete from acc_group where group_id=".$_GET['id'].";";

            $result=mysql_query($qy) or die(mysql_error());
            print "<meta http-equiv='refresh' content='0;url=groups.php'>";

        }
       /*if($logo_path == NULL)
       {
            $logo_path='defaultlogo.jpg';
       }*/
       
?>
<table>
<tr><td width="5%" align="left">

<?php
    print "<a href= 'groups_discussions.php?id=".$_GET['id']."'></a>";
    echo"</td><td width='70%' align='left' valign='center'><b>".$gname." discussion page</b>";
?>


</td>
 
<?php
    print "<td width='10%' align='right'><a>".$gowner."'</a></td>";
?>
<?php
    print "<td align='left' width='15%' ><a >".$gowner."'<font color="."#333333"." size='-1'>".$user."</font></a></td>"; 
?>


</tr>
<tr>
     
 <?php
 
        $not_member=1;
        $q2="SELECT ag.group_id FROM acc_group as ag,account as a 
                WHERE ag.userid=a.userid AND a.userid='".$userid."';";
        $r2 = mysql_query($q2);
        while($rw2= mysql_fetch_array($r2))
        {
            $gpid=$rw2['group_id']; 
            if($gpid==$_GET['id'])
            {
               echo "<td align='left' colspan='2'><i>Welcome <b>".$username."</b></i></td>";
               $not_member=0;
               break;
            }
            
            else
            {
              $not_member=1;
            }
        }
        if($not_member==1)
        {
            echo "<form name='join_group' method='post'><table align='right'><tr><td>";
            echo "Join group</td><td><input type='submit' name='join_group' value='Join'/></td></tr></table>
                </form><br/><br/>";
        }
        
        if($gowner==$userid)
        {
           echo "<form name='delete_group' method='post'><table align='right'><tr><td>";
           echo "Delete group</td><td><input type='submit' name='delete_group' value='Delete' onclick='confirm_box()'/></td></tr></table>
                </form><br/>";
           $not_member=0;
           $own=1;
        }
        if($not_member==0)
        {
           if($own!=1)
           {
              echo "<form name='leave_group' method='post'><table align='right'><tr><td>";
              echo "leave group</td><td><input type='submit' name='leave_group' value='leave' onclick='confirm_box()'/></td></tr></table>
                   </form><br/>";
           }
           echo "<b>Discussions</b>";
            
           //$userid = $_SESSION['userid'];
           $query = "SELECT * from discussion_forums where group_id='".$_GET['id']."' ORDER BY dtime DESC";
           $result = mysql_query($query) or die(mysql_error());
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
            echo "<table  width='100%' border='0'>";
            $bg=0;
            while($row=mysql_fetch_array($result))
            {
                if($bg==0)
                {
                        $bg++;
                        $bgcolor="#999999";
                }
                
                else
                {
                    $bg=0;
                    $bgcolor="#FFFFFF";
                }
                
                $comment=$row['discussion_message'];
                $comment_id=$row['discussionid'];
                $account_userid=$row['userid'];
                $timestamp=$row['dtime'];
                $qq = "SELECT name FROM account WHERE userid ='".$account_userid."'";
                $qresult = mysql_query($qq) or die(mysql_error());
                $row=mysql_fetch_array($qresult);
                $use=$row[0];
                echo "<tr bgcolor=".$bgcolor."><td width='50%'><font size='-1'>";
                echo $comment."</font></td><td width='30%'> <font color="."#333333"." size='-3'><a href='user.php?username=".$use."'>".$use."</a></font></br></td><td width='20%'>  <i> <font color="."#333333"." size='-3'> posted at ".$timestamp."</font></i></td><td width='20%'>  <i> <font color="."#333333"." size='-3'>";  
        
                if($userid == $account_userid)
                {
                    echo    "<form name='delete_disc' method='post'><table align='right'><tr><td><input type='hidden' name='comment' value='".$comment_id."'/></td><td><input type='submit' name='delete_disc' value='Delete' onclick='confirm_box()'/></td></tr></table>
                      </form></font></i></td></tr>";
                }
        
                else
                {
                   echo "</font></i></td></tr>";
                }  
            }
        
            echo "</table>";
        }
 
    }
 
    else 
    {
     
       //print "<meta http-equiv='refresh' content='0;url=index.php'>";
     
    }
}

else 
{
     
echo "<center><b><i>Register to Gain access to Groups! </i></b></center>";

}    
?>
 
</tr>
</table>
  
</div> <!-- end #content -->

<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?>             

</div> <!-- End #wrapper -->
    
</body>
</html>
