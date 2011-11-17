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
$mysqlMapper = new ContentsModelMapper();
$mysqlMapper->SetOrder('PostD', 'DESC');
$mongodb = new MongoDBConnection();
$mongodb->setCollection('urlredirector');
$mongodb->setOrder('VisitDate', 'DESC');

$requests = Helper::getRequests();
             
$indexEntries = $mysqlMapper->FetchColumn('id, Title', true);
$fetchedTags = $mysqlMapper->FetchColumn('Tags');
if(!empty($fetchedTags)){
   foreach($fetchedTags as $tag){
      !empty($tag->Tags) && $arrTags[] = $tag->Tags;
   }
}
$indexTags = Helper::tagsToHTMLExt($arrTags);

if(isset($requests['url']) && Helper::isValidURL($requests['url'])){
   $url = $requests['url'];
   $randomStr = Helper::randomStrings();
   $data = array(
      'locId' => $randomStr,
      'url' => $url
   );
   $searchData = array('url' => $url);
   $stuff = $mongodb->insertData($data, $searchData);
   if($stuff->count() > 0){
      $stuff->next();
      $stuff = $stuff->current();
      $shortUrl = SITE_URL . 'r/to/' . $stuff['locId'];
   }
}
else if(isset($requests['to'])){
   $searchData = array('locId' => $requests['to']);
   $stuff = $mongodb->searchData($searchData);
   if($stuff->count() > 0){
      $stuff->next();
      $stuff = $stuff->current();
      header('Location: ' . $stuff['url']);
   }
}


include '../_template/r.php';
?>
