<?php

define("INDEX",TRUE);
require_once 'controller.inc.php';

echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
echo "<rss version=\"2.0\">";
echo "<channel>";
echo "  <title>".SITE_TITLE."</title>";
echo "  <link>".SITE_URL."</link>";
echo "  <description>".SITE_DESC."</description>";
$display->displayRSSItem($indexposts);
echo "</channel>";
echo "</rss>";

/*
   public function ViewRSS($match = "\w") {
      $this->allPostsWithLimit->data_seek(0);
      while($row = $this->allPostsWithLimit->fetch_array( )) {
         $datetime = explode(" ", $row['postd']);
         $date = explode("-", $datetime[0]);
         $time = explode(":", $datetime[1]);
         if(preg_match("/$match/", $row['Title'])) {
            echo "   <item>\n";
            echo "     <title>" . $row['Title'] . "</title>\n";
            echo "     <link>http://rainulf.ca/?id=" . $row['id'] . "</link>\n";
            echo "     <description><![CDATA[ " . $row['content'] . " ]]></description>\n";
            echo "     <pubDate>" . date("r", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0])) . "</pubDate>\n";
            echo "   </item>\n";
         }
      }
   }
*/
?>
