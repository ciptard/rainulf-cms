<?php
/*******************
 * Author: Rainulf *
 * Date  : Oct 19  *
 *******************/

if(!defined("INDEX")) die("Not allowed.");
error_reporting(-1);
require_once 'classes.inc.php';

/*
 * Object creation
 *
 */
 
// $user, $pass, $db, $host = "localhost", $charset = "utf8"
$db       = new DatabaseConnection("user", "password", "db");
$contents = new ManageContents($db);
$display  = new Displayer($contents);
$files    = new ManageFiles("./source_codes/");

/*
 * init variables
 *
 */
$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
// Call the default searchPost( ) if $_GET['s'] is set.
if(isset($_GET['s'])) $indexposts = $contents->searchPost( );
// Otherwise, if $id is true, call searchPost($id). If $id is 0, call indexPosts( )
else $indexposts = ($id) ? $contents->searchPost($id, TRUE) : $contents->indexPosts( );
// List the Latest Entries
$indexlist  = $contents->indexPosts( );
// List the Latest Source Codes
$source_codes = $files->scanFolder(1);
?>
