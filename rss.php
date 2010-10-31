<?php
/* 
Author: Rainulf (http://rainulf.net/)
Licensed under GNU GENERAL PUBLIC LICENSE v2. See: LIC

RSS feed for the website.
*/
define("INDEX",TRUE);
include 'core.php';


echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
?>
<rss version="2.0">

<channel>
  <title>Rainulf</title>
  <link>http://rainulf.ca/</link>
  <description>Rainulf's official website!</description>
<?php $core->ViewRSS($_GET['title']); ?>
</channel>

</rss>
