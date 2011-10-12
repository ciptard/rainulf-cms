<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Sep 26, 2011 *
 * Last Updated: Sep 26, 2011 *
 ******************************/

define("INDEX", true);

error_reporting(-1);
session_start();
date_default_timezone_set('America/Toronto');
require_once './conf.php';
require_once './helpers.php';
require_once './_classes/DatabaseConnection.php';
require_once './_classes/ContentsModel.php';
require_once './_classes/ContentsModelMapper.php';

Helper::fixMagicQuotes();
$indexTitle = SITE_TITLE;
$indexDesc = SITE_DESC;
$indexKeyw = SITE_KEYW;
$jsOut = '';

/**
 * Mapper creation and REQUEST grabbing
 */
$mapper = new ContentsModelMapper();
$mapper->SetOrder('PostD', 'DESC');

$requests = Helper::getRequests();
if(array_key_exists('tags', $requests)){
   $indexPosts = $mapper->Fetch('Tags', '%'.$requests['tags'].'%');
   $indexTitle = "Tag: " . $requests['tags'] . " - " . $indexTitle;   
   $jsOut = 'scrollLock = true;';
}
else if(array_key_exists('id', $requests)){
   $indexPosts = $mapper->Fetch('id', intval($requests['id']), true);
   if(count($indexPosts) > 0 || !empty($indexPosts)){
      $indexTitle = $indexPosts[0]->Title . " - " . $indexTitle;
      $indexDesc = htmlspecialchars(trim(strip_tags(substr($indexPosts[0]->content, 0, 150))), ENT_QUOTES) . '...';
      $indexKeyw = htmlspecialchars(Helper::generateMetaKeywords($indexPosts[0]->content), ENT_QUOTES);
   }
   $jsOut = 'scrollLock = true;';
   $jsOut .= 'unhideLock = true';
}
else {
   $indexPosts = $mapper->FetchAll(0, CONTENTS_PER_PG);
}
               
if(!$mapper->IsEmpty()){
   $mapper->EmptyModelList();
}
$indexEntries = $mapper->FetchColumn('id, Title', true);
if(!$mapper->IsEmpty()){
   $mapper->EmptyModelList();
}
$fetchedTags = $mapper->FetchColumn('Tags');
foreach($fetchedTags as $tag){
   if(!empty($tag->Tags)){
      $arrTags[] = $tag->Tags;
   }
}
$indexTags = Helper::tagsToHTMLExt($arrTags);



include './_template/default.php';

?>
