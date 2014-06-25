<?php
import("@.LibHM.BaseObject");
class Course extends BaseObject{
	
  private $wordarr = array();
  public function __construct(){
  
  }
  
   public function setWordarr($arr){
     $this-> wordarr = $arr; 
   }
   
   public function getWordarr(){
    return $this-> wordarr;
   }
   
   public function createArrayPersistence(){
     $arr = array('性','性福','草','草泥马');
     $s =  var_export($arr,true);
     echo $s;
   }
   
}