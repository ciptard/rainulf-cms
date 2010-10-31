<?php
/*
Author: Rainulf (http://rainulf.net/)
Licensed under GNU GENERAL PUBLIC LICENSE v2. See: LICENSE file.

index.php file. Includes core.php file and calls necessary functions
*/

define("INDEX",TRUE);
require "core.php";

?>
<!DOCTYPE html PUBLIC
                  "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
      <title>Rainulf</title>
      <meta name="description" content="Jose Rainulf Pineda's official and personal website. Software and Web development - C/C++, PHP, mySQL, xHTML, JavaScript and Python languages." />
      <meta name="keywords" content="jose rainulf pineda, rainulf's website, rainulf, phpmyinput, younha, rainulf younha, rainulf.ca, open source, seneca college, seneca" />
      <meta name="author" content="Rainulf" />
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <script src='script.js' type='text/javascript'></script>
   </head>

   <body onload="changeQuote( ); checkCompatible( );">
      <div id="header" onclick="changeQuote( );"></div>
      <div id="title">rainulf.ca - click and it'll change ;)</div>
      <div id="slogan"></div>
      
      <table class="navigation">
         <thead><tr><th>Navigation</th></tr></thead>
         <tbody><tr><td>
            <ul>
            <li><a href="http://rainulf.ca/">Home</a></li>
            <li><a href="http://bit.ly/aboutrainulf">About</a></li>
            <li><a href="javascript:ViewSource( );">View Page Source</a></li>
            <li><a href="style.css" target="_blank">View CSS</a></li>
            <li><a href="script.js" target="_blank">View JavaScript</a></li>
            <li><a href="." onclick="alert('Sorry, you may not view the PHP sources right now. New redesigned PHP sources will be available on October 30.')">View PHP Sources</a></li>
            <li><a href="rss.php">Subscribe to RSS Feed</a></li>
            </ul>
         </td></tr></tbody>
      </table>
      
      <table class="links">
         <thead><tr><th>Links</th></tr></thead>
         <tbody><tr><td>
            <ul>
            <li><a href="http://twitter.com/rainulf" target="_blank">Rainulf@Twitter</a></li>
            <li><a href="http://bit.ly/rainulfirc" target="_blank">Rainulf@IRC Freenode</a></li>
            <li><a href="http://code.google.com/p/phpmyinput/" target="_blank">phpMyInput</a></li>
            <li><a href="http://rainulf.net/younha/" target="_blank">Younha Fan Page</a></li>
            <li><a href="http://helloyounha.com/xe/" target="_blank">Hello!Younha!</a></li>
            <li><a href="http://www.animenewsnetwork.com/" target="_blank">Anime News Network</a></li>
            <li><a href="http://myanimelist.net/" target="_blank">MyAnimeList</a></li>
            <li><a href="http://randomc.net/" target="_blank">Random Curiosity</a></li>
            <li><a href="https://my.senecacollege.ca/" target="_blank">Seneca BlackBoard</a></li>
            <li><a href="https://scs.senecac.on.ca/" target="_blank">Seneca CS</a></li>
            <li><a href="https://learn.senecac.on.ca/" target="_blank">Seneca Webmail</a></li>
            <li><a href="http://validator.w3.org/check?uri=referer" target="_blank">xHTML VALID</a></li>
            <li><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">CSS VALID</a></li>
            </ul>
         </td></tr></tbody>
      </table>
      
      <table class="entries">
         <thead><tr><th>Latest Entries</th></tr></thead>
         <tbody><tr><td>
            <ul>
            <?php $core->ViewLatestEntries( ); ?>
            <?php $core->ViewPaging( ); ?>
            </ul>
         </td></tr></tbody>
      </table>

      <div class="margin_start"></div>
   <?php $core->ViewPosts( ); ?>
   <div id="footer">Copyright &copy; 2010. Rainulf. Best viewed on Firefox or Chrome with 1680x1050,1400x1050,1280x1024,1440x900,1280x960,1360x768,1152x864,1024x768 resolution.</div>
   </body>
</html>
