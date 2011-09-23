<?php
require_once 'BlogPost.php';
require_once 'DBFacade.php';
include 'Useful.php';

$indexPosts = array();
$indexLatest = array();
$indexTags  = array();

if(isset($_GET['id'])){
   $id = intval($_GET['id']);
   $singlePost = new BlogPost($id);
   $singlePost->getFromDB();
   $indexPosts[] = $singlePost;
} else {
   get($indexPosts);
}
if(isset($_GET['tags'])){
   $tags = htmlspecialchars($_GET['tags'], ENT_QUOTES);
   $indexPosts = array();
   get($indexPosts, true, 0, "Tags", $tags);
}

get($indexTags, false, 0, "Tags");
get($indexLatest, true, 0, "id, Title");
?>