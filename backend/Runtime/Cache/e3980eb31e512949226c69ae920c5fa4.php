<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>基本资料</title>

	<link href="http://cdn.bootcss.com/twitter-bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://cdn.bootcss.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/js/front/flat-ui.css" rel="stylesheet">

<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="/static/js/html5.js"></script><![endif]-->
<style>


</style>
</head>
<body>
<div class="container-fluid">
	<div class="row-fluid">


	  	<div class="span2">
	<div style="margin-top:10px;font-size:12px; font-weight:600;">当前用户  <?php echo ($adminloginname); ?></div>


			<ul class="nav nav-pills nav-stacked">
	<li class="nav-header"></li>
	<li><a href="">基本信息</a></li>
	<li><a href="">身份信息</a></li>
  </ul>
</div>

		<div class="span10" id="main">
			<h3>基本资料</h3>
			<form action="<?php echo ($appbasepath); ?>Offunit/saveOffunit/" method="POST" enctype="multipart/form-data">
				

			<label>开发者类型：		
									<input class="input-radio" type="radio" id='identity0' name="identity" value="0" checked="checked"/>个人&nbsp;&nbsp;

					<input class="input-radio" type="radio" id='identity1' name="identity" value="1" />公司&nbsp;&nbsp;
		
			</label>


				
				
			<label>开发者姓名：	
										</label>
			<input class="input-xlarge" type="text" placeholder="请输入邮箱地址" id='address' name="address" <?php if(($edittag) == "1"): ?>value="<?php echo ($offunitone['address']); ?>"<?php endif; ?> <?php if($nounitname == 1): ?>readonly="readonly"<?php endif; ?>><span id='em'></span>
		
			<label>所在地区：</label>
			<select name="offtype">
				<option value="0" <?php if($offunitone['offtype'] == 0): ?>selected="selected"<?php endif; ?>>北京</option>
				<option value="1" <?php if($offunitone['offtype'] == 1): ?>selected="selected"<?php endif; ?>>天津</option>
			</select>
			<select name="offtype">
				<option value="0" <?php if($offunitone['offtype'] == 0): ?>selected="selected"<?php endif; ?>>海淀</option>
				<option value="1" <?php if($offunitone['offtype'] == 1): ?>selected="selected"<?php endif; ?>>和平区</option>
			</select>
		<label>邮箱：</label>
			<input class="input-xlarge" type="text" placeholder="请输入邮箱地址" id='address' name="address" <?php if(($edittag) == "1"): ?>value="<?php echo ($offunitone['address']); ?>"<?php endif; ?> <?php if($nounitname == 1): ?>readonly="readonly"<?php endif; ?>><span id='em'></span>
			
			<label>电话: <span>必填项。</span></label>
			<input class="input-xlarge" type="text" placeholder="请输入电话" id='email' name="email" <?php if(($edittag) == "1"): ?>value="<?php echo ($offunitone['email']); ?>"<?php endif; ?> <?php if($nounitname == 1): ?>readonly="readonly"<?php endif; ?>><span id='email'></span>
			
	
			<label>聊天工具：</label>

		

			<div class="form-action">
				<button type="submit" id='sub' class="btn btn-primary">保存</button>
				<a href="<?php echo ($appbasepath); ?>Offunit/offunitlist/" class="btn">取消</a>
			</div>

			
			</form>
		</div>
	</div>
</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script type='text/javascript'>
		$(function(){
			
		})
</script>
</body>
</html>