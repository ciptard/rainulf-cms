<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Abstract class, Database connection
 * @author Rainulf Pineda <rainulf@rainulf.ca>
 */
abstract class DatabaseConnection {
   protected $order;               // Column should be ordered by
   protected $orderby;             // Desc or Asc?
   protected $limitx;              // LIMIT start
   protected $limity;              // LIMIT end
   protected $table;               // Table name
   
   /**
    * Sets the class' $table/collection
    * @param $tableName table or collection name to be used throughout the class
    * @return isset; true or false
    */
   abstract public function setTable($tableName);
   /**
    * Sets the order of the returns from DB
    * @param $orderby column of order, $order acs or desc
    * @return isset; true or false
    */
   abstract public function setOrder($orderby, $order);
   /**
    * Sets the limit of the returns from DB
    * @param $limitx offset, $limity num of rows
    * @return isset; true or false
    */
   abstract public function setLimit($limitx, $limity);
   /**
    * Returns all rows from the current table/collection
    * @param $isLimited the rows returned are limited; true by default
    * @return all rows from the current table/collection
    */
   abstract public function SelectAll($isLimited = true);
   /**
    * Returns all rows based from $where and $var
    * @param $where column to search from, $varType type of var, $var contains data to be search, 
    *        $isStrict to search with match case or not; false by default, $isLimited the rows returned are limited; true by default
    * @return all rows based from $where and $var
    */
   abstract public function Search($where, $varType, $var, $isStrict = false, $isLimited = false);
   /**
    * Returns the number of rows from the current table/collection
    * @return the number of rows from the current table/collection
    */
   abstract public function GetNumRows();
}

?>
