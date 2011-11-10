<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

define("INDEX", true);

session_start();
require_once './commonrequires.php';

Helper::fixMagicQuotes();
$indexTitle = SITE_TITLE;
$indexDesc = SITE_DESC;
$indexKeyw = SITE_KEYW;
$contentsPerPage = CONTENTS_PER_PG;
$jsOut = <<<END
var nextOffset = {$contentsPerPage};
var currentOffset = {$contentsPerPage};
END;

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
else if(array_key_exists('id', $requests)){
   $indexPosts = $mapper->Fetch('id', intval($requests['id']), true);
   if(count($indexPosts) > 0 || !empty($indexPosts)){
      $indexTitle = $indexPosts[0]->Title . " - " . $indexTitle;
      $indexDesc = htmlspecialchars(trim(strip_tags(substr($indexPosts[0]->content, 0, 150))), ENT_QUOTES) . '...';
      $indexKeyw = htmlspecialchars(Helper::generateMetaKeywords($indexPosts[0]->content), ENT_QUOTES);
   }
   $jsOut .= 'scrollLock = true;';
   $jsOut .= 'unhideLock = true;';
}
else {
   $indexPosts = $mapper->FetchAll(0, CONTENTS_PER_PG);
}

               
$indexEntries = $mapper->FetchColumn('id, Title', true);
$fetchedTags = $mapper->FetchColumn('Tags');
if(!empty($fetchedTags)){
   foreach($fetchedTags as $tag){
      !empty($tag->Tags) && $arrTags[] = $tag->Tags;
   }
}
$indexTags = Helper::tagsToHTMLExt($arrTags);



include './_template/default.php';

?>
