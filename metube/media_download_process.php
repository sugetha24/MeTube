<
<?php
//session_start();
include_once "functions.php";
include_once "browse.php";
//include "mysqlClass.inc.php";

/******************************************************
*
* download by username
*
*******************************************************/

$mediaid = $result_row[0];
//$mediaid=$_REQUEST['id'];
$username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result = mysql_query( $query )or die ("errrrrrrr". mysql_error());
		
	if (!$result)
	{
	   die ("errrrrrrr". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		$userid = $row[0];
	//	echo $userid;
	}
if(!isset($_SESSION['username']))			

{//insert into upload table
$insertDownload="insert into downloads(downloadid,userid,mediaid)". "values(NULL,'$userid','$mediaid')";
$queryresult = mysql_query($insertDownload) or die ("errrrrrrr". mysql_error());
}
else {
	{
		$insertDownload="insert into downloads(downloadid,userid,mediaid)". "values(NULL,'$userid','$mediaid')";
$queryresult = mysql_query($insertDownload) or die ("errrrrrrr". mysql_error());
		
	}
}
/*Actual filename = 'attachment.zip' (Unknown to the viewers). 
When downloaded to be saved as 'mydownload.zip'. 
*/ 
/*$filenamequery="select * from media where mediaid='".$mediaid."'";
$filenamequeryresult=mysql_query($filenamequery) or die("errrrr".mysql_error());
$filenamerow=mysql_fetch_row($filenamequeryresult); 
$filename=$filenamerow[1];
$path=$filenamerow[3];
echo $filename, $path;	
*/
?>


