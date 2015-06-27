<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

if (isset($_GET['clear'])=='true') {
	Logger::clear_log_file($_SESSION['user_id']); 	
	redirect_to('logfile.php');
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Log File</h2>

<p><a href="logfile.php?clear=true">Clear log file</a><p>
	
<?php 

echo Logger::read_log_file();	
					
include_layout_template('admin_footer.php'); 

?>

