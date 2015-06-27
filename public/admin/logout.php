<?php require_once("../../includes/initialize.php"); ?>

<?php // v1: simple logout.
      // session_start();
			$session->logout();
      redirect_to("login.php");
?> 
   
<?php // v2:  destroy session
      // assumes nothing else in the session is to be kept.
     
/* heavy handed approahc commented out
      session_start();
      $_SESSION = array();                                  // sets session to empty
      if (isset($_COOKIE[session_name()])) {                // if cookie exists set it to empty and cause it to expire by setting it to a time in the past
      	setcookie(session_name(), '', time()-42000, '/');   // this disassociates the cookie to the file on the pc where the cookie is stored.
      }
      
      session_destroy();                                    // removes file where cookie is stored on the pc.  
      redirect_to("login.php");
*/
?> 
