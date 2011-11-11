<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Contains method for selecting/inserting from/to tables in mySQL
 * @author Rainulf Pineda <rainulf@rainulf.ca>
 */
class MySQLConnection extends DatabaseConnection{

   protected $link;                // Database link
   protected $column;              // Columns to be used
   
   /**
    * Puts the values of a prepared statement in a neat assoc array
    * @param $stmt a prepared statement
    * @return assoc array version of a prepared statement
    */
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
   /**
    * MySQLConnection constructor; default params from the conf.php file
    */
   public function __construct($host = DB_HOST, $username = DB_USERNAME, $password = DB_PASSWORD, $database = DB_DATABASE, $charset = DB_CHARSET) {
      $this->link = new mysqli($host, $username, $password);
      if(!$this->link){
         throw new Exception("new mysqli: " . $this->link->error);
      } else {
         $res = $this->link->set_charset($charset);
      }
      if(!$res){
         throw new Exception("set_charset: " . $this->link->error);
      } else {
         $res = $this->link->select_db($database);
      }
      if(!$res){
         throw new Exception("select_db: " . $this->link->error);
      }
         
   }
   /**
    * MySQLConnection destructor; closes mySQL connection and unsets the object's variables
    */
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
   /**
    * Sets the object's $table/collection
    * @param $tableName table name to be used throughout the object
    * @return isset; true or false
    */
   public function setTable($tableName) { 
      $this->table = $tableName; 
      return isset($this->table);
   }
   /**
    * Sets columns to be used throughout the object
    * @return isset; true or false
    */
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
   /**
    * Sets the order of the returns from DB
    * @param $orderby column of order, $order acs or desc
    * @return isset; true or false
    */
   public function setOrder($orderby, $order) {
      $this->orderby = $orderby;
      $this->order   = $order;
      return isset($this->orderby, $this->order);
   }
   /**
    * Sets the limit of the returns from DB
    * @param $limitx offset, $limity num of rows
    * @return isset; true or false
    */
   public function setLimit($limitx, $limity) {
      $this->limitx = $limitx;
      $this->limity = $limity;
      return isset($this->limitx, $this->limity);
   }
   /**
    * Returns the value of a variable in the object
    * @param @what what to return
    * @return value of a variable in the object
    */
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
   /**
    * Use mySQL object's real_escape_string() function
    * @param to be use for real_escape_string()
    * @return whatever real_escape_string() returns
    */
   public function real_escape_string($str) {
      return $this->link->real_escape_string($str);
   }
   /**
    * Returns all rows from the current table
    * @param $isLimited the rows returned are limited; true by default
    * @return all rows from the current table
    */
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
   /**
    * Returns all rows based from $where and $var
    * @param $where column to search from, $varType type of var, $var contains data to be search, 
    *        $isStrict to search with match case or not; false by default, $isLimited the rows returned are limited; true by default
    * @return all rows based from $where and $var
    */
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
   /**
    * Returns the number of rows from the current table/collection
    * @return the number of rows from the current table/collection
    */
   public function GetNumRows(){
      $result = $this->RunQuery("SELECT COUNT(*) FROM {$this->table}");
      $total = $result->fetch_array(MYSQLI_NUM);
      return $total[0];
   }
}
?>
