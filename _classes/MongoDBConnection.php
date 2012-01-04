<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Contains method for selecting/inserting from/to tables in MongoDB
 * @author Rainulf Pineda <rainulf@rainulf.ca>
 */
class MongoDBConnection extends DatabaseConnection{

   protected $link;
   protected $db;
   protected $collection;
   
   public function __construct(){
      try{
         $this->link = new Mongo();
         if($this->link){
            $this->db = $this->link->selectDB(DB_DATABASE);
         }
      } catch(MongoConnectionException $e){
         die('Cannot connect to Mongo: ' . $e->getMessage());
      } catch(InvalidArgumentException $e){
         die('Cannot select DB: ' . $e->getMessage());
      }
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
    * Sets the class' $table
    * @param $tableName table or collection name to be used throughout the class
    * @return isset; true or false
    */
   public function setTable($tableName){
      $this->table = $tableName;
      try{
         $this->collection = $this->db->selectCollection($this->table);
      } catch(InvalidArgumentException $e){
         die('Cannot select collection: ' . $e->getMessage());
      }
      return isset($this->table);
   }
   /**
    * Returns all rows from the current table/collection
    * @param $isLimited the rows returned are limited; true by default
    * @return all rows from the current table/collection
    */
   public function SelectAll($isLimited = true){
      if(isset($this->limitx, $this->limity) && $isLimited){
      
      } else {
      
      }
   }
   /**
    * Returns all rows based from $where and $var
    * @param $where column to search from, $varType type of var, $var contains data to be search, 
    *        $isStrict to search with match case or not; false by default, $isLimited the rows returned are limited; true by default
    * @return all rows based from $where and $var
    */
   public function Search($where, $varType, $var, $isStrict = false, $isLimited = false){
      $filter = array($var => $where);
      $res = $this->collection->find($filter);
      return $res;
   }
   /**
    * Returns the number of rows from the current table/collection
    * @return the number of rows from the current table/collection
    */
   public function GetNumRows(){
   
   }
   public function setCollection($collection){
      $this->setTable($collection);
   }
   public function insertData($data, $searchData){
      $res = $this->searchData($searchData);
      $resCount = $res->count();
      if($resCount <= 0){
         $this->collection->insert($data, true);
      } else {
         return $res;
      }
      return $this->searchData($searchData);
   }
   public function searchData($data){
      return $this->collection->find($data);
   }
}
