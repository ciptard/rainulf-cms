<?php
define("INDEX",TRUE);
require_once 'controller.php';
if(isset($_GET['s'])) $display->ajaxSearchDisplay( );
?>
