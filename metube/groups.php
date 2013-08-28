<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
include("functions.php")
//if(isset($_GET['userid']))
//{
//$userid=$_GET['userid'];
//echo "MEDIA ID IS".$id."<br/>";
//echo "USERID IS ".$userid." <br/>";

//}
//else{
//}



?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Groups</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>

<body>
    <div id="wrapper">

<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">
  
<a href='group_me.php'>CREATE NEW GROUP</a>
   
<h4>Groups Categories</h4>
<?php
    $cat_query="SELECT DISTINCT category from groups ORDER BY category ASC";  //i changed Groups to groups
	$cat_result = mysql_query($cat_query);
	echo "<table>";
    while($crow= mysql_fetch_array($cat_result))
    {
	   $channel_category=$crow['category'];
	   echo "<tr>
	       <td><a href='groups.php?channel_category=".$channel_category."'>".$channel_category."</td></tr>";
    }
    
    echo "</table>";
	
?>


<h3 align="left">Groups</h3>
<table>
 
<?php
    if(!isset($_GET['channel_category']))
    {
        $query= "select * from groups;";		
    }
    
    else
    {
	 
	 $query= "select * from groups where category= '".$_GET['channel_category']."';	";		

	}
	
$result = mysql_query($query);
$count=0;

while($row= mysql_fetch_array($result))
{
	if($count==0)
	{
		echo "      <tr>";
    }
	$count=$count+1;

//echo "<br/> success";
$gid=$row["group_id"];
$name=$row["group_name"];
$category=$row["category"];
//$logo_path=$row["logo_path"];
//$path=$row["path"];
 	
    echo "<td width='10%'><a href='groups_discussions.php?id=".$gid."'></a></td>";
    echo "<td align='left'><a href='groups_discussions.php?id=".$gid."'><font color="."#333333"." size='-1'>".$name."</font></a></td>";
    if($count==5)
    {
        echo "</tr>";
        $count=0;
    }
} 

?>   
</table>
<br/>
 
 
 
<?php// include('sidebar.php'); ?>

</div>

<?php include('footer.php'); ?>             

</div> <!-- End #wrapper -->    
</body>
</html>

