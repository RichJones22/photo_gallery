<?php 
require_once("../includes/initialize.php");

    // pagination
    // 1.  the current page number ($current_page)
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    
    // 2.  records per page ($per_page)
    $per_page = 3;
    
    // 3.  total record count ($total_count)
    $total_count = Photograph::count_all();
    

    //$photos = Photograph::find_all(); 
    $pagination = new Pagination($page, $per_page, $total_count);
    
    $photos = Photograph::get_current_page($pagination)
    
    
 ?>   

 <?php include_layout_template('header.php'); ?>
			
 <?php echo output_message($message); ?>

 <?php foreach ($photos as $photo) { ?>
 <div style="float: left; margin-left: 20px;">
     <a href="photo.php?id=<?php echo $photo->id; ?>">
        <img src="<?php echo $photo->get_image_file(); ?>" width="200" alt="<?php $photo->filename; ?>"/>
     </a>
     <p><?php echo $photo->caption; ?></p>
 </div>
 <?php } ?>
<div id="pagination" style="clear: both;">
<?php 
if($pagination->total_pages() > 1) {
    if($pagination->has_previous_page()) {
        echo "<a href=\"index.php?page=";
        echo $pagination->previous_page();
        echo "\">&laquo; Previsous</a> ";
    }
    for ($i=1; $i <= $pagination->total_pages(); $i++) {
        if($i == $page) {
            echo " <span class=\"selected\">{$i}</span> ";
        } else {
            echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
        }
    }
    if($pagination->has_next_page()) {
        echo "<a href=\"index.php?page=";
        echo $pagination->next_page();
        echo "\">Next &raquo;</a> ";
    }
}
?>
</div>		


<?php include_layout_template('footer.php'); ?>

