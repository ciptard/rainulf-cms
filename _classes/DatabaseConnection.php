<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Abstract class, Database connection.
 */
abstract class DatabaseConnection {
   protected $order;               // Column should be ordered by
   protected $orderby;             // Desc or Asc?
   protected $limitx;              // LIMIT start
   protected $limity;              // LIMIT end
   
   abstract public function setOrder($orderby, $order);
   abstract public function setLimit($limitx, $limity);
   abstract public function SelectAll($isLimited = true);
   abstract public function Search($where, $varType, $var, $isStrict = false, $isLimited = false);
   abstract public function GetNumRows();
}

?>
