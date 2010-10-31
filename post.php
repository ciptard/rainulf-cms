<?php
/* 
Author: Rainulf (http://rainulf.net/)
Licensed under GNU GENERAL PUBLIC LICENSE v2. See: LICENSE file.

used to view a post
*/
define("INDEX",TRUE);
require "core.php";

if(isset($_GET['id'])) $id = intval($_GET['id']);
else die("Post ID needed.");

$core->ViewPost($id);
?>
<!DOCTYPE html PUBLIC
                  "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
      <title><?php echo $core->name ?> - Rainulf</title>
      <meta name="author" content="Rainulf Pineda" />
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
            <li><a href="http://bit.ly/aboutrainulf" target="_blank">About</a></li>
            <li><a href="javascript:ViewSource( );">View Page Source</a></li>
            <li><a href="style.css" target="_blank">View CSS</a></li>
            <li><a href="script.js" target="_blank">View JavaScript</a></li>
            <li><a href="http://code.google.com/p/rainulf/source/browse/trunk/" target="_blank">View PHP Sources</a></li>
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
         <table class="content">
            <thead>
               <tr><th><?php echo $core->name ?></th></tr>
            </thead>
            <tfoot>
               <tr><td><b>Posted on:</b> <?php echo $core->loldate ?></td></tr>
            </tfoot>
            <tbody>
               <tr><td>
                  <?php echo $core->content ?>
                  <div id="disqus_thread"></div>
                  <script type="text/javascript">
                    /**
                      * var disqus_identifier; [Optional but recommended: Define a unique identifier (e.g. post id or slug) for this thread] 
                      */
                    (function() {
                     var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                     dsq.src = 'http://rainulf.disqus.com/embed.js';
                     (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                  </script>
                  <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=rainulf">comments powered by Disqus.</a></noscript>
               </td></tr>
            </tbody>
         </table>
   <div id="footer">Copyright &copy; 2010. Rainulf. Best viewed on Firefox or Chrome with 1680x1050,1400x1050,1280x1024,1440x900,1280x960,1360x768,1152x864,1024x768 resolution.</div>
      <script type="text/javascript">
      var disqus_shortname = 'rainulf';
      (function () {
        var s = document.createElement('script'); s.async = true;
        s.src = 'http://disqus.com/forums/rainulf/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
      }());
      </script>
   </body>
</html>
