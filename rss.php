<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/
 
define('INDEX', true);

error_reporting(-1);
date_default_timezone_set('America/Toronto');
require_once './commonrequires.php';


$mapper = new ContentsModelMapper();
$mapper->SetOrder('PostD', 'DESC');

$requests = Helper::getRequests();
if(array_key_exists('tags', $requests)){
   $indexPosts = $mapper->Fetch('Tags', '%'.$requests['tags'].'%');
}
else if(array_key_exists('id', $requests)){
   $indexPosts = $mapper->Fetch('id', intval($requests['id']), true);
}
else {
   $perpg = array_key_exists('limit', $requests) ? $requests['limit'] : CONTENTS_PER_PG;
   $indexPosts = $mapper->FetchAll(0, $perpg);
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
echo "<rss version=\"2.0\">\n";
echo "<channel>\n";
echo " <title>".SITE_TITLE."</title>\n";
echo " <link>".SITE_URL."</link>\n";
echo " <description>".SITE_DESC."</description>\n";
foreach($indexPosts as $one){
   $datetime = explode(" ", $one->PostD);
   $date = explode("-", $datetime[0]);
   $time = explode(":", $datetime[1]);
   echo "   <item>\n";
   echo "     <title>" . $one->Title . "</title>\n";
   echo "     <link>". SITE_URL . Helper::titleToHTMLExt($one->id, $one->Title) . "</link>\n";
   echo "     <description><![CDATA[ " . $one->content . " ]]></description>\n";
   // REF: http://php.net/manual/en/function.mktime.php
   echo "     <pubDate>" . date("r", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0])) . "</pubDate>\n";
   echo "   </item>\n";
}
echo "</channel>\n";
echo "</rss>\n";
?>
