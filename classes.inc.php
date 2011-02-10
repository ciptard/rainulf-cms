<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 19, 2010 *
 * Last Updated: Feb 09, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");
/*
 * Database connection.
 * Contains method for selecting/inserting from/to tables.
 */
class DatabaseConnection {
   protected $link;                // Database link
   
   protected $table;               // Table name
   protected $column;              // Columns to be used
   protected $order;               // Column should be ordered by
   protected $orderby;             // Desc or Asc?
   protected $limitx;              // LIMIT start
   protected $limity;              // LIMIT end
   
   public function __construct( ) {
      $this->link = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD) or die($this->link->error);
      $this->link->set_charset(DB_CHARSET) or die($this->link->error);
      $this->link->select_db(DB_DATABASE) or die($this->link->error);
   }
   
   public function __destruct( ) { 
      @$this->link->close( ); 
      unset($this->link, 
            $this->table,
            $this->column,
            $this->order,
            $this->orderby,
            $this->limitx,
            $this->limity,
            $this->prepared);
   }
   
   public function setTable($value) { 
      $this->table = $value; 
      return isset($this->table);
   }
   
   public function setColumn( ) { 
      $column = array( );
      $numargs = func_num_args( );
      $arg_list = func_get_args( );
      if(count($arg_list) > 1 || $numargs > 1) $columnImploded = implode(",", $arg_list);
      $this->column = $columnImploded;
      
      return isset($this->column);
   }
   
   public function setOrder($orderby, $order) {
      $this->orderby = $orderby;
      $this->order   = $order;
      return isset($this->orderby, $this->order);
   }
   
   public function setLimit($limitx, $limity) {
      $this->limitx = $limitx;
      $this->limity = $limity;
      return isset($this->limitx, $this->limity);
   }

   public function returnThe($what) {
      switch($what) {
         case "table": $ret = $this->table; break;
         case "column": $ret = $this->column; break;
         case "order": $ret = $this->order; break;
         case "orderby": $ret = $this->orderby; break;
         case "limitx": $ret = $this->limitx; break;
         case "limity": $ret = $this->limity; break;
         case "prepared": $ret = $this->prepared; break;
         default: $ret = FALSE;
      }
      return $ret;
   }
   
   public function real_escape_string($str) {
      return $this->link->real_escape_string($str);
   }
   
   // the following functions are used for generating prepared statements
   public function generateSelectAllWithLimit( ) {
      $queryString = " SELECT {$this->column} FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->prepare($queryString);
   }
   
   public function generateSelectSearchWithLimit($where, $strict = FALSE) {
      $searchMethod = ($strict) ? " {$where} = ? " : " {$where} LIKE ? ";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->prepare($queryString);
   }
   
   // the following functions will be deprecated 
   // because it will be replace by prepared statements
   public function whereSearchLike($where, $what, $strict = FALSE) {
      $searchMethod = ($strict) ? "{$where} = '{$what}'" : "{$where} LIKE '%{$what}%'";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->query($queryString);
   }
   
   public function insertInTable( ) {
      $values_arr = array( );
      $numargs = func_num_args( );
      $arg_list = func_get_args( );
      if(count($arg_list) > 1 || $numargs > 1) $values_arrImploded = implode(",", $arg_list);
      $values_string = $values_arrImploded;
      $queryString = " INSERT INTO {$this->table} ({$this->column}) VALUES ($values_string) ";
      return $this->link->query($queryString);
   }
   
   public function indexResult( ) {
      $queryString = " SELECT {$this->column} FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      if(isset($this->limitx, $this->limity)) $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      return $this->link->query($queryString);
   }
   
}

/**
 * Database connection using PDO
 */
class DBConnection_PDO extends DatabaseConnection {
   private $pdo_link;
   private $prepare_statements = array( );
   
   
   public function __construct( ) {
      try {
         $this->pdo_link = new PDO("mysql:dbname=".DB_DATABASE.";host=".DB_HOST, DB_USERNAME, DB_PASSWORD);
      } catch (PDOException $e) {
         die('Connection failed: ' . $e->getMessage( ));
      }
      $this->pdo_link->exec("SET CHARACTER SET ".DB_CHARSET);
      $this->generate_prepare_statements( );
      parent::__construct( );
   }
   
   public function __destruct( ) {
      $this->pdo_link = NULL;
      unset($this->prepare_statements);
      parent::__destruct( );
   }
   
   public function whereSearchLike($where, $what, $strict = FALSE) {
      // return an sql resource.
      return parent::whereSearchLike($where, $what, $strict);
   }

