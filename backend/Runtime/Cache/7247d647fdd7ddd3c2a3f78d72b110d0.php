<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php if(($edittag) == "1"): ?>编辑管理用户<?php else: ?>添加管理用户<?php endif; ?> 后台管理</title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
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
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

    <?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">新闻管理</a></li>

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<?php else: ?>
	  	<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(18 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

    <?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(18 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">新闻管理</a></li>

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div><?php endif; ?>
		<div class="span10" id="main">
			<h3><?php if(($edittag) == "1"): ?>授权用户权限<?php else: ?>添加管理用户<?php endif; ?></h3>
			<form action="<?php echo ($appbasepath); ?>Admin/saveadminuser/" method="POST">
			<?php if(($edittag) == "1"): ?><input type="hidden" name="adminuserid" value="<?php echo ($adminuser['id']); ?>"><?php endif; ?>
			<label>登录名称</label>
			<input class="input-xlarge" type="text" placeholder="请输入用户名" name="loginname" <?php if(($edittag) == "1"): ?>value="<?php echo ($adminuser['loginname']); ?>" readonly="readonly"<?php endif; ?>>
			<?php if(($edittag) == "1"): else: ?>
			  <label>登录密码</label>
			  <input class="input-xlarge" type="password" placeholder="请输入密码" name="password" >
			  <label>登录密码</label>
			  <input class="input-xlarge" type="password" placeholder="请再次输入密码" name="confirm"><?php endif; ?>
			<br/><br/>
			<label>隶属机构:<span id="company"><?php echo ($adminuser['unitname']); ?></span></label>
			<a class="btn small-btn" id='seleoffunit'>请选择机构</a>&nbsp;&nbsp;<span>如果企业管理员或专家不隶属于任何机构。则默认为0</span>
			<input type="hidden" name="funid" id="funid" <?php if(($edittag) == "1"): ?>value="<?php echo ($adminuser['funid']); ?>" <?php else: ?>value="0"<?php endif; ?>>
			<br/><br/>
			
			<div id=""></div>
			<label>请选择 '用户组' 权限</label>
			<div style="width:80%">
			<?php if(($edittag) == "1"): if(is_array($grouplist)): $i = 0; $__LIST__ = $grouplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox" id='gid_<?php echo ($i); ?>' name='gid[]' value="<?php echo ($vo['gid']); ?>" <?php if( $vo['checked'] == 1): ?>checked="checked"<?php endif; ?> ><?php echo ($vo['gname']); ?>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
			 <?php else: ?>
	            <?php if(is_array($grouplist)): $i = 0; $__LIST__ = $grouplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox" id='gid_<?php echo ($i); ?>' name='gid[]' value="<?php echo ($vo['gid']); ?>" ><?php echo ($vo['gname']); ?>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; endif; ?>
			</div>
			<br/><br/>
			<label>用户授权 '可见菜单':</label>
			<div style="width:90%">
			  <?php echo ($authoName); ?>
			</div>
			
			<br/><br/>
			<?php if(($readonly == 0) OR($readonly == 2) ): ?><div class="form-action">
				<button type="submit" class="btn btn-primary">保存</button>
				<a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/" class="btn">取消</a>
			</div>
			<?php if(($edittag) == "1"): ?><input type="hidden" name="act" value="update"><?php else: ?><input type="hidden" name="act" value="add"><?php endif; endif; ?>
			</form>
		</div>
	</div>
</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/lhgdialog.min.js"></script>
<script type="text/javascript">
   $(function(){
   	   $( "#seleoffunit" ).dialog({
	  		 id:'seleoffunit',
			 skin:'iblue',					//皮肤
			 content: 'url:/Admin/selectOffunit/',
			 title:'选择机构',
			 width:500,   
             height:400,
			 fixed:true,
			 left: '50%',
   		     top:1,
			 max:true,   
             min:true, 
             lock:true,
			 close: function(){} 		 
	  });
	  
	 $("input[id^='gid_']").click(function(){
	 	var arr = new Array();
		var i = 0;
	 	$("[name='gid[]']").each(function(){ 
			if($(this).prop("checked")){
				arr[i] = $(this).val();
				i++;
			}
		});
		var str = JSON.stringify(arr);
		
		
		//from序列化
//		$s =$("[name='gid[]']").serialize()
//	 	alert($s);
	 });
	 
});
</script>  
</body>
</html>