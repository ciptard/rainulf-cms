<?php
/* 
Author: Rainulf (http://rainulf.net/)
Licensed under GNU GENERAL PUBLIC LICENSE v2. See: LICENSE file.

core file for the whole script. Creates object called $core which holds all of methods


-=-=- TABLE CREATION -=-=-
CREATE TABLE contents (
   id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name CHAR(50),
   content TEXT,
   loldate DATE
) DEFAULT CHARACTER SET utf8;
*/

if(!defined("INDEX")) die("Not allowed.");
set_error_handler("customError");

$core = new Rainulf( );

function customError($errno, $errstr) {
   echo "<b>Error:</b> [$errno] $errstr<br />";
}

class Rainulf {
   protected $link;     // Database link
   protected $dbInfo;   // array - db info
   protected $siteInfo; // array - site info
   
   public $offset, $pgNum;                // Paging variables
   public $id, $name, $content, $loldate; // Variables for one content
   public $allPostsWithLimit;             // SQL result - needs to be rewind each use in the same php
   
   public function __construct( ) {
      require "conf.php";
      /* 'conf.php' contains the following array elements:
           - $dbInfo['host']
           - $dbInfo['user']
           - $dbInfo['pass']
           - $dbInfo['db']
           - $dbInfo['chset']
           - $siteInfo['rowsPerPage']
         More elements will be added for $siteInfo
      */
      
      // Establish SQL connection, session and output buffer
      //
      $this->link = new mysqli($this->dbInfo['host'],
                               $this->dbInfo['user'],
                               $this->dbInfo['pass']) or die($this->link->error);
      @$this->link->set_charset($this->dbInfo['chset']) or die($this->link->error);
      @$this->link->select_db($this->dbInfo['db']) or die($this->link->error);
      session_start( );
      ob_start( );
      date_default_timezone_set("GMT");
      
      // Paging
      //
      $this->pgNum = isset($_GET['p']) ? intval($_GET['p']) : 1;
      $tempOffset = $this->pgNum * $this->siteInfo['rowsPerPage'];
      $this->offset = ($tempOffset > $this->siteInfo['rowsPerPage']) ? ceil($tempOffset-$this->siteInfo['rowsPerPage']) : 0;
      $this->allPostsWithLimit = $this->link->query("SELECT * FROM contents ORDER BY id DESC LIMIT " . $this->offset . ", " . $this->siteInfo['rowsPerPage']);
   }
   
   public function __destruct( ) {
      ob_end_flush( );
      $this->link->close( );
   }
   
   public function Insert($name, $content) { // Note: unsafe to public!
      if($this->link->query("INSERT INTO contents SET name='$name', content='$content', loldate=NOW( )"))
         echo "Success!<br />";
      else echo "Not success.<br />"; 
   }
   
   public function ViewPosts( ) {
      $this->allPostsWithLimit->data_seek(0);
      while($row = $this->allPostsWithLimit->fetch_array( )) {
         $datetime = explode(" ", $row['loldate']);
         $date = explode("-", $datetime[0]);
         $time = explode(":", $datetime[1]);
         echo "      <table class=\"content\">\n";
         echo "         <thead>\n";
         echo "            <tr><th>" . $row['name'] . "</th></tr>\n";
         echo "         </thead>\n";
         echo "         <tfoot>\n";
         echo "            <tr><td><b>Posted on:</b> ". date("M d Y h:ia T", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0])) . "</td></tr>\n";
         echo "         </tfoot>\n";
         echo "         <tbody>\n";
         echo "            <tr><td>" . $row['content'] . "<a href='post.php?id=" . $row['id'] . "'>Post Comment</a></td></tr>\n";
         echo "         </tbody>\n";
         echo "      </table>\n";
      }
   }
   
   public function ViewLatestEntries( ) {
      $this->allPostsWithLimit->data_seek(0);
      while($row = $this->allPostsWithLimit->fetch_array( )) {
         $id   = $row['id'];
         $name = $row['name'];
         echo "      <li><a href=\"http://rainulf.ca/post.php?id=$id\">$name</a></li>\n"; 
      }
   }
   
   public function ViewPost($id) {
      if(!isset($id)) return TRUE;
      $result = $this->link->query("SELECT * FROM contents WHERE id = $id");
      if($result->num_rows == 0) die("Not found.");
      $row = $result->fetch_array( );
      
      $datetime = explode(" ", $row['loldate']);
      $date = explode("-", $datetime[0]);
      $time = explode(":", $datetime[1]);
      
      $this->id      = $row['id'];
      $this->name    = $row['name'];
      $this->content = $row['content'];
      $this->loldate = date("M d Y h:ia T", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]));
   }
   
   public function ViewPaging( ) {
      $result = $this->link->query("SELECT * FROM contents");
      $maxPg = $result->num_rows / $this->siteInfo['rowsPerPage'];
      $next = 0;
      if($this->pgNum < $maxPg) echo "<li><a href=\"./?p=" . $next = $next + ($this->pgNum + 1) . "\">More....</a></li>";
   }
   
   public function ViewRSS($match = "\w") {
      $this->allPostsWithLimit->data_seek(0);
      while($row = $this->allPostsWithLimit->fetch_array( )) {
         $datetime = explode(" ", $row['loldate']);
         $date = explode("-", $datetime[0]);
         $time = explode(":", $datetime[1]);
         if(preg_match("/$match/", $row['name'])) {
            echo "   <item>\n";
            echo "     <title>" . $row['name'] . "</title>\n";
            echo "     <link>http://rainulf.ca/post.php?id=" . $row['id'] . "</link>\n";
            echo "     <description><![CDATA[ " . $row['content'] . " ]]></description>\n";
            echo "     <pubDate>" . date("r", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0])) . "</pubDate>\n";
            echo "   </item>\n";
         }
      }
   }
}
?>
