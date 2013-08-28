<table width="100%" align="center">

               <?php
               session_start();
include_once "functions.php";
            $userid = $_GET['sub_id'];
			
			
       
echo "<table>
<tr><td align='left'> <h4><i><font >".$_GET['sub_id']." Subcribe </font></i></h4></td></tr>
  <tr><td><table><tr>";
  $username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result = mysql_query( $query );
	$row = mysql_fetch_row($result);
	$userid = $row[0];

$query= "select * from media where userid='".$_GET['sub_id']."' and visibility='1';";
 $result = mysql_query($query);
 $count=0;
$total = mysql_num_rows($result);
if($total!=0){
while($mrow= mysql_fetch_array($result))
{$id=$mrow['mediaid'];
	  $subquery="Insert into account_channel(`userid`,`subid`,`mediaid`) Values('".$_GET['sub_id']."' ,'".$userid."','".$id."')";
	  $subresult=mysql_query($subquery) or die(mysql_error());
	$count=$count+1;

$acid =$mrow['userid'];
//$name=$mrow['filename'];
$nme=$mrow['name'];
$type=$mrow['type'];
$utime=$mrow['uploadtime'];
       $format=$mrow['format'];
       $path=$mrow['path'];
	   if($count>5)
	   {
		$count=0;   
		echo "</tr><tr>";   
	   }
       if($type=='audio'){
       print "<td><table><tr><td><a href='media.php?id=".$id."'>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i> uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>"; }
else if($type=="video"){
       print "<td><table><tr><td><a href='media.php?id=".$id."'></a></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>";        }
       else
       {
               print "<td><table><tr><td><a href='media.php?id=".$id."'></td></tr>";
       echo "</table></td><td valign='top'><font size='-2'><a
href='media.php?id=".$id."'><br/><br/>$nme</a><br/><br/><br/><i>
uploaded by ".$acid."<br/> on ".$utime."</font></i> </td>";}

}

    }else{
		echo "<h2 align='center'>No Media!</h2>";
		}
 echo "</tr></table></table> ";
echo "Media subscribed".$total;
?>
</table>
