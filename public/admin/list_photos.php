<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php include_layout_template('admin_header.php'); ?>

 <a href="index.php">&laquo; Back</a>
 <br />
 <br />
 <?php echo output_message($message); ?>
 <br />
 <h2>Photo Gallery</h2>
 <?php echo output_message($message); ?>
 <table class="bordered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Sizes</th>
    <th>Type</th>
    <th>Comments</th>
    <th>&nbsp;</th>
  </tr>
 <?php 
    $photos = Photograph::find_all(); 
    foreach ($photos as $photo) {
 ?>
  <tr>
    <td><img src="..\<?php echo $photo->get_image_file(); ?>" width="100" /></td>
    <td><?php echo $photo->filename; ?></td>
    <td><?php echo $photo->caption; ?></td>
    <td><?php echo $photo->get_size_as_text(); ?></td>
    <td><?php echo $photo->type; ?></td>
    <td>
        <a href="comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()); ?></a>
    </td>
    <td>
        <a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
    </td>
  </tr>
 <?php // end foreach
  } ?>
</table>
<br />
<a href="photo_upload.php">Upload a new photograph</a>

<?php include_layout_template('admin_footer.php'); ?>