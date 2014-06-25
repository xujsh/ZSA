<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php if(($edittag) == "1"): ?>修改资源管理<?php else: ?>添加资源<?php endif; ?> 后台管理</title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
<link rel = "stylesheet" type = "text/css" href = "/Common/uploadify/uploadify.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->

<style>
#titlepic {
	margin-bottom: 10px;
}

.ui-front {
	z-index:1500;
}

</style>
</head>
<body>
<div class="container-fluid">

	<div class="row-fluid">
		<?php if(($edittag) == "1"): ?><div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<?php else: ?>
	  		<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(202 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(202 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div><?php endif; ?>
		<div class="span10" id="main">
			<h3><?php if(($edittag) == "1"): ?>修改资源信心<?php else: ?>添加资源<?php endif; ?></h3>
			<?php if(($edittag) == "1"): ?><input type="hidden" name="resid" value="<?php echo ($resinfo['resid']); ?>"><?php endif; ?>
			<label>上传文件名称描述</label>
			<input class="input-xlarge" type="text"  name="updetail" id='updetail'><span style='color:red'>*</span>
			<label>上传文件类型</label>
			<select name='typeid' class='input-xlarge' id='typeid'>
				<?php if(is_array($typeinfo)): $i = 0; $__LIST__ = $typeinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo["typeid"]); ?>'><?php echo ($vo['typename']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			
			<?php if($readonly != 1): ?><div class='upload_top'>
				<div id="content1" style = "text-align:left;">
				        <label>上传资源:
						<span id="help_mp4">上传.mp4格式文件 </span>
						<span id="help_pic">上传.png,.jpg格式 图片文件 </span>
						<span id="help_doc">上传.pdf,.doc,.txt格式文档文件 </span>
						<span id="help_wav">上传.mp3,.wav,.ape格式音频文件 </span>
						</label>
						<input type="file" name="file_upload" id="file_upload" />
				</div>
				
				<div id="content2" style = "text-align:left">
				        <label>上传资源:	<span>上传.m3u8格式的.zip压缩包</span></label>
						<input type="file" name="videom3ufiles" id="videom3ufiles" />
				</div>
			</div><?php endif; ?><!--<input class="input-xlarge" type="file"  name="photo">-->
			<?php if($readonly != 1): ?><div class="form-action">
				<span id="but1"><button type="button" class="btn btn-primary" onclick='doUpload1()'>开始上传</button></span>
				<span id="but2"><button type="button" class="btn btn-primary" onclick='doUpload2()'>开始上传</button></span>
				<a href="<?php echo ($appbasepath); ?>Resource/reslist/" class="btn">取消</a>
			</div>
			<?php if(($edittag) == "1"): ?><input type="hidden" name="act" value="update"><?php else: ?><input type="hidden" name="act" value="add"><?php endif; ?>
			</div><?php endif; ?>
	</div>
</div>
<script src="/Common/uploadify/jquery-1.9.1.min.js"></script>
<script src = "/Common/uploadify/jquery.uploadify.min.js"></script>
<script>
	
var www_host = "<?php echo C('APP_SITE_URI');?>";
var i=0;//初始化数组下标
var uploadInfo = []; //存储名称
	$(function(){

		$('#file_upload').uploadify({
            'auto'     : false,//关闭自动上传
            'debug'       : false, //开启调试模式
            'width'       : 150, //上传按钮的宽
            'height'   : 20,//上传按钮的高 
            'fileObjName':'file_upload', //上传的表单名称  <input type = "file" name = "file_upload" />
            'removeTimeout' : 1,//文件队列上传完成1秒后删除
            'swf'      : '/Common/uploadify/uploadify.swf', //   加载插件的flash文件 
            'uploader' : www_host+'/Resource/saveres', //上传的脚本
            'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
            'buttonText' : '选择上传文件',//设置按钮文本
            'multi'    : false,//允许同时上传多张图片
            'uploadLimit' : 10,//一次最多只允许上传10张图片
            'fileTypeDesc' : 'All Files',//只允许上传图像
            'fileTypeExts' : '*.*',//允许上传的图片格式---注意前端判断过，后端必须要判断
            'fileSizeLimit' : '300MB',//限制上传的图片不得超过200KB 
			'cancelImg'		:'/Common/uploadify/uploadify-cancel.png',
			'formData'      : {'someKey' : 'someValue','someOtherKey' : 1},
			'onUploadStart':function(file){
				
				$('#file_upload').uploadify('settings',"formData",{'updetail':$('#updetail').val(),'typeid':$('#typeid').val(),'wid':$('#wid').val()});
			},
            'onUploadSuccess' : function(file, data, response){
                   uploadInfo[i]=data;
                   i++;
				  // alert(data);
				   if(data){
				   		var name2 = $('#updetail').val();
						alert(name2+'添加成功');
						console.log(data);	
						location = www_host+'/Resource/reslist';
				   }
            },
        });
		
		
		$('#videom3ufiles').uploadify({
            'auto'     : false,									//关闭自动上传
            'debug'    : false, 								//开启调试模式
            'width'    : 150, 									//上传按钮的宽
            'height'   : 20,									//上传按钮的高 
            'fileObjName':'videom3ufiles', 						//上传的表单名称  <input type = "file" name = "file_upload" />
            'removeTimeout' : 3,								//文件队列上传完成1秒后删除
            'swf'      : '/js/uploadify/uploadify.swf', 		//   加载插件的flash文件 
            'uploader' : www_host+'/Uploadify/updataM3uFile/', 	//上传的脚本
            'method'   : 'post',								//方法，服务端可以用$_POST数组获取数据
            'buttonText' : '选择上传文件',						//设置按钮文本
            'multi'    : false,									//允许同时上传多张图片
            'uploadLimit' : 10,								     //一次最多只允许上传10张图片
            'fileTypeDesc' : 'All Files',					     //只允许上传图像
            'fileTypeExts' : '*.*',								//允许上传的图片格式---注意前端判断过，后端必须要判断
            'fileSizeLimit' : '300 MB',							//限制上传的图片不得超过200KB 
            'cancelImg'		:'/Common/uploadify/uploadify-cancel.png',
            'formData' : {'name' : 'someValue','someOtherKey' : 1},
			'onUploadStart':function(file){
				$('#videom3ufiles').uploadify('settings',"formData",{'name':$('#updetail').val(),'class':$('#typeid').val()});
			},
            'onUploadSuccess' : function(file, data, response){
                 uploadInfo[i]=data;
                   i++;
				  // alert(data);
				   if(data){
				   	var name1 = $('#updetail').val();
						alert(name1+'添加成功');
						//alert(data);
						console.log(data);	
						location = www_host+'/Resource/reslist';
				   }
            },

        });		
		
		//初始化 上传控件
		 var type = $('#typeid').val();
		     $("#but1").hide();
			 $("#but2").hide();
		     $("#help_pic").hide();
			 $("#help_doc").hide();
			 $("#help_mp4").hide();
			 $("#help_wav").hide();
			 $("#content1").hide();
			 $("#content2").hide();
			 if(type ==2){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_pic").show();
			 }else if(type==3){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_doc").show();
			 }else if(type ==4){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_mp4").show();
			 }else if(type==1){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_wav").show();
			 }else if(type==10){
			 	$("#content2").show();
				$("#but2").show();
			 }else if(type==5){}
			 
		//选择上传类型	 
		$("#typeid").change(function(){
			 $("#but1").hide();
			 $("#but2").hide();
			 $("#help_pic").hide();
			 $("#help_doc").hide();
			 $("#help_mp4").hide();
			 $("#help_wav").hide();
			 $("#content1").hide();
			 $("#content2").hide();
			  var type = $('#typeid').val();
			 if(type ==2){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_pic").show();
			 }else if(type==3){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_doc").show();
			 }else if(type ==4){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_mp4").show();
			 }else if(type==1){
			 	$("#content1").show();
				$("#but1").show();
				$("#help_wav").show();
			 }else if(type==10){
			 	$("#content2").show();
				$("#but2").show();
			 }
		});
		
		
    });
		//上传
	function doUpload1(){
			$('#file_upload').uploadify('upload','*');
	}
	
	function doUpload2(){
		$('#videom3ufiles').uploadify('upload','*');
	}
</script>
</body>
</html>