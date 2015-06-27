<?php
/* 
require_once("../includes/functions.php");
require_once("../includes/database.php");
//require_once("../includes/user.php");


$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr />";

$users = User::find_all();
foreach ($users as $user) {
	echo "User: ". $user->username . "<br />";
	echo "Name: ". $user->full_name() . "<br /><br />";
}
*/
?>

<?php 
require_once("../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }



?>
<?php include_layout_tempate('header.php'); ?>
			

<?php 

$user = User::find_by_id(1);

echo $user->full_name();
echo "<hr />"; 
$users = User::find_all();
foreach ($users as $user) {
	echo "User: ". $user->username . "<br />";
	echo "Name: ". $user->full_name() . "<br /><br />";
}


//
// testing logger code
//
echo "<hr />"; 
Logger::log_action("login", "Rich is logging in");

echo "the log file name is: " . Logger::display_log_file_name();

?>
			
<?php include_layout_tempate('footer.php'); ?>

?>
