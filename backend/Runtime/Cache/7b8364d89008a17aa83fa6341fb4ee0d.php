<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php if(($edittag) == "1"): ?>修改课程基本信息 <?php else: ?>添加课程基本信息<?php endif; ?></title>
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

.textarea1{ width:550px;height:114px; }

.mynav{ font-size:16px; margin:10px 0px;}
</style>

</head>
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<?php if(($edittag) == "1"): ?><div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(300 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(300 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<?php else: ?>
	  	<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(301 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(301 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div><?php endif; ?>
		<div class="span10" id="main">
			<br/>
			<?php if(($edittag) == "1"): ?><span class="mynav">当前位置：
				 <a href="<?php echo ($appbasepath); ?>Course/courselist/categoryid/<?php echo ($categoryid); ?>" > <?php echo ($categoryname); ?> ></a>
				 <?php echo ($coursename); ?> > 修改
				 </span>
				<h3>修改课程信息</h3>
			<?php else: ?>
				<h3>添加课程信息</h3><?php endif; ?>
			<form action="<?php echo ($appbasepath); ?>Course/savecourse/" method="POST" enctype="multipart/form-data">
			<?php if(($edittag) == "1"): ?><input type="hidden" name="courseid" value="<?php echo ($coursesvo['courseid']); ?>"><?php endif; ?>
			<label>课程类型</label>
			<select class="select" name="categoryid">
				<?php if(($edittag) == "1"): if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['categoryid']); ?>" <?php if( $cid == $vo['categoryid'] ): ?>selected='selected'<?php endif; ?>> <?php echo ($vo['name']); ?> </option><?php endforeach; endif; else: echo "" ;endif; ?>	
				<?php else: ?>
				  <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['categoryid']); ?>" ><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>	
			</select>
			
			<label>课程内容类型</label>
			<select class="select" name="classfile">
				<option value="0">多节课程内容</option>
				<?php if(($edittag) == "1"): if(is_array($classfile)): $i = 0; $__LIST__ = $classfile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$classfilevo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($classfilevo[0]); ?>" <?php if( $classfileok == $classfilevo['0'] ): ?>selected='selected'<?php endif; ?> ><?php echo ($classfilevo['1']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php else: ?>
					<?php if(is_array($classfile)): $i = 0; $__LIST__ = $classfile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$classfilevo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($classfilevo[0]); ?>"><?php echo ($classfilevo['1']); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>	
			</select>

			<label>课程名称</label>
			<input class="input-xlarge" type="text" placeholder="课程名称" id="name" name="name" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['name']); ?>"<?php endif; ?>>&nbsp;&nbsp;<spqn id="errorname">课程名称不能重复</spqn>
			<label>课程简介</label>
			<textarea id="content" name="content" style="width:650px;height:400px;visibility:hidden;"><?php if(($edittag) == "1"): echo ($coursesvo['brief']); endif; ?></textarea>
			<span id="errorbrief"></span>
			<br/><br/>
			
			<!--
			<label>课程详细介绍</label>	
			<textarea rows = '7' cols='150' name='description' class="textarea1"><?php if(($edittag) == "1"): echo ($coursesvo['description']); endif; ?></textarea>
			-->
			<!--
			<label>关键词</label>
			<input class="input-xlarge" type="text" placeholder="关键词" name="keyword" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['keyword']); ?>"<?php endif; ?>><br/>
			
			<label>课程目标</label>
			<input class="input-xlarge" type="text" placeholder="课程目标" name="target" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['target']); ?>"<?php endif; ?>><br/>
			<label>目标听众</label>
			<input class="input-xlarge" type="text" placeholder="目标听众" name="audience" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['audience']); ?>"<?php endif; ?>><br/>
			<label>课程要求</label>
			<input class="input-xlarge" type="text" placeholder="课程要求" name="claim" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['claim']); ?>"<?php endif; ?>><br/>
			-->
		   
			<lable>作者名称</lable><br/>
			<input class="input-xlarge" type="text" placeholder="作者" id="uid" name="uid" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['userid']); ?>"<?php endif; ?>>
			<a href="<?php echo ($appbasepath); ?>News/selectuser/" class="btn small-btn" id='selectuser'>请选择作者用户</a>
			&nbsp;&nbsp;<spqn id="erroruid">作者名称必须填写，并且是有效注册用户ID.请从用户管理中获得。</spqn><br/>
			<?php if(($edittag) == "1"): ?><input type="hidden" name="srcuid" value="<?php echo ($coursesvo['userid']); ?>" /><?php endif; ?><br/>
			
			<label>课程级别</label>
			<div style="vertical-align:middle;width:100%;height:20px;line-height:20px;">
			<?php if(($edittag) == "1"): ?><input class="input-radio" type="radio" name="level" value="0" <?php if( $coursesvo['level'] == 0): ?>checked='checked'<?php endif; ?> />容易理解&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="1" <?php if( $coursesvo['level'] == 1): ?>checked='checked'<?php endif; ?> />初级&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="2" <?php if( $coursesvo['level'] == 2): ?>checked='checked'<?php endif; ?> />中级&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="3" <?php if( $coursesvo['level'] == 3): ?>checked='checked'<?php endif; ?> />高级&nbsp;&nbsp;
			<?php else: ?>
				<input class="input-radio" type="radio" name="level" value="0"  checked='checked'/>容易理解&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="1" />初级&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="2" />中级&nbsp;&nbsp;
				<input class="input-radio" type="radio" name="level" value="3" />高级&nbsp;&nbsp;<?php endif; ?>
			</div><br/>
			
		    <label>课程评价级别</label>
			<div style="font-size:18pt;vertical-align:middle;width:100%;height:20px;line-height:20px;">
				<span id="s1"  onmouseover="setstar(1)" onmouseout="setstar(1)" title="1星" onclick="clickstar(1)" <?php if($coursesvo['assesslevel'] >= 1): ?>style="color:#FFD119" <?php else: ?> style="color:#999999"<?php endif; ?>>★</span>
				<span id="s2"  onmouseover="setstar(2)" onmouseout="setstar(2)" title="2星" onclick="clickstar(2)" <?php if($coursesvo['assesslevel'] >= 2): ?>style="color:#FFD119" <?php else: ?> style="color:#999999"<?php endif; ?>>★</span>
				<span id="s3"  onmouseover="setstar(3)" onmouseout="setstar(3)" title="3星" onclick="clickstar(3)" <?php if($coursesvo['assesslevel'] >= 3): ?>style="color:#FFD119" <?php else: ?> style="color:#999999"<?php endif; ?>>★</span>
				<span id="s4"  onmouseover="setstar(4)" onmouseout="setstar(4)" title="4星" onclick="clickstar(4)" <?php if($coursesvo['assesslevel'] >= 4): ?>style="color:#FFD119" <?php else: ?> style="color:#999999"<?php endif; ?>>★</span>
				<span id="s5"  onmouseover="setstar(5)" onmouseout="setstar(5)" title="5星" onclick="clickstar(5)" <?php if($coursesvo['assesslevel'] >= 5): ?>style="color:#FFD119" <?php else: ?> style="color:#999999"<?php endif; ?>>★</span>
			</div>
			<input class="input-xlarge" type='hidden' placeholder="级别" style="width:60px" id='assesslevel' name='assesslevel' <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['assesslevel']); ?>"<?php endif; ?> />
			
			<br/>
		   
		   
			<label>课程是否免费</label>
			<div style="vertical-align:middle;width:100%;height:20px;line-height:20px;">
			<?php if(($edittag) == "1"): ?><input class="input-radio" type="radio" id='free0' name="free" value="0" <?php if( $coursesvo['free'] == 0): ?>checked="checked"<?php endif; ?> />免费&nbsp;&nbsp;
				<input class="input-radio" type="radio" id='free1' name="free" value="1" <?php if( $coursesvo['free'] == 1): ?>checked="checked"<?php endif; ?>/>收费&nbsp;&nbsp;
			<?php else: ?>
				<input class="input-radio" type="radio" id='free0' name="free" value="0" checked="checked" />免费&nbsp;&nbsp;
				<input class="input-radio" type="radio" id='free1' name="free" value="1" />收费&nbsp;&nbsp;<?php endif; ?>
			</div><br/>
			
			<div id="inprice"  <?php if( $coursesvo['free'] == 0): ?>style="display:none;"<?php else: ?>style="display:block;"<?php endif; ?>>
			<label>价格</label>
			<input class="input-xlarge" type="text" placeholder="价格" style="width:60px" name="price" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['price']); ?>"<?php endif; ?>>
			<span>&nbsp;商品原价格</span>
			<label>实际价格</label>
			<input class="input-xlarge" type="text" placeholder="实际价格" style="width:60px" name="cheapprice" <?php if(($edittag) == "1"): ?>value="<?php echo ($coursesvo['cheapprice']); ?>"<?php endif; ?>>
			<span>&nbsp;商品优惠打折后，实际价格。(实际价格与商品价格相等时候，为商品原价。实际价格为0时候，商品售价为免费)</span>
			</div><br/>
			<!--
			<label>课程是否发布</label>
			<div styple="vertical-align:middle"
				<?php if(($edittag) == "1"): ?><input class="input-radio" style="vertical-align:middle;" type="radio" name="releases" value="0" <?php if( $coursesvo['releases'] == 0): ?>checked="checked"<?php endif; ?>/>未发布&nbsp;&nbsp;
					<input class="input-radio" style="vertical-align:middle;" type="radio" name="releases" value="1" <?php if( $coursesvo['releases'] == 1): ?>checked="checked"<?php endif; ?>/>已发布&nbsp;&nbsp;
				<?php else: ?>
				    <input class="input-radio" style="vertical-align:middle;" type="radio" name="releases" value="0" checked="checked" />未发布&nbsp;&nbsp;
					<input class="input-radio" style="vertical-align:middle;" type="radio" name="releases" value="1" />已发布&nbsp;&nbsp;<?php endif; ?>
			</div><br/>		
			-->
				
		   <label>上传课程图片 ：<span>请上传640 * 480  或 800 * 600  或  1024 * 768  大小的图片</span></label>
		   <?php if(($edittag) == "1"): ?><p><img src="<?php echo ($coursesvo['picture']); ?>" width="320px" height="191px"></p><?php endif; ?>
		   <input type='file' name='files'>
		   
		     <!-- 上传宣传视频文件
		   <br/><br/>
		    <label>上传课程视频</label>
			<input type='file' name='videofiles' >
			<?php if(($edittag) == "1"): ?><p>guid 串 <?php echo ($coursesvo['spreadvideo']); ?></p><?php endif; ?>
			<a href="<?php echo ($appbasepath); ?>Course/coursevideoview/guid/<?php echo ($coursesvo['spreadvideo']); ?>/courseid/<?php echo ($coursesvo['courseid']); ?>/categoryid/<?php echo ($cid); ?>" class="btn small-btn" id="button">预览</a>
			-->
			
			<br/><br/>
		    <?php if(($edittag) == "1"): ?><lable>更新时间</lable><br/>
			<input class="input-xlarge" type="text" placeholder="更新时间" name="createtime" value="<?php echo ($coursesvo['createtime']); ?>" ><?php endif; ?>
			
			
			<?php if(($readonly == 0) OR ($readonly == 2) ): ?><div class="form-action" align="center">
				<button type="submit" class="btn btn-primary" id="submit">保存</button>
				
			<?php if(($edittag) == "1"): ?><input type="hidden" name="act" value="update">
				<a href="<?php echo ($appbasepath); ?>Course/courselist/categoryid/<?php echo ($cid); ?>" class="btn">取消</a>
			<?php else: ?>
				<input type="hidden" name="act" value="add">
				<a onClick="javascript:history.back(-1)" class="btn" >取消</a><?php endif; ?>
			</div><?php endif; ?>
			</form>
		</div>
	</div>
