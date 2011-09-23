<?php

define("INDEX",TRUE);
require_once './controller.inc.php';

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">


<head>
   <title><?php echo $indexTitle; ?></title>
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

         <h2 id="quote"></h2><br />
         <hr />
      </div><!-- end header -->

      <div id="left">
      
      
         <h3>Latest Entries</h3>
         <ul>
         <?php foreach($indexEntries as $one): ?>
            <li><a href='<?php echo titleToHTMLExt($one->id, $one->Title); ?>'><?php echo $one->Title; ?></a></li>
         <?php endforeach; ?>
         </ul>
         
         
         <h3>Tags</h3>
         <ul>
            <li>
               <?php foreach($indexTags as $one): ?>
                  <a href='<?php echo $one['name']; ?>tag.html'><?php echo $one['name']; ?></a> [<?php echo $one['count']; ?>]
               <?php endforeach; ?>
            </li>
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
      <?php foreach($indexPosts as $one): ?>
         <a id='<?php echo $one->id; ?>'></a>
		   <div class='post'>
			   <h1 class='title'><a href="javascript:unhide('id_<?php echo $one->id; ?>');"><?php echo $one->Title; ?></a></h1>
			   <div id='id_<?php echo $one->id; ?>' class='postContents'>
			      <p class='byline'><small>Posted on <?php echo $one->PostD; ?></small></p>
			      <div class='entry'>
               <?php echo $one->content; ?>
			      </div>
               <div class="postComments"></div>
			      <div class="meta">
				      <p class="links"><a href='#'>Back to top</a> &nbsp;&bull;&nbsp; <a class="permalink" href='<?php echo titleToHTMLExt($one->id, $one->Title); ?>'>Permalink</a></p>
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
         <p class="right">With Glowing Hearts.</p>
      </div><!-- end footer -->
      
      
   </div><!-- end container -->
   
   
   <script src='./_js/jquery-1.5.2.min.js' type='text/javascript'></script>
   <script src='./_js/script.js' type='text/javascript'></script>
   
   
</body>
</html>
