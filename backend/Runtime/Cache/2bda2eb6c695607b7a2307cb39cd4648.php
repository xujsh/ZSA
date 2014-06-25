<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>课程信息后台管理</title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->
<style type="text/css">
	.mynav{ font-size:16px; margin:10px 0px;}
	.pagination ul > li > a.cur{
		 background-color:#428BCA;color:#fff;text-decoration:none;
	}
	.table th,.table td{ text-align:center;vertical-align:middle;}
</style>
</head>
<body>
<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(302 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(302 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<div class="span10">
		 <br/>
		  <form name="form" id="form" action="<?php echo ($appbasepath); ?>Course/courselist/" method="POST" enctype="multipart/form-data">
		<label>类型：</label>
		<select class="select" name="categoryid" id="categoryid">
		  	  <option value='0'>全部</option>
		  	  <?php if(is_array($categoryList)): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$catvo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($catvo['categoryid']); ?>"  <?php if( $categoryid == $catvo['categoryid']): ?>selected="selected"<?php endif; ?>><?php echo ($catvo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		  </form>
		  <span class="mynav">当前位置：<?php echo ($categoryname); ?></span>
		  <br/><br/>
		  <p style="font-size:18px;font-family:'微软雅黑'"><a href="<?php echo ($appbasepath); ?>Course/addcourse/">添加课程</a></p>
		  <table class="table">
			<thead>
			<tr>
				<!--<th>序号</th>-->
				<th>ID</th>
				<th>课程类型</th>
				<th>课程名称</th>
				<th>创建课程作者</th>
				<th>售价</th>
				<th>实际售价</th>
				<th>审核发布状态</th>
				<th>总时长</th>
				<th width="110">更新时间</th>
				<th width="345">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($courselist)): $i = 0; $__LIST__ = $courselist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<!--<td><?php echo ($vo["order"]); ?></td>-->
					<td><?php echo ($vo["courseid"]); ?></td>
					<td><?php echo ($vo["categoryname"]); ?></td>
					<td><?php echo ($vo["name"]); ?></td>
					<td><?php echo ($vo["username"]); ?></td>
					<td><?php echo ($vo["price"]); ?></td>
					<td><?php echo ($vo["cheapprice"]); ?></td>
					<td>
						<?php if(($readonly == 3)OR($readonly == 0)): if($vo['releases'] == 0): ?><a href="<?php echo ($appbasepath); ?>Course/setreleases/courseid/<?php echo ($vo["courseid"]); ?>/releases/1/categoryid/<?php echo ($vo['categoryid']); ?>" class="btn small-btn" id="button">通过</a><?php endif; ?>
							<?php if($vo['releases'] == 1): ?><a href="<?php echo ($appbasepath); ?>Course/setreleases/courseid/<?php echo ($vo["courseid"]); ?>/releases/0/categoryid/<?php echo ($vo['categoryid']); ?>" class="btn small-btn" id="button">禁用</a><?php endif; ?>
						<?php else: ?>
							<?php if($vo['releases'] == 0): ?>未发布<?php endif; ?>
							<?php if($vo['releases'] == 1): ?>已发布<?php endif; endif; ?>
					</td>
					<td><?php echo ($vo["duration"]); ?></td>
					<td><?php echo ($vo["createtime"]); ?></td>
					<td>
						<a href="<?php echo ($appbasepath); ?>Section/sectionslist/courseid/<?php echo ($vo["courseid"]); ?>/categoryid/<?php echo ($vo['categoryid']); ?>" class="btn small-btn" id="button">章节管理</a>
						<a href="<?php echo ($appbasepath); ?>User/userone/uid/<?php echo ($vo["userid"]); ?>" class="btn small-btn" id="button">作者详情</a>
						<a href="<?php echo ($appbasepath); ?>Course/editcourse/courseid/<?php echo ($vo["courseid"]); ?>/categoryid/<?php echo ($vo['categoryid']); ?>" class="btn small-btn">修改</a>
						<?php if($readonly == 0): ?><a href="<?php echo ($appbasepath); ?>Course/delcourse/<?php echo ($vo["courseid"]); ?>" class="btn small-btn" id="deletebutton{vo.courseid}">删除</a><?php endif; ?>
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
			if (confirm('确认删除课程？'))
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