<?php 
// Check if the user is logged in, show message if they aren't
session_start();
if($_SESSION["loggedIn"] != true) {
	header("Location: 404.php");
  exit();
}