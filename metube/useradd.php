<?php
if(isset($_GET["add"])) {
$query = mysql_query("SELECT id FROM site_members WHERE id = '" . $_GET["add"] . "'");
if(mysql_num_rows($query) > 0) {
$_query = mysql_query("SELECT * FROM friendship_requests WHERE sender = '" . $_SESSION["logged"] . "' AND recipient = '" . $_GET["add"] . "'");
if(mysql_num_rows($_query) == 0) {
mysql_query("INSERT INTO friendship_requests SET sender = '" . $_SESSION["logged"] . "', recipient = '" . $_GET["add"] . "'"); }} }
?>
