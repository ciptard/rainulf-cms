<?php
if(!defined("INDEX")) die("Not allowed.");
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">


<head>
   <title><?php echo $indexTitle; ?></title>
   <meta name="description" content="<?php echo $indexDesc; ?>" />
   <meta name="keywords" content="<?php echo $indexKeyw; ?>" />
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
            <li><a href='<?php echo Helper::titleToHTMLExt($one->id, $one->Title); ?>'><?php echo $one->Title; ?></a></li>
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
            <li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf" target="_blank">About Rainulf</a></li>
            <li><a href="http://twitter.com/rainulf" target="_blank">Rainulf@Twitter</a></li>
            <li><a href="https://github.com/rainulf" target="_blank">Rainulf@github</a></li>
            <li><a href="http://bit.ly/rainulfirc" target="_blank">Rainulf@IRC Freenode</a></li>
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
         <h1 style="text-align:center;"><?php echo $errorHeader; ?></h1><br />
         <img style="display:block;margin-left:auto;margin-right:auto;"src="<?php echo $errorImg; ?>" alt="<?php echo $errorImgAlt; ?>" />
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
