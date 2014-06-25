<?php
/**
 * 外链链接页面
 * Enter description here ...
 * @author chenshuangjiang
 *
 */
class TolinksAction extends BaseAction{
  public function index(){
   $this->display('index');
  }
  
  /**
   * 获得外部链接
   * Enter description here ...
   */
  public function tolinks(){
       $lessonsid = $this->_param('lessonsid');
       $model = M('lessons');
       $list = $model->where('lessonsid='.$lessonsid)->find();
       if($list['tolinks']!=null || $list['tolinks']!=''){
		   $this->assign('url',$list['tolinks']);
       }else{
           $this->error('对不起，暂时没有本剧集');
       }
       
       $this->display('tolinks');
  }
  
  private function getlinks($linksid){
     $model = M('outsidelink');
     $list = $model->where('linksid='.$linksid)->find();
     return $list['linksurl'];
  }
  
  /**
   * 验证url地址是否有效
   * @param unknown_type $url
   */
  public function availableUrl($url) {
		// 避免请求超时超过了PHP的执行时间
		$executeTime = ini_get('max_execution_time');
		ini_set('max_execution_time', 0);
		$headers = @get_headers($url);
		ini_set('max_execution_time', $executeTime);
		if ($headers) {
			$head = explode(' ', $headers[0]);
			if (!empty($head[1]) && intval($head[1]) < 400)
				return true;
		}
  }
    
}