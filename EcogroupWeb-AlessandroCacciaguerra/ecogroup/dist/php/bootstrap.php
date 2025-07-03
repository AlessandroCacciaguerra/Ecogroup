<?php
require_once("database.php"); //database directory
$dbh = new Database();
echo $dbh->getErrorString();
