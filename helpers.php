<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Sep 22, 2011 *
 * Last Updated: Sep 22, 2011 *
 ******************************/

function titleToHTMLExt($id, $title){
   $urlTitle = trim($title);
   $urlTitle = preg_replace("/ /", "-", $urlTitle);
   $urlTitle = preg_replace("/[^\w|^-]/", "", $urlTitle);
   return $urlTitle . '-' . $id . '.html';
}

function fixMagicQuotes(){
   if (get_magic_quotes_gpc()) {
      function stripslashes_deep($value) {
         $value = is_array($value) ?
         array_map('stripslashes_deep', $value) :
         stripslashes($value);
         return $value;
      }
      $_POST = array_map('stripslashes_deep', $_POST);
      $_GET = array_map('stripslashes_deep', $_GET);
      $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
      $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
   }
}

function paging($currPage){
   
}

function tagsToHTMLExt($arr){
   $tagsCount = array();
   $tagsInfo = array();
   
   foreach($arr as $tags){
      if(strpos($tags, ',')){
         $arrTags = explode(',', $tags);
         foreach($arrTags as $tag){
            $tag = trim($tag);
            if(!empty($tag)){
               if(!array_key_exists($tag, $tagsCount)){
                  $tagsCount[$tag] = 1;
               } else {
                  $tagsCount[$tag]++;
               }
            }
         }
      } else {
         if(!empty($tags)){
            if(!array_key_exists($tags, $tagsCount)){
               $tagsCount[$tags] = 1;
            } else {
               $tagsCount[$tags]++;
            }
         }
      }
   }
   while($tagName = current($tagsCount)){
      $tagsInfo[] = array('name' => key($tagsCount),
                         'count' => $tagName);
      next($tagsCount);
   }
   return $tagsInfo;
}
?>