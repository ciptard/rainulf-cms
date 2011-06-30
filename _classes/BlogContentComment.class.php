<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: Jun 29, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");


/**
 * Fetching/inputting comments from/to the database.
 */
class BlogContentComment {
   protected $commentDb;
   
   public function __construct( ) {
      $this->commentDb = new DatabaseConnection( );
      $this->commentDb->setTable("comments");
      $this->commentDb->setColumn("Name", "content", "PostD", "ContentId", "IP");
      $this->commentDb->setOrder("PostD", "desc");
      $this->commentDb->setLimit(0, COMMENTS_PER_CONTENT);
   }
   
   public function getCommentsForContentId( ) {
      $ret = null;
      if(!isset($_GET['comment_contentid'])) {
         $ret = false;
      }
      else {
         $comment_contentid = intval($_GET['comment_contentid']);
         $result = $this->commentDb->whereSearchLike("ContentId", $comment_contentid, 1);
         $arr = $this->commonArrayFetch($result);
         $ret = $arr;
      }
      return $ret;
   }
   
   public function insertCommentsInId( ) {
      $result = null;
      if(!isset($_SESSION['loggedin'], $_SESSION['name'])) {
         $result = false;
      }
      else {
         // if(!isset($_POST['post_id'], $_POST['comment_name'], $_POST['comment_content'])) return FALSE;
         // if($_POST['post_id'] == NULL || $_POST['post_id'] == "" || $_POST['comment_name'] == NULL || $_POST['comment_name'] == "") return FALSE;
         $post_id          = intval($_POST['post_id']);
         //$fb_user          = $this->social->username; // get user's fb full name
         $comment_name     = "'".$_SESSION['name']."'";
         $comment_content  = "'".$this->commentDb->real_escape_string(htmlspecialchars($_POST['comment_content'], ENT_QUOTES))."'";
         $comment_ip       = "'".$_SERVER['REMOTE_ADDR']."'";
         // if($this->checkSpamBlacklist($comment_name) || $this->checkSpamBlacklist($comment_content)) return FALSE;
         $result = $this->commentDb->insertInTable($comment_name, $comment_content, "NOW( )", $post_id, $comment_ip);
      }
      return $result;
   }
   
   public function checkSpamBlacklist($str) {
      $blacklist = explode("\n", file_get_contents("./spamblacklist.txt"));
      $spam_count = 0;
      foreach($blacklist as $word) {
         if(@stripos($str, rtrim($word))) {
            $spam_count++;
         }
      }
      return $spam_count;
   }
   
   public function __destruct( ) {
      unset($this->commentDb);
   }
   
   
}

?>
