<?php

	defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER"  , "gallery");
	defined('DB_PASS')   ? null : define("DB_PASS"  , "password");
	defined('DB_NAME')   ? null : define("DB_NAME"  , "photo_gallery");

/*  not user if we are using the below yet?
  // 1. Create a database connection
  $dbhost = "localhost";
  $dbuser = "widget_cms";
  $dbpass = "password";
  $dbname = "widget_corp";
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection occurred.
  if(mysqli_connect_errno()) 
  {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
  }
*/

?>
