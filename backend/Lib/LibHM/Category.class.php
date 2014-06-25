<?php
import("@.LibHM.BaseObject");
class Category extends BaseObject{
	/**
	 * 根据分类ID 获得分类名称
	 * Enter description here ...
	 */
	public function getname($categoryid){
		$Data 		= M('Category');
		$categoryList = $Data->where("categoryid = $categoryid")->select();
		return $categoryList[0]['name'];
	}
}