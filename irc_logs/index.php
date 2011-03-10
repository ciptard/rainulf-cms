<?php
require "./config.inc.php";
if(isset($_GET['view'])) {
   $logfile = $_GET['view'];
   $logfile = cleanString($logfile);
   $log = file_get_contents(CHAN_LOC."/".$logfile);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if(isset($logfile)) echo "{$logfile} - "?>Rainulf's IRC logs</title>
<meta name="description" content="The public IRC logs of Rainulf." />
<meta name="keywords" content="freenode, rainulf, irc logs, seneca irc logs, public irc logs" />
<meta name="author" content="Rainulf" />
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
</head>

<body>

<form action="" method="get">
<a href="../">Back to Rainulf</a> | <a href=".">Home</a> | Channel name: #<input type="text" name="channel" size='10' />
<input type="submit" value="View!" />
</form>
<table width='100%'>
<tr>
<?php
$files = array( );

$channel = (isset($_GET['channel'])) ? $_GET['channel'] : "";
if($handle = opendir(CHAN_LOC)) {
   while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {
         if(preg_match("/({$channel})\./", $file)) {
            $files[] = $file;
         }
      }
   }
   closedir($handle);
}

rsort($files);

if(!empty($files)) {
   echo "<td valign='top' width='20%'>\n";
   echo "<ul>\n";
   foreach($files as $chname) {
      $chname = cleanString($chname);
      if($channel != null) {
         echo "<li><a href='?channel=$channel&view=$chname'>$chname</a></li>\n";
      }
      else {
         echo "<li><a href='?view=$chname'>$chname</a></li>\n";
      }
   }
   echo "</ul>\n";
   echo "</td>\n";
   echo "<td valign='top'>\n"; 
   if(isset($_GET['view'])) {
      echo "<p><b>IRC log name:</b> $logfile</p>\n";
      echo "<textarea cols='120' rows='25' readonly='readonly'>\n";
      echo $log;
      echo "</textarea>";
   }
   else {
      echo <<<END
      <h3>Welcome to my IRC logs!</h3>
      <p>My bot's name is 'RaiBot'. The bot idles around <a href='http://freenode.net/' target='_blank'>FreeNode</a>. 
      It logs all the chats in the channel it idles in, so please be careful of what you say if you don't want it to be logged. 
      I use <a href='http://www.eggheads.org/' target='_blank'>eggdrop</a> for the bot. Please see the site if you want more information
      about it. The bot is fairly simple to setup - all the information you'll need are in the eggheads wiki and forum. If not, then 
      <a href='http://lmgtfy.com/?q=irc+bot' target='_blank'>Google</a> or err, <a href='http://www.bing.com/' target='_blank'>Bing</a> it. ;)</p>
      <p>I do not like to touch the logs, but if there's any sensitive information that you think should be put down, 
      please send a request to the email below. <br />Please give me a reasonable explaination.</p>
      <p>If you noticed any bugs, features should be added, comments, spelling/grammar mistakes, etc., email it.</p>
      <p><b>Email:</b> rainulf1@gmail.com</p>
      <p>More features are coming so stay tune!</p>
END;
   }
   echo "</td>\n";
}
else {
   echo "<td><p>No channels found. Please make sure you don't include '#'.</p></td>";
}

function cleanString($string){
   $string = trim($string);
   $string = htmlspecialchars($string);
   $string = addslashes($string);
   $res = preg_match("/^[a-zA-Z]-{0,1}.*\.log\.[0-9]{1,2}[a-zA-Z]{3,4}[0-9]{4}/", $string);
   if(!$res) {
      $string = "";
   }
   return $string;
}
?>

</tr>
</table>
<center><p>
    <a href="http://validator.w3.org/check?uri=referer">xHTML valid</a>
  </p></center>
</body>
</html>
