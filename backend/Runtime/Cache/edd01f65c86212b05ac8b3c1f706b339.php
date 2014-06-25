<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>课程评论  后台管理</title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">

<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->
<style type="text/css">
		.mynav{ font-size:16px; margin:10px 0px;}
		.pagination ul > li > a.cur{
		 background-color:#428BCA;color:#fff;text-decoration:none;
		}
      .table th,.table td{ text-align:center;vertical-align:middle;word-break:break-all}
</style>
</head>
<body>
<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>
  <ul class="nav nav-list">
  	<?php if( $menuarr['sys'] == 1): ?><li class="nav-header">系统管理</li><?php endif; ?>
	<li <?php if( $menuarr[1] == '管理员清单'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 18): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admin/adminuserlist/">管理员清单</a></li>
	<li <?php if( $menuarr[2] == '管理员用户组管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 20): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Admingroup/index/">管理员用户组管理</a></li>
	<li <?php if( $menuarr[3] == '系统数据词典管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 21): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Dict/index/">系统数据词典管理</a></li>
	
	<?php if( $menuarr['user'] == 1): ?><li class="nav-header">学生管理</li><?php endif; ?>
	<li <?php if( $menuarr[4] == '用户列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 101): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>User/userlist/">用户列表</a></li>
	<li <?php if( $menuarr[5] == '用户通知'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 102): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>News/newslist/">用户通知</a></li>
	<!--<li <?php if( $menuarr[6] == '用户购买记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 106): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>BuyCourse/userBuyList/">用户购买记录</a></li>-->
	<!--<li <?php if( $menuarr[7] == '用户收藏记录'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 107): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>UserCollection/index/">用户收藏记录</a></li>-->
	
	<?php if( $menuarr['courses'] == 1): ?><li class="nav-header">课程管理</li><?php endif; ?>
	
	<li <?php if( $menuarr[8] == '课程列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 302): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Course/courselist/'>课程列表</a></li>
	<li <?php if( $menuarr[9] == '课程分类管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 303): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Category/categorylist/'>课程分类管理</a></li>
	<li <?php if( $menuarr[10] == '课程评论管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 304): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Comment/commentList/">课程评论管理</a></li>
	<li <?php if( $menuarr[11] == '搜索关键词管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; ?> <?php if(304 == 310): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Keymanage/getKeywordList/'>搜索关键词管理</a></li>
	
	<?php if( $menuarr['quest'] == 1): ?><li class="nav-header">练习题库管理</li><?php endif; ?>
	<li <?php if( $menuarr[12] == '练习题库管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 305): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>QuesManage/getQuesList/'>练习题库管理</a></li>
	<li <?php if( $menuarr[13] == '类别管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 306): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Quesclass/index/'>类别管理</a></li>
	<li <?php if( $menuarr[14] == '试卷管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 307): ?>class="active"<?php endif; ?>><a href='<?php echo ($appbasepath); ?>Parperback/index/'>试卷管理</a></li>
	
	<?php if( $menuarr['enterprise'] == 1): ?><li class="nav-header">企业管理</li><?php endif; ?>
	<li <?php if( $menuarr[15] == '企业管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 701): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/">企业管理</a></li>

	<?php if( $menuarr['book'] == 1): ?><li class="nav-header">书籍管理</li><?php endif; ?>
	<li <?php if( $menuarr[16] == '书籍管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 501): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Books/booklist/">书籍管理</a></li>
	
	<?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>NewsManage/newslist">新闻管理</a></li>

	<?php if( $menuarr['order'] == 1): ?><li class="nav-header">订单管理</li><?php endif; ?>
	<li <?php if( $menuarr[17] == '订单管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 601): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Orderinfo/index/">订单管理</a></li>

	<?php if( $menuarr['resource'] == 1): ?><li class="nav-header">资源管理</li><?php endif; ?>
	<li <?php if( $menuarr[18] == '资源列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 202): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Resource/reslist/">资源列表</a></li>
	<li <?php if( $menuarr[19] == '资源类型列表'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 204): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Restype/typelist/">资源类型列表</a></li>
	
	<?php if( $menuarr['recommended'] == 1): ?><li class="nav-header">推荐位管理</li><?php endif; ?>
	<li <?php if( $menuarr[20] == '内容推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 402): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/reclist/">内容推荐管理</a></li>
	<li <?php if( $menuarr[21] == '专家推荐管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 403): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/teacherlist/">专家推荐管理</a></li>
	<li <?php if( $menuarr[22] == '推荐位管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 404): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Recommends/taglist/">推荐位管理</a></li>
	
	<?php if( $menuarr['log'] == 1): ?><li class="nav-header">日志管理</li><?php endif; ?>
	<li <?php if( $menuarr[23] == '日志管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 801): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>Logs/index">日志管理</a></li>
     
	<?php if( $menuarr['school'] == 1): ?><li class="nav-header">学校信息收集管理</li><?php endif; ?>
	<li <?php if( $menuarr[24] == '学校信息管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 901): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">学校信息管理</a></li>
    

    <?php if( $menuarr['new'] == 1): ?><li class="nav-header">新闻管理</li><?php endif; ?>
	<li <?php if( $menuarr[25] == '新闻管理'): ?>style=" display:block;" <?php else: ?> style="display:none;"<?php endif; if(304 == 1001): ?>class="active"<?php endif; ?>><a href="<?php echo ($appbasepath); ?>SchoolManage/schoollist">新闻管理</a></li>

	 
	<li class="nav-header">用户退出</li>
	<li><a href="/Admin/adminlogout/">退出</a></li>
  </ul>
</div>
		<div class="span10">
			<h3>课程评论管理</h3>
		<br/>
		 <p style="font-size:18px;font-family:'微软雅黑'">
		    <a href="<?php echo ($appbasepath); ?>Comment/commentList/courseName/<?php echo ($courseName); ?>">全部</a> &nbsp;&nbsp;||&nbsp;&nbsp;
		    <a href="<?php echo ($appbasepath); ?>Comment/commentListoff/courseName/<?php echo ($courseName); ?>">待审核的</a> &nbsp;&nbsp;||&nbsp;&nbsp;
			<a href="<?php echo ($appbasepath); ?>Comment/commentListon/courseName/<?php echo ($courseName); ?>">审核通过的</a>
			<a href="<?php echo ($appbasepath); ?>Comment/itivewordList/" style=" float:right; margin-right:50px;">敏感词管理</a>
			</p>
		<div>
		<form name="form" id="form" action="<?php echo ($appbasepath); ?>Comment/seachList/" method="POST" enctype="multipart/form-data">
			课程：
			<input class="input-xlarge" type="text" placeholder="请输入课程名称" id='courseName' name="courseName" value="<?php echo ($courseName); ?>">
			<button type="submit" id='sub' class="btn btn-primary">搜索</button>
		</form>	 
		</div>
		  <table class="table">
			<thead>
			<tr>
				<th>ID</th>
				<!--<th>发布用户</th>-->
				<!--<th>课程</th>-->
				<th>评论标题</th>
				<th>评论内容</th>
				<th>创建时间</th>
				<th>审核状态</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["commentid"]); ?></td>
						<!--<td><?php echo ($vo["username"]); ?></td>-->
						<!--<td><?php echo ($vo["came"]); ?></td>-->
						<td><a href="<?php echo ($appbasepath); ?>Comment/commentInfo/comentid/<?php echo ($vo["commentid"]); ?>"><?php echo ($vo["ctitle"]); ?></a></td>
						<td width="40%"><a href="<?php echo ($appbasepath); ?>Comment/commentInfo/comentid/<?php echo ($vo["commentid"]); ?>"><?php echo ($vo["content"]); ?></a></td>
						<td><?php echo ($vo["createtime"]); ?></td>
						<td>
						<?php if(($readonly == 3)OR($readonly == 0)): if($vo['releases'] == 0): ?><!--<a href="<?php echo ($appbasepath); ?>Comment/setCommentRele/commentid/<?php echo ($vo["commentid"]); ?>/releases/1/methods/<?php echo ($methods); ?>/page/<?php echo ($page); ?>" class="btn small-btn" id="button<?php echo ($vo["commentid"]); ?>">通过</a>-->
								<a class="btn small-btn" id="butreleases<?php echo ($vo["commentid"]); ?>" data-vale='{"id":"<?php echo $vo['commentid'] ?>","rele":"1"}'>通过</a><?php endif; ?>
							<?php if($vo['releases'] == 1): ?><!--<a href="<?php echo ($appbasepath); ?>Comment/setCommentRele/commentid/<?php echo ($vo["commentid"]); ?>/releases/0/methods/<?php echo ($methods); ?>/page/<?php echo ($page); ?>" class="btn small-btn" id="button<?php echo ($vo["commentid"]); ?>">禁用</a>-->
								<a class="btn small-btn" id="butreleases<?php echo ($vo["commentid"]); ?>" data-vale='{"id":"<?php echo $vo['commentid'] ?>","rele":"0"}'>禁用</a><?php endif; ?>
						<?php else: ?>
							<?php if($vo['releases'] == 0): ?>未审核通过<?php endif; ?>
							<?php if($vo['releases'] == 1): ?>审核通过<?php endif; endif; ?>
						</td>
					<td>
						<?php if($readonly == 0): ?><a href="<?php echo ($appbasepath); ?>Comment/del/commentid/<?php echo ($vo["commentid"]); ?>/" class="btn small-btn" id="deletebutton<?php echo ($vo["commentid"]); ?>">删除</a><?php endif; ?>				
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
<script type="text/javascript">	
$(document).ready(function(){ 
		$("a[id^='deletebutton']").click(function(){
//			console.log("lsdjalfasf");//控制台输出
//			return false;			  //断点执行
		
			if (confirm('确认删除？'))
			{
				return true;
			}
			else
			{
				return false;
			}
			
		});
		
		//审核按钮
		$("a[id^='butreleases']").click(function(){
			 var but = $(this);									//当前点击对象
			 var id = $(this).data('vale').id;					//获得id
			 var rele = $(this).data('vale').rele;				//获得动作是审核通过，还是未通过
			 	$.getJSON( "/Comment/setCommentReleAJAX/?commentid="+id+"&releases="+rele,function(json){
					//console.log(json.ret);
					if (json.ret) {
							var data = parseInt(json.retinfo.releases);
							if (data) {
								but.text('禁用');
								var obj = new Object();
								obj.id = id;
								obj.rele = 0;
								but.data('vale', obj);
								
							}
							else {
								but.text('通过');
								var obj = new Object();
								obj.id = id;
								obj.rele = 1;
								but.data('vale', obj);
							}
					}else alert('更新错误');
					//console.log(data);
			});
		});
		
		
});

</script>
</body>
</html>