<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 19, 2010 *
 * Last Updated: Sep 22, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

error_reporting(-1);
session_start( );
date_default_timezone_set('America/Toronto');
require_once './conf.php';
require_once './helpers.php';
require_once './_classes/DatabaseConnection.php';
require_once './_classes/ContentsModel.php';
require_once './_classes/ContentsModelMapper.php';

fixMagicQuotes();
$indexTitle = SITE_TITLE;

/**
 * Mapper creation and REQUEST grabbing
 */
$mapper = new ContentsModelMapper();
$mapper->SetOrder('PostD', 'DESC');

if(isset($_GET['tags'])){
   $indexPosts = $mapper->Fetch('Tags', '%'.strip_tags(htmlspecialchars($_GET['tags'])).'%');
   $indexTitle = "Tag: " . strip_tags(htmlspecialchars($_GET['tags'])) . " - " . $indexTitle;
}
else if(isset($_GET['id'])){
   $indexPosts = $mapper->Fetch('id', intval($_GET['id']), true);
   $indexTitle = $indexPosts[0]->Title . " - " . $indexTitle;
}
else {
   // TODO: Paging
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
$indexTags = tagsToHTMLExt($arrTags);




?>
