<?php

define("INDEX",TRUE);
require_once 'controller.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <title>Rainulf</title>
      <meta name="description" content="Jose Rainulf Pineda's official website. Software and Web development - C/C++, PHP, mySQL, xHTML and JavaScript languages." />
      <meta name="keywords" content="jose rainulf pineda, rainulf's website, open source, software development, web development, c++ and c, php, mysql, xhtml, javascript, programming languages, programming tutorials, anime, manga" />
      <meta name="author" content="Rainulf" />
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <script src='script.js' type='text/javascript'></script>
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
			<li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf">About Me</a></li>
			<li><a href="./source_codes/">Source Codes</a></li>
			<li><a href="#">RSS Feed</a></li>
			<li><a href="#" onclick="alert('rainulf1@gmail.com');">Contact Me</a></li>
		</ul>
	</div>
	<!-- end #menu -->
</div>
<!-- end #header -->
<div id="page">
	<div id="content">
   <!--  CONTENTS!! -->
   <?php // insert contents ?>
	</div>
	<!-- end #content -->
	<div id="sidebar">
		<div id="sidebar-bgtop"></div>
		<div id="sidebar-content">
			<ul>
				<li id="search">
					<h2>Instant Search</h2>
					<form method="get" action="">
						<fieldset>
						<input type="text" id="s" name="s" onfocus="if(this.value==this.defaultValue)this.value=''" 
				onblur="if(this.value=='')this.value=this.defaultValue" onkeyup="ajaxsearch(this.value)" value="it's magic."  />
						</fieldset>
					</form>
				</li>
				<li>
					<h2>Latest Entries</h2>
					<?php // insert entries ?>
				</li>
				<li>
					<h2>Latest Source Codes</h2>
					<?php // insert source codes ?>
				</li>
				<li>
					<h2>Links</h2>
					<?php // insert links ?>
				</li>
			</ul>
		</div>
		<div id="sidebar-bgbtm"></div>
	</div>
	<!-- end #sidebar -->
</div>
<!-- end #page -->
<div id="footer">
	<p>Copyleft 2011, All Wrongs Reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<!-- end #footer -->
</body>
</html>
