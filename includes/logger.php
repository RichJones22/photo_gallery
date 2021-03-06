<?php

class Logger {

	private static $log_file=null;
	private static $log_file_handle=0;
	
	const LOG_ACTION_LOGIN = "login";
	const LOG_ACTION_CLEARED = "Logs Cleared";
	
	//
	// private methods.
	//
	private static function set_log_file_location() {
		
		// derive logs directory
		chdir(dirname(__FILE__));
		chdir('../logs');
		
		// set logs.txt file name location.
		self::$log_file = getcwd().DS.'logs.txt';
		
	}
	
	private static function open_log_file_append_mode() {
		
		// set log file location
		self::set_log_file_location();
		
		// open $log_file or die.
		if (!(self::$log_file_handle = fopen(self::$log_file, 'at'))) {
			die("Could not open log file, {$log_file}.  Terminating program...");
		}
		
	}
	
	private static function close_log_file() {
		
		// close log file if not null.
		if (is_null(self::$log_file)) {
			close(self::$log_file);
		}

	}

	public static function log_action($action, $message="") {
		
		$contents="";
		
		// if $log_file is null, create a new log file.
		if (is_null(self::$log_file)) {
			self::open_log_file_append_mode();
		}
		
		// if file does not exist or is not writable, terminate...
		if (!is_writable(self::$log_file)) {
			die("log file, {$log_file}, does not exist or is not writtable.  Terminating program...");
		}
		
		// set timezone; needed for time()
		date_default_timezone_set('America/Chicago');
		
		// build context to log.
		$contents = strftime('%m/%d/%Y %H:%M:%S', time()) . " | " . $action . ": " . $message . ".\n";
		
		fwrite(self::$log_file_handle, $contents);
		
		//close the log file after each write;
		self::close_log_file();
	}
	
	//
	// public methods.
	//
	public static function read_log_file() {
		
		// set log file location
		self::set_log_file_location();
		
		if (self::$log_file_handle = fopen(self::$log_file, 'rt')) {
			$content = fread(self::$log_file_handle, filesize(self::$log_file));
			fclose(self::$log_file_handle);
		}
		
		return "<br/>" . nl2br($content) . "<br/>";

	}

	public static function clear_log_file($user_id) {
		
		// set log file location
		self::set_log_file_location();
		
		// set timezone; needed for time()
		date_default_timezone_set('America/Chicago');
		
		// build context to log.
		$contents = strftime('%m/%d/%Y %H:%M:%S', time()) . " | " . self::LOG_ACTION_CLEARED . ": " . "by User ID {$user_id}.\n";
				
		if (self::$log_file_handle = fopen(self::$log_file, 'wt')) {
			fwrite(self::$log_file_handle, $contents);
			fclose(self::$log_file_handle);
		}
		
	}
	
	public static function display_log_file_name() {
	
		// set log file location
		self::set_log_file_location();
	
		return self::$log_file;
	}

}


?>