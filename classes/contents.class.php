<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: N/A          *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Fetching/inputting contents from/to the database.
 */
class ManageContents {
   protected $contentDb;
   protected $totalContents;
   
   public function __construct($database) {
      $this->contentDb = $database;
      $this->contentDb->setTable("contents");
      $this->contentDb->setColumn("id", "Title", "content", "PostD", "Tags");
      $this->contentDb->setOrder("PostD", "desc");
      $this->contentDb->setLimit(0, CONTENTS_PER_PG);
      $result = $this->contentDb->doQry('SELECT * FROM contents');
      $this->totalContents = $result->num_rows;
   }
   
   public function __destruct( ) {
      unset($this->contentDb);
   }
   
   public function returnTotalContents( ) {
      return $this->totalContents;
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
      foreach($columnsExploded as $column) {
         $arrStringColumns .= "'{$column}' => \$row['{$column}'], ";
      }
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

      if(isset($_GET['search_bar'])) {
         $searchString = htmlspecialchars($_GET['search_bar'], ENT_QUOTES);
         $searchString = $this->contentDb->real_escape_string($searchString);
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
   
   // TODO: make multiple tags work
   public function searchTags($tag = null){
      $ret = null;
      if($tag != null){
         $tag = htmlspecialchars($tag, ENT_QUOTES);
         $tag = $this->contentDb->real_escape_string($tag);
         $stmt = $this->contentDb->generateSelectSearchWithLimit("Tags", true);
         $stmt->bind_param('s', $tag);
         $stmt->execute( );
         $ret = $this->commonStatementFetch($stmt);
      }
      return $ret;
   }
   
   public function indexPosts( ) {
      $stmt = $this->contentDb->generateSelectAllWithLimit( );
      $stmt->execute( );
      return $this->commonStatementFetch($stmt);
   }
   
   public function paging($page) {
      //$pg = $_GET['page'];
      $tempOffset = $page * CONTENTS_PER_PG;
      $offset = ($tempOffset > CONTENTS_PER_PG) ? ceil($tempOffset - CONTENTS_PER_PG) : 0;
      $res = $this->contentDb->setLimit($offset, CONTENTS_PER_PG);
      if(!$res){
         // TODO: print error
      }
      return $res;
   }
   
}

?>