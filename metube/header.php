<?php include('/var/www/spring13/g6/metube/variables.php'); ?>
<?//php session_start()?>
<div id="header">
    
    <div id="login">

<?php 

if (isset($_SESSION['username'])) {
    $_SESSION['loggedin'] = true;
    //$_SESSION['username'] = $username; // $username coming from the form, such as $_POST['username']
                                       // something like this is optional, of course
   
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "Welcome, " . $_SESSION['username'] . "!";
    echo '<form action="logout.php" method="post">';
    echo '<button type="submit">logout</button>';
    echo '</form>';
} else {
     include('/var/www/spring13/g6/metube/login.php');
}
?>


</div>

</div> <!-- end #header -->



