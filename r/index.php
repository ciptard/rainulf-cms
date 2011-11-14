<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

define("INDEX", true);

require_once '../commonrequires.php';

Helper::fixMagicQuotes();
$indexTitle = 'URL Redirector - ' . SITE_TITLE;
$indexDesc = 'Rainulf\'s personal URL redirector. You are free to use it as well! =)';
$indexKeyw = 'rainulf pineda, rainulf, url redirect, url redirector, url, rainulf.ca';
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
   $jsOut .= 'scrollLock = true;';
}              
$indexEntries = $mapper->FetchColumn('id, Title', true);
$fetchedTags = $mapper->FetchColumn('Tags');
if(!empty($fetchedTags)){
   foreach($fetchedTags as $tag){
      !empty($tag->Tags) && $arrTags[] = $tag->Tags;
   }
}
$indexTags = Helper::tagsToHTMLExt($arrTags);


include '../_template/r.php';
?>
