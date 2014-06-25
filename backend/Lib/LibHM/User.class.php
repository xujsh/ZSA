<?php

/**
 * 用户管理类
 * @author chenshuangjiang
 */
import("@.LibHM.BaseObject");
class User extends BaseObject{
    
	/**
	 * 根据用户ID返回用户数据
	 * Enter description here ...
	 * @param unknown_type $uid
	 */
	public function getUserbyID($uid){
	 $model = M("users");
	 $listone = $model->where('userid='.$uid)->find();
	 return $listone;
	}
}