</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/lhgdialog.min.js"></script>
<script type="text/javascript">
//星级评价
<!--
var nowindex = 1;	//默认几个星
var startnum = 5;	//星的个数
var selectedcolor = "#FFD119";	//选上的颜色
var uselectedcolor = "#999999";    //未选的颜色
function _$(id)
{
return document.getElementById(id);
}
function setstar(index)
{
for(var i=1;i<=index;i++){
_$("s"+i).style.color=selectedcolor;
_$("s"+i).style.cursor="pointer";
}
for(var i=(index+1);i<=startnum;i++){
_$("s"+i).style.color=uselectedcolor;
_$("s"+i).style.cursor="pointer";
}
}

function clickstar(index)
{
_$('assesslevel').value = index;
//alert(index+"星");
}
-->
$(document).ready(function(){ 
   	   $( "#selectuser" ).dialog({
	  		 id:'selectuser',
			 skin:'iblue',					//皮肤
			 content: 'url:/Course/selectuserid/',
			 title:'选择用户',
			 width:500,   
             height:400,
			 fixed:true,
			 left: '50%',
   		     top:1,
			 max:true,   
             min:true, 
             lock:true,
			 close: function(){
				//alert('ok');
    		} 		 
	  });
	  //收费免费事件
	  $('#free1').click(function(){
	  	 $('#inprice').css('display','block');
	  });
	  
	  $('#free0').click(function(){
	  	 $('#inprice').css('display','none');
	  });
	  
	  //提交验证
	  $('form').submit(function(){
	  	 var name = $('#name').val();
		 var content_brief = $('#content').val();
		 var uid = $('#uid').val();
		 if (name.length == 0) {
		 	alert("课程名称不能为空");
			$('#errorname').html("课程名称不能为空");
			$('#errorname').css( "color","red");
			$('#name').focus();
			return false;
//		 }else if(content_brief.length == 0){
//		 	alert("课程简介不能为空");
//		 	$('#errorbrief').html("课程简介不能为空");
//			$('#errorbrief').css( "color","red");
//			$('#errorbrief').focus();
//			return false;
		 }else if(uid.length == 0){
		 	 alert("作者ID不能为空");
		 	$('#erroruid').html("作者ID不能为空");
			$('#erroruid').css( "color","red");
			$('#uid').focus();
			return false;
		 }
		 return true;
	  });
	
   });
</script>
</body>
</html>