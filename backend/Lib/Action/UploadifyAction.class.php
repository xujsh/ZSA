<?php
import("@.LibHM.GlobalMediaResource");
class UploadifyAction extends BaseAction{
	/**
	 * 上传图片
	 * Enter description here ...
	 */
	public function updatapicFile(){
//		$uid = $_SESSION['adminuserid'];
//		$username = $_SESSION['adminloginname'];
		$uid =1;
		$username='admin';
		$name = $this->_post('name');
		$name = $name.'截图';
        $class = 2;
			$gmresou1 = new GlobalMediaResource();
			$picguid = $gmresou1->addResource($uid, $class, $username, $name,'picfiles');
			if($picguid){
					 echo $picguid;
			}else{
					 echo "上传失败,请从新上传";
			}
	  
	}
	
		/**
		 * 上传文件
		 * Enter description here ...
		 */
		public function updataFile(){
			$class			= $this->_post('class');
			$name		    = $this->_post('name');
  			$uid =1;
			$username='admin';
			$gmresou1 = new GlobalMediaResource();
			$vioguid = $gmresou1->addResource($uid, $class, $username, $name,'videofiles');
			if($vioguid){
					 echo $vioguid;
			}else{
					 echo "上传失败,请从新上传";
			}
		}
		
	/**
	 *	m3u文件
	 * Enter description here ...
	 */	
	public function updataM3uFile(){
			$class			= $this->_post('class');
			$name		    = $this->_post('name');
			
  			$uid =1;
			$username='admin';
			if($_FILES['videom3ufiles']['name']){
				$gmresou1 = new GlobalMediaResource();
				$vioguid = $gmresou1->addResourceM3u($uid, $class, $username, $name,'videom3ufiles');
				if($vioguid){
						 echo $vioguid; 
				}else{
						 echo "上传失败,请从新上传";
				}
			}
	}
		
		

}