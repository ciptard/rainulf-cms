<?php
/************************************
 * Author      : Rainulf            *
 * Website     : rainulf.ca         *
 * Email       : rainulf@rainulf.ca *
 ************************************/
    
if(!defined("INDEX")) die("Not allowed.");

class ContentsModelMapper{
   protected $modelList;
   protected $dbConnection;
   protected $mode;

   public $TableName = "contents";

   private function _IterateItems($items){
      switch($this->mode){
         case "replace":
            !$this->IsEmpty() && $this->EmptyModelList();
            break;
         case "append":
            break;
         default:
      }
      foreach($items as $item){
         $id = isset($item['id']) ? $item['id'] : "";
         $Title = isset($item['Title']) ? $item['Title'] : "";
         $content = isset($item['content']) ? $item['content'] : "";
         $PostD = isset($item['PostD']) ? $item['PostD'] : "";
         $Tags = isset($item['Tags']) ? $item['Tags'] : "";
         $this->modelList[] = new ContentsModel($id,$Title,$content,$PostD,$Tags);
      }
      return (count($items) == count($this->modelList));
   }
   public function __construct($modelList = array(), $mode = "replace"){
      $this->modelList = $modelList;
      $this->dbConnection = new MySQLConnection();
      $this->dbConnection->setTable($this->TableName);
      $this->dbConnection->setColumn("id","Title","content","PostD","Tags");
      $this->dbConnection->setLimit(0, CONTENTS_PER_PG);
      $this->mode = $mode;
   }
   public function FetchAll($x = null, $y = null){
      $items = array();
      if($x == null && $y == null){
         $items = $this->dbConnection->SelectAll(false);
      } else {
         $res = $this->SetFetchLimit($x, $y);
         $res && $items = $this->dbConnection->SelectAll();
      }
      !empty($items) && $this->_IterateItems($items);
      return $this->modelList;
   }
   public function Fetch($column, $val, $isStrict = false){
      $items = array();
      if(is_int($val)){
         $type = 'i';
      }
      else if(is_double($val) || is_float($val)){
         $type = 'd';
      }
      else if(is_string($val)){
         $type = 's';
      }
      else if(is_binary($val)){
         $type = 'b';
      }
      $items = $this->dbConnection->Search($column, $type, $val, $isStrict);
      !empty($items) && $this->_IterateItems($items);
      return $this->modelList;
   }
   public function FetchColumn($columnName, $isLimited = false){
      $items = array();
      $items = $this->dbConnection->SelectColumn($columnName, $isLimited);
      !empty($items) && $this->_IterateItems($items);
      return $this->modelList;
   }
   public function SetFetchLimit($x, $y){
      $res = $this->dbConnection->setLimit($x, $y);
      return $res;
   }
   public function SetOrder($orderby, $order){
      return $this->dbConnection->setOrder($orderby, $order);
   }
   public function EmptyModelList(){
      $this->modelList = array();
      return empty($this->modelList);
   }
   public function GetNumRows(){
      return $this->dbConnection->GetNumRows();
   }
   public function IsEmpty(){
      return empty($this->modelList);
   }
   public function Save(){
      foreach($this->modelList as $model){
         
      }
   }

}
?>
