<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: N/A          *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Reading/writing files from/to directory
 */
class Files {
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
      $ret = null;
      if(!ksort($arr)) {
         $ret = false;
      }
      else if($srt) {
         $ret = array_reverse($arr);
      }
      else {
         $ret = $arr;
      }
      return $ret;
   }
}

?>