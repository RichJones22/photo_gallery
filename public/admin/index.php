<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php include_layout_template('admin_header.php'); ?>
<br>
<br>
<?php echo output_message($message); ?>
<br>
<br>
<h2>Menu</h2>
<ul>
    <li><a href="list_photos.php">List Photos</li>
    <li><a href="logfile.php">View log file</li>
    <li><a href="logout.php">Logout</li>			
</ul>
	
			
<?php include_layout_template('admin_footer.php'); ?>