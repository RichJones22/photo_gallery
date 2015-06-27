<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

// must hve an ID
if(empty($_GET['id'])) {
    $session->message("No photograph ID was provied.");
    redirect_to("index.php");
}

// must hve an ID
$photo = Photograph::find_by_id($_GET['id']);
if(empty($photo)) {
    $session->message("The photo could not be located.");
    redirect_to("index.php");
}

$comments = $photo->comments();
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="list_photos.php">&laquo; Back</a>

<?php echo output_message($message); ?>
<br>
<br>
<h1>Comments on <?php echo $photo->filename; ?></h1>
<br>
<br>
<div id="comments">
    <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
        <div class="author">
            <?php echo htmlentities($comment->author); ?> wrote:            
        </div>
        <div class="body">
            <?php echo strip_tags($comment->body, '<strong><em><p>'); ?> 
        </div>
        <div class="meta-info" style="font-size: 0.8em;">
            <?php echo datetime_to_text($comment->created); ?>  
        </div>
        <div class="actions" style="font-size: 0.8em;">
            <a href="delete_comment.php?comment_id=<?php echo $comment->id; ?>&photo_id=<?php echo $photo->id; ?>">Delete Comment</a>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($comments)) { echo "No comments."; } ?>
</div>


<?php include_layout_template('admin_footer.php'); ?>

