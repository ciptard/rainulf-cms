<?php

class BlogPost{
   private $postID;
   private $postTitle;
   private $postContent;
   private $postDate;
   private $postTags;
   
   public function __construct($id = "", $title = "", $content = "", $date = "", $tags = ""){
      $this->postID = $id;
      $this->postTitle = $title;
      $this->postContent = $content;
      $this->postDate = $date;
      $this->postTags = $tags;
   }
   public function getID(){
      return $this->postID;
   }
   public function getTitle(){
      return $this->postTitle;
   }
   public function getContent(){
      return $this->postContent;
   }
   public function getDate(){
      return $this->postDate;
   }
   public function getTags(){
      return $this->postTags;
   }
   public function setID($x){
      $this->postID = $x;
      return $this;
   }
   public function setTitle($x){
      $this->postTitle = $x;
      return $this;
   }
   public function setContent($x){
      $this->postContent = $x;
      return $this;
   }
   public function setDate($x){
      $this->postDate = $x;
      return $this;
   }
   public function setTags($x){
      $this->postTags = $x;
      return $this;
   }
   public function getFromDB(){
      if(!empty($this->postID) && is_numeric($this->postID)){
         get($this, true, $this->postID);
      }
   }

}
?>