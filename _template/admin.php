<?php
if(!defined("INDEX")) die("Not allowed.");

define("PATH", "../");
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">


<head>
   <title><?php echo $indexTitle; ?></title>
   <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
   <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>style.css" />
   <link rel="shortcut icon" href="<?php echo PATH; ?>favicon.ico" />
</head>


<body>
   <div id="container">
   
   
      <div id="header">
         <h1><a href="."><?php echo SITE_TITLE; ?></a></h1>

         <h2 id="quote"></h2><br />
         <hr />
      </div><!-- end header -->

      <div id="left">
      
      
         <h3>Useful Options</h3>
         <ul>
            <li>Add Post</li>
            <li>Remove Post</li>
            <li>Edit Post</li>
         </ul>
         <hr />
         <ul>
            <li>Add Tag</li>
            <li>Remove Tag</li>
            <li>Edit Tag</li>
         </ul>
         <hr />
         <ul>
            <li>Add Link</li>
            <li>Remove Link</li>
            <li>Edit Link</li>
         </ul>
         
         
         <h3>Links</h3>
         <ul>
            <li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf" target="_blank">About Rainulf</a></li>
            <li><a href="https://joindiaspora.com/u/rainulf" target="_blank">Rainulf@Diaspora*</a></li>
            <li><a href="http://twitter.com/rainulf" target="_blank">Rainulf@Twitter</a></li>
            <li><a href="https://github.com/rainulf" target="_blank">Rainulf@github</a></li>
            <li><a href="http://bit.ly/rainulfirc" target="_blank">Rainulf@IRC Freenode</a></li>
            <li><a href="http://www.kiva.org/lender/rainulf" target="_blank">Rainulf@Kiva</a></li>
            <li><a href="http://kiva.org/invitedby/rainulf" target="_blank">Join Kiva</a></li>
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

      </div>
      
      <div id="footer">
         <hr />
         <p class="left">| <a href=
             "http://jigsaw.w3.org/css-validator/">CSS</a> | <a href=
             "http://validator.w3.org/check?uri=referer">HTML5</a>
         |</p>
         <p class="right">Welcome to Auctoritas Panel.</p>
      </div><!-- end footer -->
      
      
   </div><!-- end container -->
   
   
   <script src='<?php echo PATH; ?>_js/jquery-1.5.2.min.js' type='text/javascript'></script>
   <script src='<?php echo PATH; ?>_js/script.js' type='text/javascript'></script>
   
   
</body>
</html>
