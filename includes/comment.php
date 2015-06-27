<?php

/**
 * class to manage the comments table.
 *
 * @author Rich
 */

/*******************************************************************************
 * required libraies
 ******************************************************************************/
require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."database.php");

/*******************************************************************************
 * class comments
 ******************************************************************************/
class Comment extends DatabaseObject {
    
    protected static $table_name="comments";

    // db column vars
    public $id;
    public $photograph_id;
    public $created;
    public $author;
    public $body;

    public static function make($photo_id, $author="Anonymous", $body=""){
        global $database;

        if (!empty($photo_id) && !empty($author) && !empty($body)) {
          $comment = new comment();
          $comment->photograph_id = (int)$photo_id;
          $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
          $comment->author = $database->escape_value($author);
          $comment->body = $database->escape_value($body);
          return $comment;
       } else {
          return false;
       }
    }

    public static function find_comments_on($photo_id) {
        global $database;

        $sql  = "select * from ". static::$table_name;
        $sql .= " where photograph_id =". $database->escape_value($photo_id);
        $sql .= " order by created asc";
        return static::find_by_sql($sql);
    }
  
    public static function delete_comments($photograph_id) {
        global $database;

        $sql  = "delete from " .static::$table_name;
        $sql .= " where photograph_id="   . $database->escape_value($photograph_id);

        $database->query($sql);

        return ($database->affected_rows() >= 0) ? true : false;
    }
    
    public function try_to_send_notification() {
        $mail = new PHPMailer();
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                                   // 1 = errors and messages
                                                   // 2 = messages only

        $mail->IsSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.yahoo.com';                  // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'jones_rich';                       // SMTP username
        $mail->Password = 'Stev1e22';                         // SMTP password
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted: original was 'tls'

        $mail->From = 'jones_rich@yahoo.com';
        $mail->FromName = 'Photo Gallery Admin';
        $mail->AddAddress('jones_rich@yahoo.com');               // Name is optionals

        $mail->WordWrap = 70;                                 // Set word wrap to 50 characters
        $mail->IsHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'New Photo Gallery Comment';
        $created = datetime_to_text($this->created);
        
        // below is a use of a 'here document'
        $mail->Body    =<<<EMAILBODY

A new comment has been received in the Photo Gallery On {$created}.
<br />    
The author, {$this->author}, wrote:
<br /><br />
{$this->body}

EMAILBODY;

        return $mail->send();

//        if(!$mail->Send()) {
//           echo 'Message could not be sent.';
//           echo 'Mailer Error: ' . $mail->ErrorInfo;
//           exit;
//        } else {
//                 echo "Message sent.";
//        }
        
        
    }
}
