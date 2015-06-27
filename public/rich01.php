<?php 
require_once("../includes/initialize.php");
//if (!$session->is_logged_in()) { redirect_to("login.php"); }


?>
<?php include_layout_tempate('header.php'); ?>
			

<?php 



//
// testing logger code
//
echo "<hr />"; 
Logger::log_action("login", "Rich is logging in");

echo "the log file name is: " . Logger::display_log_file_name();

echo Logger::read_log_file();

Logger::clear_log_file();
echo Logger::read_log_file();

?>
			
<?php include_layout_tempate('footer.php'); ?>

?>
