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
class DatabaseConnection {
   private $link;     // Database link
   private $dbInfo;   // array - db info
   
   private $table;
   private $column;
   private $order;
   private $orderby;
   private $limitx;
   private $limity;
   
   public function __construct($user, $pass, $db, $host = "localhost", $charset = "utf8") {
      $this->link = new mysqli($host, $user, $pass) or die($this->link->error);
      $this->link->set_charset($charset) or die($this->link->error);
      $this->link->select_db($db) or die($this->link->error);
   }
   
   public function __destruct( ) { 
      $this->link->close( ); 
      unset($this->link, 
            $this->dbInfo,
            $this->table,
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
   protected $db;
   
   public function __construct($database) {
      $this->db = $database;
      $this->db->setTable("contents");
      $this->db->setColumn("id", "name", "content", "loldate");
      $this->db->setOrder("id", "desc");
      $this->db->setLimit(0, 7);
   }
   
   public function __destruct( ) {
      unset($db);
   }
   
   public function commonArrayFetch ($result) {
      $arr = array( );
      $arrStringColumns = "";
      $columnsExploded = explode(',', $this->db->returnThe("column"));
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
         $searchString = preg_replace('/[\W]^ /', "", (isset($_GET['s'])) ? $_GET['s'] : "");
         $column = "name";
      }
      else if($id) {
         $searchString = intval($id);
         $column = "id";
      }
      
      $result = $this->db->whereSearchLike($column, $searchString, $strict);

      $arr = $this->commonArrayFetch($result);
      return $arr;
   }
   
   public function indexPosts( ) {
      $result = $this->db->indexResult( );
      $arr = $this->commonArrayFetch($result);
      return $arr;
   }
   
}

/*
 * Only for displaying/echoing HTML/contents
 *
 */
class Displayer {
   protected $contents;
   
   public function __construct($contents) {
      $this->contents = $contents;
   }
   
   public function __destruct( ) {
      unset($contents);
   }
   
   public function displayPost($id, $title, $date, $content, $numofcomments) {
      echo "
         <a name='$id'></a>
		   <div class=\"post\">
			   <h1 class=\"title\">$title</h1>
			   <p class=\"byline\"><small>Posted on $date</small></p>
			   <div class=\"entry\">
            $content
			   </div>
			   <div class=\"meta\">
				   <p class=\"links\"><a href='#verytop'>Back to top</a> &nbsp;&bull;&nbsp; <a href='#' class=\"comments\">Comments (not available yet)</a></p>
			   </div>
		   </div>
	    ";
   }
   
   public function displayManyPosts($arr) {
      $numOfPosts = count($arr);
      for($i=0; $i < $numOfPosts; $i++) {
         $this->displayPost($arr[$i]['id'], $arr[$i]['name'], $arr[$i]['loldate'], $arr[$i]['content'], 0);
      }
   }
   
   public function displayList($arr) {
      $numOfPosts = count($arr);
      echo "<ul>";
      for($i=0; $i < $numOfPosts; $i++) {
         echo "<li><a href='?id={$arr[$i]['id']}'>{$arr[$i]['name']}</a></li>";
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
            $this->displayPost($arr[$i]['id'], $arr[$i]['name'], $arr[$i]['loldate'], $arr[$i]['content'], 0);
         }
      }
      else {
         echo "<p>'{$_GET['s']}' cannot be found.</p>";
      }
   }
}


class ManageComments {

}



?>
