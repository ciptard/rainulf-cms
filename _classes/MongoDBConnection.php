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
   public function setTable($tableName){
      $this->table = $tableName;
      try{
         $this->collection = $this->db->selectCollection($this->table);
      } catch(InvalidArgumentException $e){
         die('Cannot select collection: ' . $e->getMessage());
      }
   }
   public function setCollection($collection){
      $this->setTable($collection);
   }
   public function SelectAll($isLimited = true){
      if(isset($this->limitx, $this->limity) && $isLimited){
      
      } else {
      
      }
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
   public function Search($where, $varType, $var, $isStrict = false, $isLimited = false){
      $filter = array($var => $where);
      $res = $this->collection->find($filter);
      return $res;
   }
   public function GetNumRows(){
   
   }
}
