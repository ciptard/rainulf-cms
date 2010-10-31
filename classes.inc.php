<?php
/*******************
 * Author: Rainulf *
 * Date  : Oct 19  *
 *******************/

if(!defined("INDEX")) die("Not allowed.");

/*
 * Database connection.
 * Contains method for selecting/inserting from/to tables.
 */
// TODO: Try prepared statements
class DatabaseConnection {
   private $link;     // Database link
   
   private $table;
   private $column;
   private $order;
   private $orderby;
   private $limitx;
   private $limity;
   
   public function __construct( ) {
      include 'conf.inc.php';
      $this->link = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD) or die($this->link->error);
      $this->link->set_charset($DB_CHARSET) or die($this->link->error);
      $this->link->select_db($DB_DATABASE) or die($this->link->error);
   }
   
   public function __destruct( ) { 
      $this->link->close( ); 
      unset($this->link, 
            $this->table,
            $this->column,
            $this->order,
            $this->orderby,
            $this->limitx,
            $this->limity);
   }
   
   public function setTable($value) { 
      $this->table = $value; 
      if(isset($this->table)) return TRUE;
      else return FALSE;
   }
   
   public function setColumn( ) { 
      $column = array( );
      $numargs = func_num_args( );
      $arg_list = func_get_args( );
      foreach($arg_list as $arg) $column[] = $arg;
      if(count($column) > 1 || $numargs > 1) $columnImploded = implode(",", $column);
      $this->column = $columnImploded;
      
      if(isset($this->column)) return TRUE;
      else return FALSE;
   }
   
   public function setOrder($orderby, $order) {
      $this->orderby = $orderby;
      $this->order   = $order;
      if(isset($this->orderby, $this->order)) return TRUE;
      else return FALSE;
   }
   
   public function setLimit($limitx, $limity) {
      $this->limitx = $limitx;
      $this->limity = $limity;
      if(isset($this->limitx, $this->limity)) return TRUE;
      else return FALSE;
   }
   
   public function whereSearchLike($where, $what, $strict = FALSE) {
      $searchMethod = ($strict) ? "{$where} = '{$what}'" : "{$where} LIKE '%{$what}%'";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->query($queryString);
   }
   
   public function indexResult( ) {
      $queryString = " SELECT {$this->column} FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->query($queryString);
   }
   
   public function returnThe($what) {
      switch($what) {
         case "table": $ret = $this->table; break;
         case "column": $ret = $this->column; break;
         case "order": $ret = $this->order; break;
         case "orderby": $ret = $this->orderby; break;
         case "limitx": $ret = $this->limitx; break;
         case "limity": $ret = $this->limity; break;
         default: $ret = FALSE;
      }
      return $ret;
   }
   
   public function real_escape_string($str) {
      return $this->link->real_escape_string($str);
   }
   
}

/*
 * Reading/writing files from/to directory
 *
 */
class ManageFiles {
   protected $currentFolder;
   
   public function __construct($folder = NULL) {
      $this->currentFolder = $folder;
   }
   
   public function __destruct( ) { unset($this->currentFolder); }
   
   public function scanFolder($srt = 0) {
      $dircontent = scandir($this->currentFolder);
      $arr = array();
      foreach($dircontent as $filename) {
        if ($filename != '.' && $filename != '..') {
          if (filemtime($this->currentFolder.$filename) === false) return false;
          $dat = date("YmdHis", filemtime($this->currentFolder.$filename));
          $arr[$dat] = $filename;
        }
      }
      if (!ksort($arr)) return false;
      if ($srt) return array_reverse($arr);
      else return $arr;
   }
}

/*
 * Fetching/inputting contents from/to the database.
 *
 */
class ManageContents {
   protected $contentDb;
   
   public function __construct($database) {
      $this->contentDb = $database;
      $this->contentDb->setTable("contents");
      $this->contentDb->setColumn("id", "Title", "content", "PostD");
      $this->contentDb->setOrder("PostD", "desc");
      $this->contentDb->setLimit(0, 7);
   }
   
   public function __destruct( ) {
      unset($this->contentDb);
   }
   
   public function commonArrayFetch ($result) {
      $arr = array( );
      $arrStringColumns = "";
      $columnsExploded = explode(',', $this->contentDb->returnThe("column"));
      foreach($columnsExploded as $column) $arrStringColumns .= "'{$column}' => \$row['{$column}'], ";
      $arrStringColumns = rtrim($arrStringColumns, ", ");
      //echo $arrStringColumns;
      while($row = $result->fetch_array( )) {
         eval("\$arr[] = array($arrStringColumns);");
      }
      return $arr;
   }
   
