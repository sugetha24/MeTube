<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member List</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<?php 

session_start();
include_once "functions.php";

?> 
</head>


<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">


<?php
//Make a database connection
//include_once "browse.php";
 //Login section start
if(!isset($_SESSION["logged"])) {
    $query = mysql_query("SELECT userid FROM account WHERE name = '" .$_SESSION['username']. "'");
    if(mysql_num_rows($query) > 0) {
      $row = mysql_fetch_array($query);
      $_SESSION["logged"] = $row["userid"];
      header("Location: " . $_SERVER["PHP_SELF"]);
    }
  


} else {
//end of login section

//Section for adding friend
  if(isset($_GET["add"])) {
    $query = mysql_query("SELECT userid FROM account WHERE userid = '" . $_GET["add"] . "'")or die ("errrrrrrr". mysql_error());
    if(mysql_num_rows($query)) {
      $_query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $_SESSION["logged"] . "' AND recipient = '" . $_GET["add"] . "'");
      if(!mysql_num_rows($_query)) {
        mysql_query("INSERT INTO friendship_requests SET sender = '" . $_SESSION["logged"] . "', recipient = '" . $_GET["add"] . "'");
      }
    } 
  }
  if(isset($_GET["block"]))
  {
  	 $query = mysql_query("SELECT userid FROM account WHERE userid = '" . $_GET["block"] . "'")or die ("errrrrrrr". mysql_error());
  	 if(mysql_num_rows($query)) {
  	 $_query = mysql_query("SELECT * FROM blocked_users WHERE sender = '" . $_SESSION["logged"] . "' AND recipient = '" . $_GET["block"] . "'");
      if(!mysql_num_rows($_query)) {
        mysql_query("INSERT INTO blocked_users SET sender = '" . $_SESSION["logged"] . "', recipient = '" . $_GET["block"] . "'");
		}
		}
	}
	if(isset($_GET["block"]))	
		{
	$query = mysql_query("SELECT * FROM blocked_users WHERE sender = '" . $_GET["block"] . "' AND recipient = '" . $_SESSION["logged"] . "'");
    if(mysql_num_rows($query) > 0) {
      
      $_query = mysql_query("SELECT * FROM account WHERE userid = '" . $_GET["block"] . "'");
      $_row = mysql_fetch_array($_query);
      
      $blocked = unserialize($_row["blocked"]);
      $blocked[] = $_SESSION["logged"];      
                
      mysql_query("UPDATE account SET blocked = '" . serialize($blocked) . "' WHERE userid = '" . $_GET["block"] . "'");
      
      $_query = mysql_query("SELECT * FROM account WHERE userid = '" . $_SESSION["logged"] . "'");
      $_row = mysql_fetch_array($_query);
      
      $blocked = unserialize($_row["blocked"]);
      $blocked[] = $_GET["block"];      
                
      mysql_query("UPDATE account SET blocked = '" . serialize($blocked) . "' WHERE userid = '" . $_SESSION["logged"] . "'");
    }
   // mysql_query("DELETE FROM friendship_requests WHERE sender = '" . $_GET["block"] . "' AND recipient = '" . $_SESSION["logged"] . "'");
      
      }
    
//END

//Section for accepting friendship requests
  if(isset($_GET["accept"])) {
    $query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $_GET["accept"] . "' AND recipient = '" . $_SESSION["logged"] . "'");
    if(mysql_num_rows($query) > 0) {
      
      $_query = mysql_query("SELECT * FROM account WHERE userid = '" . $_GET["accept"] . "'");
      $_row = mysql_fetch_array($_query);
      
      $friends = unserialize($_row["friends"]);
      $friends[] = $_SESSION["logged"];      
                
      mysql_query("UPDATE account SET friends = '" . serialize($friends) . "' WHERE userid = '" . $_GET["accept"] . "'");
      
      $_query = mysql_query("SELECT * FROM account WHERE userid = '" . $_SESSION["logged"] . "'");
      $_row = mysql_fetch_array($_query);
      
      $friends = unserialize($_row["friends"]);
      $friends[] = $_GET["accept"];      
                
      mysql_query("UPDATE account SET friends = '" . serialize($friends) . "' WHERE userid = '" . $_SESSION["logged"] . "'");
    }
    mysql_query("DELETE FROM friendship_requests WHERE sender = '" . $_GET["accept"] . "' AND recipient = '" . $_SESSION["logged"] . "'");
  }
