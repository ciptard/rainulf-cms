<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 19, 2010 *
 * Last Updated: Mar 10, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

error_reporting(-1);
session_start( );
ob_start( );
date_default_timezone_set("GMT");
require_once './conf.inc.php';
require_once './social_connect/facebook/facebook.inc.php';
require_once './social_connect/twitter/twitteroauth.php';
require_once './classes/db.class.php';
require_once './classes/files.class.php';
require_once './classes/contents.class.php';
require_once './classes/comments.class.php';
require_once './classes/displayer.class.php';
require_once './classes/socialconnect.class.php';
/**
 * Object creation
 */
 
// $user, $pass, $db, $host = "localhost", $charset = "utf8"
// NOTE: objects that are passed hold a copy of the identifier, which points to the same object. Therefore, we need to instantiate another one for comments.
// REF:  http://php.net/manual/en/language.oop5.references.php

// DB objs
$contentDb = new DatabaseConnection( );
$commentDb = new DatabaseConnection( );

// Social Connect objs
$fb_portal = new FacebookPortal( );
$sc_portal = new SenecaPortal( );
$social    = new SocialConnect($fb_portal, $sc_portal);

// Content objs
$contents  = new ManageContents($contentDb);
$comments  = new ManageComments($commentDb, $contentDb); // inherit - extends 'ManageContents'
$display   = new Displayer($contents, $comments);
$files     = new ManageFiles("./source_codes/");


/**
 * Fixed annoying magic quotes.
 */
if (get_magic_quotes_gpc( )) {
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


/**
 * init variables and function calls
 */
// Social Connect authentication
if($social->status( )) {
   $_SESSION['loggedin'] = 1;
}
if(isset($_SESSION['loggedin'], $_GET['logout'])) {
   unset($_SESSION['loggedin']);
   unset($_SESSION['name']);
   header("Location: . ");
}
// SenecaPortal
if(isset($_POST['username'], $_POST['password'])) {
   $username = $_POST['username'];
   $password = $_POST['password'];
   if($social->check($username, $password)) {
      $_SESSION['loggedin'] = 1;
   }
}
// getting ID
$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
// List the Latest Entries
$indexlist  = $contents->indexPosts( );
// List the Latest Source Codes
$source_codes = $files->scanFolder(1);
// Call method for paging
// NOTE: List must be called first so it won't get affected by paging
//       because list and content share the same resources.
if(isset($_GET['page']) && !isset($_GET['id'])) {
   $page = intval($_GET['page']);
   $contents->paging($page);
}
else {
   $page = 1;
}
// Call the default searchPost( ) if $_GET['search_bar'] is set.
if(isset($_GET['search_bar'])) {
   $indexposts = $contents->searchPost( );
}
// Otherwise, if $id is true, call searchPost($id). If $id is 0, call indexPosts( )
else {
   $indexposts = ($id) ? $contents->searchPost($id, TRUE) : $contents->indexPosts( );
}
if(isset($_GET['tags'])) {
   $indexposts = $contents->searchTags($_GET['tags']);
}
// Call RSS feed
if(isset($_GET['rss'])) {
   // TODO: create RSS.
}
// Call comment methods if equal to comments.
if(isset($_GET['comment_contentid'])) {
   $comment_contents = $comments->getCommentsForContentId( );
}
// Call common methods for inserting comments.
if(isset($_POST['post_id'], $_POST['comment_content'])) {
   $comments->insertCommentsInId( );
}
?>
