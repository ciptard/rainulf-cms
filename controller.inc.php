<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 19, 2010 *
 * Last Updated: Feb 11, 2011 *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

error_reporting(-1);
session_start( );
ob_start( );
date_default_timezone_set("GMT");
require_once './conf.inc.php';
require_once './social_connect/facebook/facebook.inc.php';
require_once './social_connect/twitter/twitteroauth.php';
require_once './classes.inc.php';

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
$comments  = new ManageComments($commentDb, $contentDb, $fb_portal); // inherit - extends 'ManageContents'
$display   = new Displayer($contents, $fb_portal);
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
$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
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
// List the Latest Entries
$indexlist  = $contents->indexPosts( );
// List the Latest Source Codes
$source_codes = $files->scanFolder(1);
?>