//END
//Section for showing friendship requests
  $query = mysql_query("SELECT * FROM friendship_requests WHERE recipient = '" . $_SESSION["logged"] . "'") or die ("errrrrrrr". mysql_error());
  if(mysql_num_rows($query) > 0) {
    while($row = mysql_fetch_array($query)) { 
      $_query = mysql_query("SELECT * FROM account WHERE userid = '" . $row["sender"] . "'");
      while($_row = mysql_fetch_array($_query)) {
        echo $_row["name"] . " wants to be your friend. <a href=\"" . $_SERVER["PHP_SELF"] . "?accept=" . $_row["userid"] . "\">Accept?</a><br />";
      }
    }
  }
//END

//Section for showing members list
  echo "<h2>Member List:</h2>";
  $query = mysql_query("SELECT * FROM account WHERE userid != '" . $_SESSION["logged"] . "'");
  while($row = mysql_fetch_array($query)) {
    $alreadyFriend = false;
	$alreadyBlocked = false;
    $friends = unserialize($row["friends"]);
	$blocked = unserialize($row["blocked"]);
	$useridmem = $row[0];
    if(isset($friends[0])) {
      foreach($friends as $friend) {
        if($friend == $_SESSION["logged"]) $alreadyFriend = true;
      }
    }
	if (isset($blocked[0]))
	{
		foreach($blocked as $blocked) {
        if($blocked == $_SESSION["logged"]) $alreadyBlocked = true;
      }
	}
    ?>
    <a href = "userprof.php?uid=<?php echo $useridmem; ?>"> <?php echo $row["name"]; ?> </a>
    <?php
    $_query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $_SESSION["logged"] . "' AND recipient = '" . $row["userid"] . "'");
    if(mysql_num_rows($_query) > 0) {
       echo " - Friendship requested.";
    } elseif($alreadyFriend == false) {
       echo " - <a href=\"" . $_SERVER["PHP_SELF"] . "?add=" . $row["userid"] . "\">Add as friend</a>";
    } else {
      echo " - Already friends.";
    }
    echo "<br />";
	$_queryblock = mysql_query("SELECT * FROM blocked_users WHERE sender = '" . $_SESSION["logged"] . "' AND recipient = '" . $row["userid"] . "'");
    if(mysql_num_rows($_queryblock) > 0) {
       echo " - user blocked.";
    } elseif($alreadyBlocked == false) {
       echo " - <a href=\"" . $_SERVER["PHP_SELF"] . "?block=" . $row["userid"] . "\">Block user</a>";
    } else {
      echo " - Already blocked.";
    }
  }
//END

//Friends list start
  echo "<h2>Friend List:</h2>";
  $query = mysql_query("SELECT friends FROM account WHERE userid = '" . $_SESSION["logged"] . "'");
  while($row = mysql_fetch_array($query)) {
    $friends = unserialize($row["friends"]);
    
    if(isset($friends[0])) {
      foreach($friends as $friend) {
        $_query = mysql_query("SELECT name FROM account WHERE userid = '" . $friend . "'");
        $_row = mysql_fetch_array($_query);
        echo $_row["name"] . "<br />";
      }
    }
  }
 //Blocked List Start
  echo "<h2>Blocked User List:</h2>";
  $queryblock = mysql_query("SELECT blocked FROM account WHERE userid = '" . $_SESSION["logged"] . "'");
  while($row = mysql_fetch_array($queryblock)) {
    $blocked = unserialize($row["blocked"]);
    
    if(isset($blocked[0])) {
      foreach($blocked as $blocked) {
        $_queryblock = mysql_query("SELECT name FROM account WHERE userid = '" . $blocked . "'");
        $_row = mysql_fetch_array($_queryblock);
        echo $_row["name"] . "<br />";
      }
    }
  }
//END
}
?>
<a href='browse.php'>Return to your home page</a>

</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>

