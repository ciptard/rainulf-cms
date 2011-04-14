<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: N/A          *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Only for displaying/echoing HTML/contents
 */
class Displayer {
   protected $contents;
   protected $comments;
   public $unhideFirstPost;
   
   public function __construct($contents, $comments) {
      $this->contents = $contents;
      $this->comments = $comments;
      $this->unhideFirstPost = "unhidden";
   }
   
   public function __destruct( ) {
      unset($this->contents, 
            $this->unhideFirstPost);
   }
   
   public function displayPost($id, $title, $date, $content, $numofcomments) {
      // BEGIN
      echo "
         <a name='{$id}'></a>
		   <div class='post'>
			   <h1 class='title'><a href=\"javascript:unhide('id_{$id}');\">$title</a></h1>
			   <div id='id_{$id}' class='{$this->unhideFirstPost}'>
			      <p class='byline'><small>Posted on {$date}</small></p>
			      <div class='entry'>
               $content
			      </div>
			      <div class=\"meta\">
				      <p class=\"links\"><a href='#'>Back to top</a> &nbsp;&bull;&nbsp; <a href='?id={$id}'>Permalink</a> &nbsp;&bull;&nbsp; <a href=\"javascript:unhide('id_comment_{$id}');\" class='comments'>Submit Comment</a></p>
			      </div>
			      <div id='id_comment_{$id}' class='hidden'>
			         <form action=\"\" method='post'>
			         <input name='post_id' type='hidden' value='{$id}' />
			         <table>
			            <tr>";
                     if(isset($_SESSION['loggedin'])){
                        echo "
			               <th valign='top'>Your comment?</th>
			               <td><textarea name='comment_content' rows='7' cols='50'></textarea><br />
			               <input type='submit' value='Submit!' /></td>";
                     }
                     else{
                        echo "
                        <th valign='top'>You must login to comment.</th>";
                     }
                     echo "
			            </tr>
			         </table>
			         </form>
			      </div>
			   </div>
		   </div>
	    "; // END
	    if($this->unhideFirstPost == "unhidden") $this->unhideFirstPost = "hidden";
   }
   
   public function displayManyPosts($arr) {
      $numOfPosts = count($arr);
      for($i=0; $i < $numOfPosts; $i++) {
         $this->displayPost($arr[$i]['id'], $arr[$i]['Title'], $arr[$i]['PostD'], $arr[$i]['content'], 0);
      }
   }
   
   public function displayIndividualPostInfo($arr, $key) {
      if(isset($arr, $_GET['id'])) {
         echo $arr[0][$key]." - ";
      }
   }
   
   public function displayRSSItem($arr) {
      $numOfPosts = count($arr);
      for($i=0; $i < $numOfPosts; $i++) {
         $datetime = explode(" ", $arr[$i]['PostD']);
         $date = explode("-", $datetime[0]);
         $time = explode(":", $datetime[1]);
         echo "   <item>\n";
         echo "     <title>" . $arr[$i]['Title'] . "</title>\n";
         echo "     <link>".SITE_URL."?id=" . $arr[$i]['id'] . "</link>\n";
         echo "     <description><![CDATA[ " . $arr[$i]['content'] . " ]]></description>\n";
         // REF: http://php.net/manual/en/function.mktime.php
         echo "     <pubDate>" . date("r", mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0])) . "</pubDate>\n";
         echo "   </item>\n";
      }
   }
   
   public function displayList($arr) {
      $numOfPosts = count($arr);
      echo "<ul>";
      for($i=0; $i < $numOfPosts; $i++) {
         echo "<li><a href='?id={$arr[$i]['id']}'>{$arr[$i]['Title']}</a></li>";
      }
      echo "</ul>";
   }
   
   public function displayFiles($arr) {
      //$numOfPosts = count($arr);
      echo "<ul>";
      foreach($arr as $a => $b) {
         echo "<li><a href='./source_codes/{$b}'>$b</a></li>";
      }
      echo "</ul>";
   }
   public function ajaxSearchDisplay( ) {
      $arr = $this->contents->searchPost( );
      $numOfPosts = count($arr);
      if($numOfPosts) {
         for($i=0; $i < $numOfPosts; $i++) {
            $this->displayPost($arr[$i]['id'], $arr[$i]['Title'], $arr[$i]['PostD'], $arr[$i]['content'], 0);
         }
      }
      else {
         $string = htmlspecialchars($_GET['search_bar'], ENT_QUOTES);
         echo "<p>'{$string}' cannot be found.</p>";
      }
   }
   public function displayPaging($page, $title = false) {
      if(!$title) {
         $next = "";
         $maxPages = $this->contents->returnTotalContents( ) / CONTENTS_PER_PG;
         $maxPages = ceil($maxPages);
         if($page > 1) {
            //echo "[<a id=\"first_page\" class=\"paging\" href=\"?page=1\">First</a>]";
            echo "[<a id=\"prev_page\" class=\"paging\" href=\"?page=" . ($page - 1) . "\">Prev</a>]";
         }
         else {
            //echo "[First]";
            echo "[<a id=\"prev_page\" class=\"paging\">Prev</a>]";
         }
         echo " <b>Page:</b> <span id='cur_page_num'>{$page}</span> of <span id='max_page_num'>{$maxPages}</span> ";
         if($page < $maxPages) {
            echo "[<a id=\"next_page\" class=\"paging\" href=\"?page=" . $next = $next + ($page + 1) . "\">Next</a>]";
            //echo "[<a id=\"last_page\" class=\"paging\" href=\"?page={$maxPages}\">Last</a>]";
         }
         else {
            echo "[<a id=\"next_page\" class=\"paging\">Next</a>]";
            //echo "[Last]";
         }
      //}
      //else {
      //   if($page == 1) {
      //      $page = "";
      //   }
      //   else {
      //      echo "Page {$page} - ";
      //   }
      }
   }
}

?>
