<?php
if(!defined("INDEX")) die("Not allowed.");
?>

<?php include SELF_PATH . 'head.php'; ?>
<?php include SELF_PATH . 'leftdiv.php'; ?> 



      <div id="main">
      <?php foreach($indexPosts as $one): ?>
         <a id='<?php echo $one->id; ?>'></a>
         <div class='post'>
            <h1 class='title'><a href="javascript:unhide('id_<?php echo $one->id; ?>');"><?php echo $one->Title; ?></a></h1>
            <div id='id_<?php echo $one->id; ?>' class='postContents'>
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
      </div>

<?php include SELF_PATH . 'foot.php'; ?>
