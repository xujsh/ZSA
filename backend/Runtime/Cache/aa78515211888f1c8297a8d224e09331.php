<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>成功信息</title>
<style>
	.tishi{width:542px;height:396px;margin:0 auto;border:1px solid #dee9ee;}
	.jump{margin-left:50px;font-size:14px;}
</style>
</head>
<body>
<div class="all" id="all">
	<div class="tishi" id="tishi">
		<span style="display:block;margin-top:96px;margin-left:233px;"> <img src="/images/success.png"></span>
		<span style="display:block;margin-top:30px;text-align:center;color:#027e46;font-size:36px;"><?php echo($message); ?></span>
		<p class="jump">
		页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">点击跳转<?php echo ($message); ?></a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
		</p>
	</div>	
</div>
</body>
<script>
	
	var allheight = window.screen.height;
	//document.getElementById("all").style.height=allheight+"px";
	var heighttop = allheight-396;
	document.getElementById('tishi').style.marginTop=heighttop/3+"px";

	(function(){
	var wait = document.getElementById('wait'),href = document.getElementById('href').href;
	var interval = setInterval(function(){
		var time = --wait.innerHTML;
		if(time == 0) {
			location.href = href;
			clearInterval(interval);
		};
	}, 1000);
	})();
</script>
</html>