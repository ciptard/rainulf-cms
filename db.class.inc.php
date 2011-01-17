<?php
/*
   Database connection.
   Contains method for selecting/inserting from/to tables.
   Author: Rainulf Pineda
*/

class DBConnection {
   private $link;
   
   public function __construct( ) {
      require_once "./config.inc.php";
      $this->link = new mysqli(DBHOST, DBUSER, DBPASS) or die("Cannot connect to DB: " . $this->link->error);
      $this->link->set_charset(DBCHSET) or die("Cannot select charset: " . $this->link->error);
      $this->link->select_db(DBNAME) or die("Cannot select database: " . $this->link->error);
   }
   
   public function __destruct( ) {
      @$this->link->close( );
   }
}
?>
