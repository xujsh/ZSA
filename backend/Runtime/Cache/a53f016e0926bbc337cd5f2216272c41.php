<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>后台管理员群组管理 </title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->
<style type="text/css">
</style>
</head>
<body>

<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(20 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

    <?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(20 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">新闻管理</a></li>

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<div class="span10">
		  <h3>群组列表</h3>
		  <p style="font-size:18px;font-family:'微软雅黑'"><a href="<?php echo ($appbasepath); ?>Admingroup/add/">添加</a></p>
		  <table class="table">
			<thead>
			<tr>
				<th>ID</th>
				<th>群组名称</th>
				<th>是否是超级管理组</th>
				<th>是否可编辑</th>
				<!--<th>所具有的权限</th>-->
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["gid"]); ?></td>
					<td><?php echo ($vo["gname"]); ?></td>
					<td><?php if($vo["flag"] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
					<td>
						 <?php if($vo["type"] == 1): ?>只读
						 <?php elseif($vo["type"] == 2): ?>写入
						 <?php elseif($vo["type"] == 3): ?>审核课程
						 <?php else: ?>可编辑<?php endif; ?>
					</td>
					<!--<td width="500"><?php echo ($vo["authority"]); ?></td>-->
					<td>
						<a href="<?php echo ($appbasepath); ?>Admingroup/edit/gid/<?php echo ($vo["gid"]); ?>" class="btn small-btn">编辑</a>
						<?php if($readonly == 0): ?><a href="<?php echo ($appbasepath); ?>Admingroup/del/gid/<?php echo ($vo["gid"]); ?>" class="btn small-btn" id="deletebutton">删除</a><?php endif; ?>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		  </table>
		   <div class="pagination pagination-centered">
		   	<ul>
		  	<?php echo ($show); ?>
			</ul>
		   </div>
		</div>
	  </div>
	</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script>
$(function(){
		$("a[id^='deletebutton']").click(function(){
			if (confirm('确认删除？'))
			{
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$('#categoryid').change(function(){
			$('#form').submit();
		});
		
	});
</script>
</body>
</html>