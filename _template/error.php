<?php
if(!defined("INDEX")) die("Not allowed.");
?>

<?php include SELF_PATH . 'head.php'; ?>
<?php include SELF_PATH . 'leftdiv.php'; ?> 

      <div id="main">
         <h1 style="text-align:center;"><?php echo $errorHeader; ?></h1><br />
         <img style="display:block;margin-left:auto;margin-right:auto;"src="<?php echo $errorImg; ?>" alt="<?php echo $errorImgAlt; ?>" />
      </div>
      
<?php include SELF_PATH . 'foot.php'; ?>
