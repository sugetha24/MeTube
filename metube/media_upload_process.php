<?php
session_start();
include_once "functions.php";

/******************************************************
*
* upload document from user
*
*******************************************************/
static $upload_path;
static $result;
$username=$_SESSION['username'];
//$useridquery= mysql_query('Select * from account where name="'.$username.'"') or die(mysql_error());
//$userid = mysql_fetch_array($useridquery) or die(mysql_error());

//Create Directory if doesn't exist
//if(!file_exists("uploads/"))
//	mkdir("uploads/", 0777);

//$dirfile = 'uploads/';
//if(!file_exists($dirfile))
//	mkdir($dirfile, 0777);
$location="uploads/";
$dirfile=$location.basename($_FILES['media']['name']);

 $title = $_POST['mname'];
  
 // $Name = $_POST['mname'];
  $type = $_POST['type'];
  $desc = $_POST['desc'];
 $type = $_POST['type'];
  $category = $_POST['category'];
  $tags = $_POST['tags'];
 $allowed_filetypes = array('.jpg','.JPG','.MPG','.gif','.bmp','.png','.avi','.mov','.wmv','.mp3','.mp4','.mpeg','.jpeg'); 
  $max_filesize=10485760;
 


  if($_POST['visibility'] == 'Public')
  	{ $visibility = 1;
	}
  else 
   {
   	$visibility = 0;
   }
  
if($type==2)
  {
 
$type='image';
}
elseif($type==3)
  {
    
  $type='video';
  }elseif($type==1)
  {
   
  $type='audio';
  }
   if($type == NULL)
  {
  	$errmsg ="PLEASE ENTER THE TYPE";
  }

//$dirfile='C:\wamp\www\php_site\includes\uploads'.$username

	if($_FILES["media"]["error"] > 0 )
	{ $result=$_FILES["media"]["error"];} //error from 1-4
	else
	{
	  $upfile = $dirfile.urlencode($_FILES["media"]["name"]);
	  
  	  $filename=$_FILES['media']['name'];
	  $ext=substr($filename, strpos($filename,'.')+1, strlen($filename)-1); 						  
	  $fname=substr($filename,0,strpos($filename,'.'));
	  
	  if(file_exists($upfile))
	  {
	  		$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["media"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["media"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
//$mediaid = mysql_insert_id();
$username = $_SESSION['username'];
	$query = "select * from account where name='$username'";
	$result1 = mysql_query( $query );
		
	if (!$result1)
	{
	   die ("errrrrrrr". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result1);
		$userid = $row[0];
	}
					$insert = "insert into media(name,userid,path,type,category,description,format,visibility)".
							  "values('". urlencode($_FILES["media"]["name"])."','$userid','$dirfile','$type','$category','$desc','".$_FILES["media"]["type"]."','$visibility')";
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					$result1="0";
					
		$tagid = mysql_insert_id();
		if(!isset($tagid))
			{die("Tag Insert Failed");}	
		
		$sql= "INSERT INTO tags (tags_id,tags) VALUES ('".$tagid."','".$tags."');";
		$result1 = mysql_query($sql) or die("Failed to insert tags");
			
		
		
		$mediaquery="Select * from media where path='".$dirfile."' and name='". urlencode($_FILES["media"]["name"])."'";
		$mediaquery1=mysql_query($mediaquery) or die(mysql_error());
		$mediarow=mysql_fetch_row($mediaquery1);
		$mediaid=$mediarow[0];	
		echo $mediaid;			
		
		$sql1 = "insert into mediatags(tags_id,mediaid) values('".$tagid."','".$mediaid."')";	
		$result1 = mysql_query($sql1) or die("Failed to insert mediatags".mysql_error());
		
		
		
		$msg = 1;
					
					//insert into upload table
		//			$insertUpload="insert into upload(uploadid,username,mediaid) values //NULL,'$username','$mediaid')";
//					$queryresult = mysql_query($insertUpload)
//						  or die("Insert into view error in //media_upload_process.php " //.mysql_error());
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
