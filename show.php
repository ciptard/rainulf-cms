<?php
define("INDEX",TRUE);
require_once 'controller.inc.php';
if(isset($_GET['search_bar'])) {
   $display->ajaxSearchDisplay( );
}
else {
   $display->displayManyPosts($indexposts);
}
?>
