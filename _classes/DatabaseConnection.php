<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: Sep 11, 2011 *
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
   
   private function ProcessStatement($stmt){
      $params = array( ); 
      $meta = $stmt->result_metadata( );
      while($field = $meta->fetch_field( )){
         $params[] = &$row[$field->name];
      }
      $response = call_user_func_array(array($stmt, 'bind_result'), $params);
      if($response){
         while($stmt->fetch( )){ 
            foreach($row as $key => $val){
               $c[$key] = $val; 
            }
            $result[] = $c; 
         }
      } else {
         return array();
      }
      if(empty($result)){
         return array();
      }
      $stmt->close( );
      
      return $result;
   }
   
   public function __construct($host = DB_HOST, $username = DB_USERNAME, $password = DB_PASSWORD, $database = DB_DATABASE, $charset = DB_CHARSET) {
      $this->link = new mysqli($host, $username, $password);
      if(!$this->link){
         throw new Exception("new mysqli: " . $this->link->error);
      }
      $res = $this->link->set_charset($charset);
      if(!$res){
         throw new Exception("set_charset: " . $this->link->error);
      }
      $res = $this->link->select_db($database);
      if(!$res){
         throw new Exception("select_db: " . $this->link->error);
      }
         
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
      if(count($arg_list) > 1 || $numargs > 1) {
         $columnImploded = implode(",", $arg_list);
      }
      else if($numargs == 1 || count($arg_list)){
         $columnImploded = $arg_list[0];
      } else {
         return false;
      }
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
         default: $ret = false;
      }
      return $ret;
   }
   
   public function real_escape_string($str) {
      return $this->link->real_escape_string($str);
   }
   
   public function SelectAll($isLimited = true) {
      $queryString = " SELECT {$this->column} FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity) && $isLimited) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      $stmt = $this->link->prepare($queryString);
      $stmt->execute();
      return $this->ProcessStatement($stmt);
   }
   
   public function Search($where, $varType, $var, $isStrict = false, $isLimited = true) {
      $searchMethod = ($isStrict) ? " {$where} = ? " : " {$where} LIKE ? ";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity) && $isLimited) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      $stmt = $this->link->prepare($queryString);
      $stmt->bind_param($varType, $var);
      $stmt->execute();
      return $this->ProcessStatement($stmt);
   }
   
   public function SelectColumn($col, $isLimited = false){
      $queryString = " SELECT $col FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity) && $isLimited) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      $stmt = $this->link->prepare($queryString);
      $stmt->execute();
      return $this->ProcessStatement($stmt);
   }
   
   public function RunQuery($query) {
      $ret = empty($query) ? false : $this->link->query($query);
      return $ret;
   }
   
   public function GetNumRows(){
      $result = $this->RunQuery("SELECT COUNT(*) FROM {$this->table}");
      $total = $result->fetch_array(MYSQLI_NUM);
      return $total[0];
   }
   
}

?>