   public function searchPost($id = 0, $strict = FALSE) {
      if(!isset($_GET['s']) && !isset($_GET['id'])) return FALSE;
      
      if(isset($_GET['s'])) {
         $searchString = $this->contentDb->real_escape_string(htmlspecialchars($_GET['s'], ENT_QUOTES));
         $column = "Title";
      }
      else if($id) {
         $searchString = intval($id);
         $column = "id";
      }
      
      $result = $this->contentDb->whereSearchLike($column, $searchString, $strict);

      $arr = $this->commonArrayFetch($result);
      return $arr;
   }
   
   public function indexPosts( ) {
      $result = $this->contentDb->indexResult( );
      $arr = $this->commonArrayFetch($result);
      return $arr;
   }
   
}

/*
 * Fetching/inputting comments from/to the database.
 *
 */
class ManageComments extends ManageContents {
   protected $commentDb;
   
   public function __construct($commentDb, $contentDb) {
      $this->commentDb = $commentDb;
      $this->commentDb->setTable("comments");
      $this->commentDb->setColumn("id", "Title", "content", "PostD", "ContentId");
      $this->commentDb->setOrder("PostD", "desc");
      $this->commentDb->setLimit(0, 10);

      // Since $contentDb already holds identifier to obj, its table, column, order, etc should already be set
      $this->contentDb = $contentDb;
   }
   
   public function __destruct( ) {
      unset($this->contentDb, $this->commentDb);
   }
   
   
}

/*
 * Only for displaying/echoing HTML/contents
 *
 */
class Displayer {
   protected $contents;
   public $unhideFirstPost;
   
   public function __construct($contents) {
      $this->contents = $contents;
      $this->unhideFirstPost = "unhidden";
   }
   
   public function __destruct( ) {
      unset($this->contents, $this->unhideFirstPost);
   }
   
   public function displayPost($id, $title, $date, $content, $numofcomments) {
      echo "
         <a name='$id'></a>
		   <div class='post'>
			   <h1 class='title'><a href=\"javascript:unhide('id_{$id}');\">$title</a></h1>
			   <div id='id_{$id}' class='{$this->unhideFirstPost}'>
			      <p class='byline'><small>Posted on $date</small></p>
			      <div class='entry'>
               $content
			      </div>
			      <div class=\"meta\">
				      <p class=\"links\"><a href='#verytop'>Back to top</a> &nbsp;&bull;&nbsp; <a href=\"javascript:unhide('id_comment_{$id}');\" class='comments'>Comments (not available yet)</a></p>
			      </div>
			      <div id='id_comment_{$id}' class='hidden'>
			         <form action=\"\" method='post'>
			         <table>
			            <tr>
			               <th>Name</th><td><input type='text' name='comment_name' /></td>
			            </tr>
			            <tr>
			               <th valign='top'>Comments</th>
			               <td><textarea name='comment_content' rows='7' cols='50'></textarea><br />
			               <input type='submit' value='Submit!' /></td>
			            </tr>
			         </table>
			         </form>
			      </div>
			   </div>
		   </div>
	    ";
	    if($this->unhideFirstPost == "unhidden") $this->unhideFirstPost = "hidden";
   }
   
   public function displayManyPosts($arr) {
      $numOfPosts = count($arr);
      for($i=0; $i < $numOfPosts; $i++) {
         $this->displayPost($arr[$i]['id'], $arr[$i]['Title'], $arr[$i]['PostD'], $arr[$i]['content'], 0);
      }
   }
   
   public function displayList($arr) {
      $numOfPosts = count($arr);
      echo "<ul>";
      for($i=0; $i < $numOfPosts; $i++) {
         echo "<li><a href='?id={$arr[$i]['id']}'>{$arr[$i]['Title']}</a></li>";
      }
      echo "</ul>";
   }
   
   public function displayFiles($arr) {
      $numOfPosts = count($arr);
      echo "<ul>";
      foreach($arr as $a => $b) {
         echo "<li><a href='./source_codes/{$b}'>$b</a></li>";
      }
      echo "</ul>";
   }
   public function ajaxSearchDisplay( ) {
      $arr = $this->contents->searchPost( );
      $numOfPosts = count($arr);
      if($numOfPosts) {
         for($i=0; $i < $numOfPosts; $i++) {
            $this->displayPost($arr[$i]['id'], $arr[$i]['Title'], $arr[$i]['PostD'], $arr[$i]['content'], 0);
         }
      }
      else {
         echo "<p>'".htmlspecialchars($_GET['s'], ENT_QUOTES)."' cannot be found.</p>";
      }
   }
}





?>
