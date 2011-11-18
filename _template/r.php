<?php
if(!defined("INDEX")) die("Not allowed.");
?>

<?php include Helper::getPath(__FILE__) . 'head.php';?>
<?php include Helper::getPath(__FILE__) . 'leftdiv.php'; ?> 



      <div id="main">
         <form action="." method="get">
            <p>URL to shorten: <input type="text" name="url" id="url" /><input type="submit" value="Go!" /></p>
         <?php if(isset($shortUrl)): ?>
            <p>Short URL: <input type="text" name="shorturl" id="shorturl" value="<?php echo $shortUrl; ?>" /></p>
         <?php endif; ?>
         </form>
      </div>

<?php include Helper::getPath(__FILE__) . 'foot.php'; ?>
