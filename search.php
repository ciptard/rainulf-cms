<?php
define("INDEX",TRUE);
require_once 'controller.inc.php';
if(isset($_GET['s'])) $display->ajaxSearchDisplay( );
?>
