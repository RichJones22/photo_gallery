<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }


// must have an ID
if(empty($_GET['comment_id'])) {
    $session->message("No comment ID was provied.");
    redirect("index.php");
}

// check if passed comment id exists.
$comment = Comment::find_by_id($_GET["comment_id"]);
if ($comment && $comment->delete()) {
    //$session->message("The comment {$comment->filename} was deleted.");
    redirect_to("comments.php?id={$_GET['photo_id']}");
} else {
    $session->message("The comments could not be deleted.");
    redirect_to("list_photos.php");
}

if(isset($database)) { $database->close_connection(); }  

  
	

