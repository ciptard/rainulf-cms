<?php
require_once 'conf.php';

function get(&$obj, $limit = true, $num = 0, $str1 = "", $str2 = ""){
   $link = conndb();
   if(is_array($obj) && is_numeric($num)){
      if($limit && empty($str1)){
         $stmt = $link->prepare("SELECT * FROM contents ORDER BY PostD DESC LIMIT {$num}, " . CONTENTS_PER_PG);
         $stmt->execute();
         $stmt->bind_result($resID, $resTitle, $resContent, $resPostD, $resTags, $resCats);
         while($stmt->fetch()){
            $obj[] = new BlogPost($resID, $resTitle, $resContent, $resPostD, $resTags);
         }
      }
      else if($limit && !empty($str1) && empty($str2)){
         $stmt = $link->prepare("SELECT {$str1} FROM contents ORDER BY PostD DESC LIMIT {$num}, " . CONTENTS_PER_PG);
         $stmt->execute();
         $stmt->bind_result($resID, $resTitle);
         while($stmt->fetch()){
            $obj[] = new BlogPost($resID, $resTitle);
         }
      }
      else if($limit && !empty($str1) && !empty($str2)){
         $stmt = $link->prepare("SELECT * FROM contents WHERE {$str1} LIKE '%{$str2}%' ORDER BY PostD DESC LIMIT {$num}, " . CONTENTS_PER_PG);
         $stmt->execute();
         $stmt->bind_result($resID, $resTitle, $resContent, $resPostD, $resTags, $resCats);
         while($stmt->fetch()){
            $obj[] = new BlogPost($resID, $resTitle, $resContent, $resPostD, $resTags);
         }
      }
      else if(!$limit && !empty($str1)){
         $stmt = $link->prepare("SELECT {$str1} FROM contents");
         $stmt->execute();
         $stmt->bind_result($resTags);
         while($stmt->fetch()){
            $obj[] = new BlogPost("", "", "", "", $resTags);
         }
      }
   }
   else if(get_class($obj) == "BlogPost" && is_numeric($num)){
      $stmt = $link->prepare("SELECT * FROM contents WHERE id = ?");
      $stmt->bind_param('i', $num);
      $stmt->execute();
      $stmt->bind_result($resID, $resTitle, $resContent, $resPostD, $resTags, $resCats);
      $stmt->fetch();
      $obj->setID($resID);
      $obj->setTitle($resTitle);
      $obj->setContent($resContent);
      $obj->setDate($resPostD);
      $obj->setTags($resTags);
   }
   $link->close();
}

function replace($a, $b = null){
   $link = conndb();
   
   $link->close();
}

function delete($a, $b = null){
   $link = conndb();
   
   $link->close();
}

function insert($a){
   $link = conndb();
   
   $link->close();
}

function conndb(){
   $link = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD) or die($link->error);
   $link->set_charset(DB_CHARSET) or die($link->error);
   $link->select_db(DB_DATABASE) or die($link->error);
   return $link;
}
?>