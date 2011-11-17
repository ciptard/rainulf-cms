<?php
if(!defined("INDEX")) die("Not allowed.");
?>

<?php include Helper::getPath(__FILE__) . 'head.php';?>
<?php include Helper::getPath(__FILE__) . 'leftdiv.php'; ?> 

      <div id="main">
         <h1 style="text-align:center;"><?php echo $errorHeader; ?></h1><br />
         <img style="display:block;margin-left:auto;margin-right:auto;"src="<?php echo $errorImg; ?>" alt="<?php echo $errorImgAlt; ?>" />
      </div>
      
<?php include Helper::getPath(__FILE__) . 'foot.php'; ?>
