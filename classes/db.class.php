<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: N/A          *
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
      if(count($arg_list) > 1 || $numargs > 1) {
         $columnImploded = implode(",", $arg_list);
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
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity)) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      return $this->link->prepare($queryString);
   }
   
   public function generateSelectSearchWithLimit($where, $strict = FALSE) {
      $searchMethod = ($strict) ? " {$where} = ? " : " {$where} LIKE ? ";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity)) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      return $this->link->prepare($queryString);
   }
   
   public function doQry($query) {
      return $this->link->query($query);
   }
   
   // the following functions will be deprecated 
   // because it will be replace by prepared statements
   public function whereSearchLike($where, $what, $strict = FALSE) {
      $searchMethod = ($strict) ? "{$where} = '{$what}'" : "{$where} LIKE '%{$what}%'";
      $queryString = " SELECT {$this->column} FROM {$this->table} WHERE $searchMethod ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity)) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      return $this->link->query($queryString);
   }
   
   public function insertInTable( ) {
      $values_arr = array( );
      $numargs = func_num_args( );
      $arg_list = func_get_args( );
      if(count($arg_list) > 1 || $numargs > 1) {
         $values_arrImploded = implode(",", $arg_list);
      }
      $values_string = $values_arrImploded;
      $queryString = " INSERT INTO {$this->table} ({$this->column}) VALUES ($values_string) ";
      return $this->link->query($queryString);
   }
   
   public function indexResult( ) {
      $queryString = " SELECT {$this->column} FROM {$this->table} ";
      if(isset($this->orderby, $this->order)) {
         $queryString .= " ORDER BY {$this->orderby} {$this->order} ";
      }
      if(isset($this->limitx, $this->limity)) {
         $queryString .= " LIMIT {$this->limitx}, {$this->limity} ";
      }
      return $this->link->query($queryString);
   }
   
}

?>