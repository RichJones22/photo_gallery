<?php 
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php include_layout_tempate('admin_header.php'); ?>

<?php
//$user = new User();
//$user->username="bob01";
//$user->password="password";
//$user->first_name="bob";
//$user->last_name="segar01";
//if ($user->create()) {
//	echo "user, $user->username, was successfully inserted";
//} else {
//	echo "insert failed.";
//}

//$user = new User();
//$user = User::find_by_id(11);
//$user->last_name="sweet17";
//if ($user->update()) {
//	echo "user, $user->username, was successfully updated";
//} else {
//	echo "update failed.";
//}


//  $user = new User();
//	$user = User::find_by_id(11);
//	if ($user->delete()) {
//		echo "user, $user->username, was successfully deleted";
//	} else {
//		echo "delete failed.";
//	}

//	$photos = Photograph::find_all();
//	foreach ($photos as $photo) {
//		//echo "filename: ". $photo->filename . "<br />";
//		//echo "target path ". $photo->get_upload_file() . "<br />";
//	  <img src="pic_mountain.jpg" alt="Mountain View" style="width:304px;height:228px">
//		echo "caption: ". $photo->caption . "<br /><br />";
//	}
	//	chdir(SITE_ROOT.DS.'public'.DS.$photo->get_upload_dir());
?>
<html>
<body>
 <h2>Photo Gallery</h2>
 <?php 
	$photos = Photograph::find_all();
	foreach ($photos as $photo) {
 ?>
 	  <img src="<?php echo $photo->get_image_file(); ?>" width="200" height="200"><br />
	  caption: <?php echo $photo->caption ?><br />
 <?php 
  } ?>
</body>
</html>


	
			
<?php include_layout_tempate('admin_footer.php'); ?>

