<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>用户信息列表 后台管理</title>
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="<?php echo ($appbasepath); ?>css/scojs.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->
</head>
<body>
<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span10">
		  <h3>用户列表</h3>
		<div>
			<form action="/News/selectuser/" method="POST" enctype="multipart/form-data">
				<select name='checkField'>
					<option value='userid' <?php if(($checkField) == "userid"): ?>selected = 'selected'<?php endif; ?>>用户ID</option>
					<option value='username' <?php if(($checkField) == "username"): ?>selected = 'selected'<?php endif; ?>>用户名</option>
					<option value='email' <?php if(($checkField) == "email"): ?>selected = 'selected'<?php endif; ?>>邮箱</option></select>
				<input class="input-xlarge" type="text" placeholder="请输入选择数据" id='seachValue' name="seachValue" value="<?php echo ($seachValue); ?>">
				<button type="submit" id='sub' class="btn btn-primary">搜索</button>
			</form>
		</div>
		  <table class="table">
			<thead>
			<tr>
				<th>选择</th>
				<th>头像</th>
				<th>姓名</th>
				<th>email</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td>
					<input type="radio" name="userid" id='userid<?php echo ($vo["userid"]); ?>' value="<?php echo ($vo["userid"]); ?>">
					<input type="hidden" id="name<?php echo ($vo["userid"]); ?>" value="<?php echo ($vo["username"]); ?>">
					</td>
					<td><img src='<?php echo ($vo["picture"]); ?>' width='60px' height='60px' ></td>
					<td ><?php echo ($vo["username"]); ?></td>
					<td ><?php echo ($vo["email"]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		  </table>
		</div>
	</div>
</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script>
	var userid = 0;
	var username ='系统通知';
$(document).ready(function(){ 
	$("input[id^='userid']").change(function(){
		userid = $(this).val();
		username = $(this).next().val();
	})
});
	
	var api = frameElement.api, W = api.opener;
	api.button({
	    id:'valueOk',
	    name:'确定',
	    callback:ok
	});
    function ok(){
      W.document.getElementById('userid').value = userid;
	  W.document.getElementById('newsuser').innerHTML = username;
    };
</script>
</body>
</html>