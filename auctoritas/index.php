<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Sep 26, 2011 *
 * Last Updated: Sep 26, 2011 *
 ******************************/

define("INDEX", true);

error_reporting(-1);
session_start();
date_default_timezone_set('America/Toronto');
require_once '../conf.php';
require_once '../helpers.php';
require_once '../_classes/DatabaseConnection.php';
require_once '../_classes/ContentsModel.php';
require_once '../_classes/ContentsModelMapper.php';

Helper::fixMagicQuotes();
$indexTitle = 'Auctoritas Panel - ' . SITE_TITLE;


include '../_template/admin.php';
?>