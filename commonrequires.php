<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/

if(!defined("INDEX")) die("Not allowed.");

$selfPath = dirname(__FILE__);

require_once $selfPath.'/conf.php';
require_once $selfPath.'/helpers.php';
require_once $selfPath.'/_classes/DatabaseConnection.php';
require_once $selfPath.'/_classes/MongoDBConnection.php';
require_once $selfPath.'/_classes/MySQLConnection.php';
require_once $selfPath.'/_classes/Model.php';
require_once $selfPath.'/_classes/ContentsModel.php';
require_once $selfPath.'/_classes/ContentsModelMapper.php';

?>
