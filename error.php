<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 05, 2011 *
 * Last Updated: Oct 05, 2011 *
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

$requests = Helper::getRequests();
$errorId = isset($requests['id']) ? intval($requests['id']) : 0;

switch($errorId){
   case 400: 
      $errorTitle = "Bad Request"; 
      $errorHeader = "Bad Request";
      break;
   case 403: 
      $errorTitle = "Forbidden"; 
      $errorHeader = "Forbidden";
      break;
   case 404: 
      $errorTitle = "Page Not Found"; 
      $errorHeader = "Page Not Found";
      $errorImg = "./_images/PageNotFound.gif";
      $errorImgAlt = "notfound";
      break;
   case 500: 
      $errorTitle = "Internal Server Error"; 
      $errorHeader = "Internal Server Error";
      break;
   default: 
      $errorTitle = "Unknown Error";
      $errorHeader = "Unknown Error";
}

$indexTitle = $errorTitle . " - " . $indexTitle;


$mapper = new ContentsModelMapper();
$mapper->SetOrder('PostD', 'DESC');

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


include './_template/error.php';
?>