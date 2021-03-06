<?php 

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);



chdir(dirname(__FILE__));
chdir('../');

defined('SITE_ROOT') ? null :
                       define('SITE_ROOT', getcwd());
// I have spaces in my path name so instead used the chdir() fuction above to get the SITE_ROOT.
//defined('SITE_ROOT') ? null :
//                        define('SITE_ROOT', 'c:\apache'.DS.'htdocs'.DS.'programming'.DS.'lynda.com'.DS.'\"PHP with MySQL Beyond the Basics\"'.DS.'photo_gallery');

defined('LIB_PATH')  ? null : 
                       define('LIB_PATH', SITE_ROOT.DS.'includes');
                       
// load config file first
require_once(LIB_PATH.DS."config.php");
//require_once(dirname(__FILE__).DS."config.php");

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS."functions.php");

// load core objects
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."pagination.php");
require_once(LIB_PATH.DS."PHPMailer".DS."class.phpmailer.php");

// load database-related classes
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photograph.php");
require_once(LIB_PATH.DS."logger.php");
require_once(LIB_PATH.DS."comment.php");
