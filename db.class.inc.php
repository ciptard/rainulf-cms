<?php
/*
   Database connection.
   Contains method for selecting/inserting from/to tables.
   Author: Rainulf Pineda
*/

class DBConnection {
   private $pdo_link;
   private $prepare_statements = array( );
   
   public function __construct( ) {
      require_once "./config.inc.php";
      try {
         $this->pdo_link = new PDO("mysql:dbname=" . DBNAME . ";host=" . DBHOST, DBUSER, DBPASS);
      } catch (PDOException $e) {
         die('Connection failed: ' . $e->getMessage( ));
      }
      $this->generate_prepare_statements( );
   }
   
   public function __destruct( ) {
      $this->pdo_link = NULL;
      unset($this->prepare_statements);
   }
   
   public function generate_prepare_statements( ) {
      $this->prepare_statements['allcontents'] = $this->pdo_link->prepare("SELECT * FROM contents");
      $this->prepare_statements['allcomments'] = $this->pdo_link->prepare("SELECT * FROM comments");
      $this->prepare_statements['allcategories'] = $this->pdo_link->prepare("SELECT * FROM categories");
   }
   
   public function execute_statement($s) {
      return $this->prepare_statements[$s]->execute( );
   }
}
?>