   public function insertInTable( ) {
      // return an sql resource.
      return parent::insertInTable( );
   }
   
   public function indexResult( ) {
      // return an sql resource.
      return parent::indexResult( );
   }
   
   public function generate_prepare_statements($mode = 0) {
      // possibility generate queries for selecting all rows
   }
   
   public function execute_statement($s) {
      return $this->prepare_statements[$s]->execute( );
   }
}

/**
 * Reading/writing files from/to directory
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

/**
 * Fetching/inputting contents from/to the database.
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
      switch(get_class($this)) {
         case "ManageContents": 
            $columnsExploded = explode(',', $this->contentDb->returnThe("column")); 
            break;
         case "ManageComments": 
            $columnsExploded = explode(',', $this->commentDb->returnThe("column")); 
            break;
      }
      foreach($columnsExploded as $column) $arrStringColumns .= "'{$column}' => \$row['{$column}'], ";
      $arrStringColumns = rtrim($arrStringColumns, ", ");
      //echo $arrStringColumns;
      while($row = $result->fetch_array( )) {
         eval("\$arr[] = array($arrStringColumns);");
      }
      return $arr;
   }
   
   
   public function commonStatementFetch($stmt){
      // Parameter array passed to 'bind_result()'
      $params = array( ); 
      $meta = $stmt->result_metadata( );
      while($field = $meta->fetch_field( )){
         $params[] = &$row[$field->name];
      }
      $res = call_user_func_array(array($stmt, 'bind_result'), $params);
      if($res){
         while($stmt->fetch( )){ 
            foreach($row as $key => $val){
               $c[$key] = $val; 
            }
            $result[] = $c; 
         }
      }
      else {
         // TODO: return error message.
      }
      
      if(empty($result)) {
         // TODO: generate error on no return
      }
      $stmt->close( );
      return @$result; // TODO: find alternate, don't supress error.
   }
   
   public function searchPost($id = 0, $strict = FALSE) {
      // if(!isset($_GET['s'], $_GET['id'])) return FALSE;

      if(isset($_GET['s'])) {
         $searchString = $this->contentDb->real_escape_string(htmlspecialchars($_GET['s'], ENT_QUOTES));
         if(!$strict) {
            $searchString = "%" . $searchString . "%";
         }
         $column = "Title";
      }
      else if($id) {
         $searchString = intval($id);
         $column = "id";      
      }
      
      $stmt = $this->contentDb->generateSelectSearchWithLimit($column);
      $stmt->bind_param('s', $searchString);
      $stmt->execute( );
      //$result = $this->contentDb->whereSearchLike($column, $searchString, $strict);
      //$arr = $this->commonArrayFetch($result);

      return $this->commonStatementFetch($stmt);
   }
   
   public function indexPosts( ) {
      $stmt = $this->contentDb->generateSelectAllWithLimit( );
      $stmt->execute( );
      return $this->commonStatementFetch($stmt);
   }
   
}

/**
 * Fetching/inputting comments from/to the database.
 */
class ManageComments extends ManageContents {
   protected $commentDb;
   protected $fb_portal;
   
   public function __construct($commentDb, $contentDb, $fb_portal) {
      $this->commentDb = $commentDb;
      $this->fb_portal = $fb_portal;
      $this->commentDb->setTable("comments");
      $this->commentDb->setColumn("Name", "content", "PostD", "ContentId", "IP");
      $this->commentDb->setOrder("PostD", "desc");
      $this->commentDb->setLimit(0, 5);
      // Since $contentDb already holds identifier to obj, its table, column, order, etc should already be set
      $this->contentDb = $contentDb;
   }
   
   public function getCommentsForContentId( ) {
      if(!isset($_GET['comment_contentid'])) return FALSE;
      $comment_contentid = intval($_GET['comment_contentid']);
      $result = $this->commentDb->whereSearchLike("ContentId", $comment_contentid, 1);
      $arr = $this->commonArrayFetch($result);
      return $arr;
   }
   
   public function insertCommentsInId( ) {
      // if(!isset($_POST['post_id'], $_POST['comment_name'], $_POST['comment_content'])) return FALSE;
      // if($_POST['post_id'] == NULL || $_POST['post_id'] == "" || $_POST['comment_name'] == NULL || $_POST['comment_name'] == "") return FALSE;
      $post_id          = intval($_POST['post_id']);
      $comment_name     = $this->fb_portal->user['me']['name'];
      $comment_content  = "'".$this->commentDb->real_escape_string(htmlspecialchars($_POST['comment_content'], ENT_QUOTES))."'";
      $comment_ip       = "'".$_SERVER['REMOTE_ADDR']."'";
      // if($this->checkSpamBlacklist($comment_name) || $this->checkSpamBlacklist($comment_content)) return FALSE;
      $result = $this->commentDb->insertInTable($comment_name, $comment_content, "NOW( )", $post_id, $comment_ip);
      $ret = ($result) ? TRUE : FALSE;
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
      unset($this->contentDb, $this->commentDb);
   }
   
   
}

