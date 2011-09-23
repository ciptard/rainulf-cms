<?php
define("INDEX", true);
require_once 'BlogHandler.php';

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title><?php echo SITE_TITLE; ?></title>
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
         <h1><a href="."><?php echo SITE_TITLE; ?></a></h1>

         <h2 id="quote">I have no quote to show, you seem to have turned off JavaScript, please turn it on.</h2><br />
         <hr />
      </div><!-- end header -->

      <div id="left">
         <h3>Latest Entries</h3>
         <ul>
         <?php foreach($indexLatest as $latest): ?>
            <?php
               $urlTitle = urlTitle($latest->getTitle());
            ?>
            <li><a href='<?php echo $urlTitle."-".$latest->getID().".html"; ?>'><?php echo $latest->getTitle(); ?></a></li>
         <?php endforeach; ?>
         </ul>
         <h3>Tags</h3>
         <ul>
            <li></li>
         </ul>
         <h3>Links</h3>
         <ul>
            <li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf">Rainulf@CDOT</a></li>
            <li><a href="http://twitter.com/rainulf">Rainulf@Twitter</a></li>
            <li><a href="http://bit.ly/rainulfirc">Rainulf@IRC Freenode</a></li>
            <li><a href="http://helloyounha.com/xe/">Hello!Younha!</a></li>
            <li><a href="http://www.animenewsnetwork.com/">Anime News Network</a></li>
            <li><a href="http://myanimelist.net/">MyAnimeList</a></li>
            <li><a href="http://randomc.net/">Random Curiosity</a></li>
            <li><a href="https://my.senecacollege.ca/">Seneca BlackBoard</a></li>
            <li><a href="https://scs.senecac.on.ca/">Seneca CS</a></li>
            <li><a href="https://learn.senecac.on.ca/">Seneca Webmail</a></li>
         </ul>
      </div><!-- end left division -->
      <div id="main">
      
      
      <?php foreach($indexPosts as $post): ?>
         <?php 
            $date = betterDatetime($post->getDate());
            $urlTitle = urlTitle($post->getTitle());
         ?>
         <a id='<?php echo $post->getID(); ?>'></a>
		   <div class='post'>
			   <h1 class='title'><a href="javascript:unhide('id_<?php echo $post->getID(); ?>');"><?php echo $post->getTitle(); ?></a></h1>
			   <div id='id_<?php echo $post->getID(); ?>' class='postContents'>
			      <p class='byline'><small>Posted on <?php echo $date; ?></small></p>
			      <div class='entry'>
                  <?php echo $post->getContent(); ?>
			      </div>
               <div class="postComments"></div>
			      <div class="meta">
				      <p class="links"><a href='#'>Back to top</a> &nbsp;&bull;&nbsp; <a class="permalink" href='<?php echo $urlTitle."-".$post->getID().".html"; ?>'>Permalink</a></p>
			      </div>
			   </div>
		   </div>
      <?php endforeach; ?>
      
      
      </div>
      <div id="footer">
         <hr />
         <p class="left">| <a href=
             "http://jigsaw.w3.org/css-validator/">CSS</a> | <a href=
             "http://validator.w3.org/check?uri=referer">HTML5</a>
         |</p>
         <p class="right">All Lefts Reserved. 2011.</p>
      </div><!-- end footer -->
   </div><!-- end container -->
   <script src='./_js/jquery-1.5.2.min.js' type='text/javascript'></script>
   <script src='./_js/script.js' type='text/javascript'></script>
</body>
</html>
