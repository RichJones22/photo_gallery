		  </div>
			<div id="footer">Copyright <?php date_default_timezone_set('America/Chicago'); ?><?php echo date("Y", time()); ?>, Kevin Skoglund</div>			
		</body>	
</html><?php if(isset($database)) { $database->close_connection(); } ?>