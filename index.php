<?php

define("INDEX",TRUE);
require_once 'controller.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <title><?php $display->displayPaging($page, true); $display->displayIndividualPostInfo($indexposts, 'Title'); echo SITE_TITLE; ?></title>
      <meta name="description" content="<?php echo SITE_DESC; ?>" />
      <meta name="keywords" content="<?php echo SITE_KEYW; ?>" />
      <meta name="author" content="<?php echo SITE_AUTHOR; ?>" />
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <link rel="stylesheet" type="text/css" href="style.css" />
   </head>
<body onload="changeQuote( );">
<div id="header">
	<div id="logo">
		<h1><a href="http://rainulf.ca/">rainulf.ca</a></h1>
		<p id="slogan"></p>
	</div>
	<!-- end #logo -->
	<div id="menu">
		<ul>
			<li class="first"><a href="./">Home</a></li>
			<li><a href="./source_codes/">Source Codes</a></li>
			<li><a href="./rss.php">RSS Feed</a></li>
			<li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf">About Me</a></li>
			<li><a href="#" onclick="alert('rainulf1@gmail.com');">Contact Me</a></li>
		</ul>
	</div>
	<!-- end #menu -->
</div>
<!-- end #header -->
<div id="page">
	<div id="content">
   <!--  CONTENTS!! -->
   <?php $display->displayManyPosts($indexposts); ?>
	</div>
	<!-- end #content -->
	<div id="sidebar">
		<div id="sidebar-bgtop"></div>
		<div id="sidebar-content">
			<ul>
				<li id="search">
					<h2>Remote Control</h2>
					<form method="get" action="">
						<fieldset>
						<input type="text" id="search_bar" name="search_bar" onfocus="if(this.value==this.defaultValue)this.value=''" 
				onblur="if(this.value=='')this.value=this.defaultValue" value="Instant Search"  />
						</fieldset>
					</form>
               <ul>
                  <li><?php $display->displayPaging($page); ?></li>
               </ul>
				</li>
				<li>
					<h2>Social Connect</h2>
					<?php $social->out( ); ?>
				</li>
				<li>
					<h2>Latest Entries</h2>
					<?php $display->displayList($indexlist); ?>
				</li>
				<li>
					<h2>Latest Source Codes</h2>
					<?php $display->displayFiles($source_codes); ?>
				</li>
				<li>
					<h2>Links</h2>
					<ul>
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
                  <li><a href="http://validator.w3.org/check?uri=referer" target="_blank">xHTML VALID</a></li>
                  <li><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">CSS VALID</a></li>
					</ul>
				</li>
				<li>
               <script type='text/javascript'>
               <?php echo file_get_contents("http://widgets.twimg.com/j/2/widget.js"); ?>
               new TWTR.Widget({
                 version: 2,
                 type: 'profile',
                 rpp: 5,
                 interval: 6000,
                 width: 250,
                 height: 300,
                 theme: {
                   shell: {
                     background: '#4e8a30',
                     color: '#ffffff'
                   },
                   tweets: {
                     background: '#ffffff',
                     color: '#3d273d',
                     links: '#43a31a'
                   }
                 },
                 features: {
                   scrollbar: false,
                   loop: false,
                   live: false,
                   hashtags: true,
                   timestamp: true,
                   avatars: false,
                   behavior: 'all'
                 }
               }).render().setUser('rainulf').start();
               </script>
				</li>
			</ul>
		</div>
		<div id="sidebar-bgbtm"></div>
	</div>
	<!-- end #sidebar -->
</div>
<div id="footer">
	<p>Copyleft 2011, All Wrongs Reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<!-- end #footer -->
<script src='./jquery-1.5.min.js' type='text/javascript'></script>
<script src='./script.js' type='text/javascript'></script>
</body>
</html>
