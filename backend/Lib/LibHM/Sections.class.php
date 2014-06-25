<?php
import("@.LibHM.BaseObject");
class Sections extends BaseObject{
	
	public function getname($sectionsid){
		    $model = M('Sections');
		   $list = $model->where('sectionsid ='.$sectionsid)->find();
		   return $list['name'];
		}
}
?>