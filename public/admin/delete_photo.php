<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

// must hve an ID
if(empty($_GET['id'])) {
    $session->message("No photograph ID was provied.");
    redirect("index.php");
}

// check if passed photo id exists.
$photo = Photograph::find_by_id($_GET["id"]);
if ($photo && $photo->destory()) {
    $session->message("The photo {$photo->filename} was deleted.");
    redirect_to("list_photos.php");
} else {
    $session->message("The photo could not be deleted.");
    redirect_to("list_photos.php");
}

if(isset($database)) { $database->close_connection(); }  

  
	