/**
 * Only for displaying/echoing HTML/contents
 */
class Displayer {
   protected $contents;
   protected $fb_portal;
   public $unhideFirstPost;
   
   public function __construct($contents, $fb_portal) {
      $this->contents = $contents;
      $this->fb_portal = $fb_portal;
      $this->unhideFirstPost = "unhidden";
   }
   
   public function __destruct( ) {
      unset($this->contents, $this->unhideFirstPost);
   }
   
   public function displayPost($id, $title, $date, $content, $numofcomments) {
      echo "
         <a name='{$id}'></a>
		   <div class='post'>
			   <h1 class='title'><a href=\"javascript:unhide('id_{$id}');\">$title</a></h1>
			   <div id='id_{$id}' class='{$this->unhideFirstPost}'>
			      <p class='byline'><small>Posted on {$date}</small></p>
			      <div class='entry'>
               $content
			      </div>
			      <div class=\"meta\">
				      <p class=\"links\"><a href='#verytop'>Back to top</a> &nbsp;&bull;&nbsp; <a href=\"javascript:unhide('id_comment_{$id}');\" class='comments'>Submit Comment</a></p>
			      </div>
			      <div id='id_comment_{$id}' class='hidden'>
			         <form action=\"\" method='post'>
			         <input name='post_id' type='hidden' value='{$id}' />
			         <table>
			            <tr>";
                     if($this->fb_portal->status( )){
                        echo "
			               <th valign='top'>Your comment?</th>
			               <td><textarea name='comment_content' rows='7' cols='50'></textarea><br />
			               <input type='submit' value='Submit!' /></td>";
                     }
                     else{
                        echo "
                        <th valign='top'>Anon may not comment.</th>";
                     }
                     echo "
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

/**
 * Responsible for connecting to Facebook
 */
class FacebookPortal {
   protected $user = array( );
   protected $uid;
   protected $connection;
   protected $session;
   
   public function __construct( ){
      $this->connection = new Facebook(array(
               'appId'  => FACEBOOK_APPID,
               'secret' => FACEBOOK_SECRET,
               'cookie' => true,
      ));
      $this->session = $this->connection->getSession( );
      $this->user = null;
      if($this->session) {
        try {
          $this->uid = $this->connection->getUser( );
          $this->user['me']        = $this->connection->api('/me');
          /* TODO: try to find a way to optimize load time when using these
          $this->user['friends']   = $this->connection->api('/me/friends');
          $this->user['newsf']     = $this->connection->api('/me/home/');
          $this->user['wall']      = $this->connection->api('/me/feed');
          $this->user['likes']     = $this->connection->api('/me/likes');
          $this->user['movies']    = $this->connection->api('/me/movies');
          $this->user['music']     = $this->connection->api('/me/music');
          $this->user['books']     = $this->connection->api('/me/books');
          $this->user['notes']     = $this->connection->api('/me/notes');
          $this->user['photos']    = $this->connection->api('/me/photos');
          $this->user['albums']    = $this->connection->api('/me/albums');
          $this->user['videos']    = $this->connection->api('/me/videos');
          $this->user['vuploads']  = $this->connection->api('/me/videos/uploaded');
          $this->user['events']    = $this->connection->api('/me/events');
          $this->user['groups']    = $this->connection->api('/me/groups');
          */
        } catch (FacebookApiException $e) {
          error_log($e);
          //TODO: generate error.
        }
      }
   }
   
   public function status( ){
      return !!$this->user['me'];
   }
   
   public function url( ){
      return ($this->status( )) ? 
      $this->connection->getLogoutUrl( ) : $this->connection->getLoginUrl( );
   }
   
   public function out( ){
      echo "<ul>";
      if($this->status( )) {
         echo "<li>Welcome home, {$this->user['me']['last_name']}-sama!</li>";
         echo "<li><a href='{$this->url( )}'><img src=\"http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif\"></a></li>";
      }
      else {
         echo "<li>Hello anon, would you like to login?</li>";
         echo "<li><a href='{$this->url( )}'><img src=\"http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif\"></a></li>";
      }
      echo "</ul>";
   }
}



?>
