<?php
/*
   Reading/writing files from/to directory
   Author: Rainulf Pineda
*/
 
class ManageFiles {
   protected $currentFolder;
   
   public function __construct($folder = NULL) {
      $this->currentFolder = $folder;
   }
   
   public function __destruct( ) { unset($this->currentFolder); }
   
   public function scanFolder($srt = 0) {
      $dircontent = scandir($this->currentFolder);
      $arr = array();
      foreach($dircontent as $filename) {
        if ($filename != '.' && $filename != '..') {
          if (filemtime($this->currentFolder.$filename) === false) return false;
          $dat = date("YmdHis", filemtime($this->currentFolder.$filename));
          $arr[$dat] = $filename;
        }
      }
      if (!ksort($arr)) return false;
      if ($srt) return array_reverse($arr);
      else return $arr;
   }
}

?>
