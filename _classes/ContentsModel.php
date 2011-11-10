<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");
    
final class ContentsModel{
   public $id;
   public $Title;
   public $content;
   public $PostD;
   public $Tags;
   public function __construct($id = "",$Title = "",$content = "",$PostD = "",$Tags = ""){
      $this->id = $id;
      $this->Title = $Title;
      $this->content = $content;
      $this->PostD = $PostD;
      $this->Tags = $Tags;
   }
}
?>
