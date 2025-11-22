<?php
require_once "authorisation_check.php";
require_once "db_connection.php";

echo "<h1>Welcome, ".$_SESSION["username"]."</h1>";
echo "<p>Your role:".$_SESSION["role"]."</p>";

echo "<a href='logout.php'>Logout</a>";
?>