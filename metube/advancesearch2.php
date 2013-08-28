
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<?php 
session_start();
include_once "functions.php";
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
 <div id="content">

 <p></p>
  <?php
static $tag_score;

	$search_req = $_GET['search_query'];
	echo $search_req;
		$cloudchk="select * from search where keyword='".$search_req."'";
		//echo $cloudchk;	
		$cloudres=mysql_query($cloudchk) or die(mysql_error());
		if(mysql_num_rows($cloudres)==0)
		{
		$cnt=1; 
		$cloudins= "INSERT into search (keyword,count) values ('".$search_req."',".$cnt.");";
		}
		else
		{
			$cloudins= "UPDATE search set count=count+1 where keyword='".$search_req."';";
			}
	//echo $cloudins;
	$cldres=mysql_query($cloudins) or die(mysql_error());
	
	if($search_req==' ')
	{
		echo "<font color=red><center><b>Please enter a valid search</b></center></font>";
		print "<meta http-equiv='refresh' content='5;url=advancesearch.php'>";
	}
	else
		{
	$search_tags = explode(' ',$search_req);
	$tag_count = count($search_tags);

	for($i=0;$i<$tag_count;$i++)
	{
		$srch= "select DISTINCT mediaid from mediatags,tags where mediatags.tags_id=tags.tags_id and tags.tags like '%$search_tags[$i]%' ";
		//echo $srch;
		$search_result = mysql_query($srch) or die(mysql_error());
		if(mysql_num_rows($search_result)!=0)
		{
		while($sr = mysql_fetch_array($search_result))
		{	
			$media_id_temp = $sr["mediaid"];
			$tag_score["$media_id_temp"] = $tag_score["$media_id_temp"] + 3 * $tag_count;
		}
		}
		else{
			
			$srch= "select DISTINCT mediaid from media where name like '%$search_tags[$i]%' ";
			//echo $srch;
			$search_result = mysql_query($srch) or die('error');
					while($sr = mysql_fetch_array($search_result))
					{	
					$media_id_temp = $sr["mediaid"];
				$tag_score["$media_id_temp"] = $tag_score["$media_id_temp"] + 3 * $tag_count;
				//	echo $media_id_temp;
					}	
		}
	}
	if(count($tag_score) == 0) 
	echo "<table width=\"45%\" height=\"75%\" align = \"center\"><tr><td><strong><br/>No files found.</strong></td></tr></table>";
	else{
		
		$cat=$_GET['category'];
		$type=$_GET['type'];
		//echo $type;
		
		if($type==1)
		{
		$x='audio';	}
		if($type==2)
		{
		$x='image';	}
		if($type==3)
		{
		$x='video';	}
		//$size=$_POST['size'];
		arsort($tag_score);
		
		echo "<table width=\"90%\"  align = \"center\"><tr><td align='center'><strong>Search results</strong></td></tr>";
		foreach($tag_score as $key => $value)
		{	   
	
		
			$abc = "SELECT * FROM media WHERE mediaid ='".$key."' ";
  			
			if($cat !='All')
			{
				$abc.= "AND category='".$cat."'" ;
			}
			if($type!=0)
			{
				$abc.= "AND type='".$x."'";
			}
			//echo $abc;
			$disp_sr = mysql_query($abc);
			$sr2 = mysql_fetch_array($disp_sr);
			$res1 = mysql_num_rows($disp_sr);
			$id=$sr2['mediaid'];
			$name = 	$sr2['name'];
			//$fname= $sr2['filename'];
			$type  = 	$sr2['type'];
			$media_category = $sr2['category'];
			$path = $sr2['path'];
			$format=$sr2['format'];
			$media_descrip = $sr2['description'];
			//$uploaded_by = $sr2['accountid'];

			$uploaded_by=$sr2[2];
$ue = "select * from account where userid='$uploaded_by'";
        $ult = mysql_query( $ue );
        $ow = mysql_fetch_row($ult);
        $username = $ow[1];


				$vquery= "select count from media where mediaid='".$id."'";
				//echo $vquery;
    $vresult = mysql_query($vquery);
$row= mysql_fetch_array($vresult);
	$media_views= $row["count"];
			$sql = "SELECT * FROM account WHERE userid = '".$uploaded_by."';";
			//echo $sql;
			$result = mysql_query($sql);
			$res =  mysql_fetch_array($result);
			$upname = $res['name'];
			if(!isset($result))
				die("Could not Retrieve account details");
			if(!mysql_num_rows($result)==0)
			{
			
			
			echo "<tr><td align='center'>";
			echo "<table align='center'><tr>";
		if($type=="audio"){
	echo "<a href='media.php?media_id=".$id."'><font size='-2'>'".$name."'</font></a>";

	}
	else if($type=="video"){
		echo "<a href='media.php?id=".$id."'>'".$name."'</a>";
		}
	else 
	{
?><a href='media.php?id=<?php echo $id?>'><font size='-1'><b><?php echo $name ; ?></b></font></a>
	<?php } ?>
			</tr>
			<tr><td align='center'>
			<table cellpadding='0' cellspacing='0'><tbody>
			<tr><td align='center'><label><font size='-1'>Views:&nbsp;<?php echo $media_views ?></font></label></td></tr>
			<tr><td align='center'><label><b><font size='-1'>uploaded by<?php echo $upname ?></font></b></label></td></tr>
			</table>
			</td></tr>
			</tbody></table>
			</td></tr>
			
	<?php	}
		//else
//		{
	//		echo "<tr><td>No results found</td></tr>";
		//	break
		//}
		
	echo "</table>";
	}
		}
		}

?>
 <a href='advancesearch.php'>Go back</a>
 
  
 </div>
<?php include('footer.php'); ?>             

  </div>
    
</body>
</html>



