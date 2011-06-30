<?php

define("INDEX",TRUE);
require_once './controller.inc.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <title><?php $display->displayPaging($page, true); $display->displayIndividualPostInfo($indexposts, 'Title'); echo SITE_TITLE; ?></title>
      <meta name="description" content="<?php echo SITE_DESC; ?>" />
      <meta name="keywords" content="<?php echo SITE_KEYW; ?>" />
      <meta name="author" content="<?php echo SITE_AUTHOR; ?>" />
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
  <div id="container">
    <div id="header">
      <h1><?php echo SITE_TITLE; ?></h1>

      <h2 id="quote">I have no quote to show, you seem to have turned off JavaScript, please turn it on.</h2><br />
      <hr />
    </div><!-- end header -->

    <div id="left">
      <h3>Latest Entries</h3>
      <?php $display->displayList($indexlist); ?>
      <h3>Links</h3>
					<ul>
                  <li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf">Rainulf@CDOT</a></li>
                  <li><a href="http://twitter.com/rainulf" target="_blank">Rainulf@Twitter</a></li>
                  <li><a href="http://bit.ly/rainulfirc" target="_blank">Rainulf@IRC Freenode</a></li>
                  <li><a href="http://twitter.com/younhaholic" target="_blank">Younha@Twitter</a></li>
                  <li><a href="./irc_logs">Rainulf's IRC Logs</a></li>
                  <li><a href="http://helloyounha.com/xe/" target="_blank">Hello!Younha!</a></li>
                  <li><a href="http://www.animenewsnetwork.com/" target="_blank">Anime News Network</a></li>
                  <li><a href="http://myanimelist.net/" target="_blank">MyAnimeList</a></li>
                  <li><a href="http://randomc.net/" target="_blank">Random Curiosity</a></li>
                  <li><a href="https://my.senecacollege.ca/" target="_blank">Seneca BlackBoard</a></li>
                  <li><a href="https://scs.senecac.on.ca/" target="_blank">Seneca CS</a></li>
                  <li><a href="https://learn.senecac.on.ca/" target="_blank">Seneca Webmail</a></li>
					</ul>
    </div><!-- end left division -->

    <div id="main">
      <?php $display->displayManyPosts($indexposts); ?>
    </div>

    <div id="footer">
      <hr />

      <p class="left">| <a href=
      "http://jigsaw.w3.org/css-validator/">CSS</a> | <a href=
      "http://validator.w3.org/check?uri=referer">XHTML 1.1</a>
      |</p>

      <p class="right">All Lefts Reserved. 2011.</p>

    </div><!-- end footer -->
  </div><!-- end container -->
   <script src='./_js/jquery-1.5.2.min.js' type='text/javascript'></script>
   <script src='./_js/script.js' type='text/javascript'></script>
  </body>
</html>
