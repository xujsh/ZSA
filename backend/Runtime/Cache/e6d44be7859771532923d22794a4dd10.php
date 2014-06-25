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
			<h3>填写开发者基本资料</h3>
			<form action="<?php echo ($appbasepath); ?>Offunit/saveOffunit/" method="POST" enctype="multipart/form-data">
				

			<label>开发者类型：</label>


				
			

			<div class="form-action">
				<button type="submit" id='sub1' class="btn btn-primary">个人</button>
				<button type="submit" id='sub2' class="btn btn-primary">公司</button>
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