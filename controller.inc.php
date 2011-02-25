<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 19, 2010 *
 * Last Updated: Feb 11, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

/******************************
 * INCLUDES AND SETS
 ******************************/
 
/**
 * set to report ALL errors
 */
error_reporting(-1);
/**
 * include conf (required)
 */
require_once './conf.inc.php';
/**
 * include helper functions (required)
 */
require_once './functions.inc.php';
/**
 * set custom error handler
 */
$old_error_handler = set_error_handler("customErrorHandler");
/**
 * set essentials
 */
session_start( );
ob_start( );
date_default_timezone_set("GMT");
/**
 * set/fix magic quotes
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
 * include classes (required)
 */
require_once './classes.inc.php';
/**
 * include optionals
 */
include_once './social_connect/facebook/facebook.inc.php';
include_once './social_connect/twitter/twitteroauth.php';

/******************************
 * OBJECT CREATION
 ******************************/
 
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

/******************************
 * INIT VARS AND FUNC CALLS
 ******************************/
 
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
// Call the default searchPost( ) if $_GET['s'] is set.
if(isset($_GET['s'])) {
   $indexposts = $contents->searchPost( );
}
// Otherwise, if $id is true, call searchPost($id). If $id is 0, call indexPosts( )
else {
   $indexposts = ($id) ? $contents->searchPost($id, TRUE) : $contents->indexPosts( );
}
// Call RSS feed
if(isset($_GET['rss'])) {
   // DECIDE: RSS from index?
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
