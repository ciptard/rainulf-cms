<?php
define("INDEX", true);

error_reporting(-1);
date_default_timezone_set('America/Toronto');
require_once './conf.php';
require_once './helpers.php';
require_once './_classes/DatabaseConnection.php';
require_once './_classes/ContentsModel.php';
require_once './_classes/ContentsModelMapper.php';

Helper::fixMagicQuotes();
/**
 * Mapper creation and REQUEST grabbing
 */
$mapper = new ContentsModelMapper();
$mapper->SetOrder('PostD', 'DESC');

$requests = Helper::getRequests();

$offset = intval($requests['offset']);
$indexPosts = $mapper->FetchAll($offset, CONTENTS_PER_PG);

?>
      <?php foreach($indexPosts as $one): ?>
         <a id='<?php echo $one->id; ?>'></a>
         <div class='post'>
            <h1 class='title'><a href="javascript:unhide('id_<?php echo $one->id; ?>');"><?php echo $one->Title; ?></a></h1>
            <div id='id_<?php echo $one->id; ?>' class='postContents appended'>
               <p class='byline'><small>Posted on <?php echo Helper::formatDate($one->PostD); ?></small></p>
               <div class='entry'>
               <?php echo $one->content; ?>
               </div>
               <div class="postComments"></div>
               <div class="meta">
                  <p class="links"><a href='#'>Back to top</a> &nbsp;&bull;&nbsp; <a class="permalink" href='<?php echo Helper::titleToHTMLExt($one->id, $one->Title); ?>'>Permalink</a></p>
               </div>
               
            </div>
         </div>
      <?php endforeach; ?>