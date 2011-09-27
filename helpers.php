<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Sep 22, 2011 *
 * Last Updated: Sep 22, 2011 *
 ******************************/

class Helper{
   public static function titleToHTMLExt($id, $title){
      $urlTitle = trim($title);
      $urlTitle = preg_replace('/ /', '-', $urlTitle);
      $urlTitle = preg_replace('/[^\w|^-]/', '', $urlTitle);
      return $urlTitle . '-' . $id . '.html';
   }

   public static function fixMagicQuotes(){
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

   public static function tagsToHTMLExt($arr){
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
   
   public static function generateMetaKeywords($str){
      $str = trim(strip_tags($str));
      $wordsCSV = preg_replace('/[^\w|^ ]/', "", $str);
      $wordsCSV = explode(" ", $wordsCSV);
      
      $metaKeywords = array();
      $i = 0;
      foreach($wordsCSV as $one){
         if(!Helper::isCommonWord($one)){
            $metaKeywords[] = $one;
            $i++;
            if($i >= 30){
               break;;
            }
         }
      }
      return implode(',', $metaKeywords);
   }
   public static function isCommonWord($str){
      $ret = false;
      $list = explode(',', 'another,one,those,thing,a,able,about,across,after,all,almost,also,am,among,an,and,any,are,as,at,be,because,been,but,by,can,cannot,could,dear,did,do,does,either,else,ever,every,for,from,get,got,had,has,have,he,her,hers,him,his,how,however,i,if,in,into,is,it,its,just,least,let,like,likely,may,me,might,most,must,my,neither,no,nor,not,of,off,often,on,only,or,other,our,own,rather,said,say,says,she,should,since,so,some,than,that,the,their,them,then,there,these,they,this,tis,to,too,twas,us,wants,was,we,were,what,when,where,which,while,who,whom,why,will,with,would,yet,you,your');
      foreach($list as $commonWord){
         if(strtolower($str) == strtolower($commonWord)){
            $ret = true;
         }
      }
      return $ret;
   }
   public static function formatDate($datetime){
      $datetime = explode(" ", $datetime);
      $date = explode("-", $datetime[0]);
      $time = explode(":", $datetime[1]);
      return date('l jS \of F Y h:i:s A', mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]));
   }
   // TODO: finish paging
   public static function paging($currPage, $maxPages){
      
   }
}
?>