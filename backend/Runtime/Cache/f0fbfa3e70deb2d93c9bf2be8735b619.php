<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>机构列表 后台管理</title>
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
		  <h3>机构列表</h3>
		<div>
			<form action="/Admin/selectOffunit/" method="POST" enctype="multipart/form-data">
				<select name='checkField'>
					<option value='unitname' <?php if(($checkField) == "unitname"): ?>selected = 'selected'<?php endif; ?>>机构名称</option>
				<input class="input-xlarge" type="text" placeholder="请输入机构名称" id='seachValue' name="seachValue" value="<?php echo ($seachValue); ?>">
				<button type="submit" id='sub' class="btn btn-primary">搜索</button>
			</form>
		</div>
		  <table class="table">
			<thead>
			<tr>
				<th>选择</th>
				<th>机构名称</th>
				<th>注册时间</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td>
					<input type="radio" name="offunid" id='offunid<?php echo ($vo["unid"]); ?>' value="<?php echo ($vo["unid"]); ?>">
					<input type="hidden" id="name<?php echo ($vo["unid"]); ?>" value="<?php echo ($vo["unitname"]); ?>">
					</td>
					<td ><?php echo ($vo["unitname"]); ?></td>
					<td ><?php echo ($vo["createtime"]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		  </table>
		</div>
	</div>
</div>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script>
	var offunid = 0;
	var unitname ='';
$(document).ready(function(){ 
	$("input[id^='offunid']").change(function(){
		offunid = $(this).val();
		unitname = $(this).next().val();
	})
});
	
	var api = frameElement.api, W = api.opener;
	api.button({
	    id:'valueOk',
	    name:'确定',
	    callback:ok
	});
    function ok(){
      W.document.getElementById('funid').value = offunid;
	  W.document.getElementById('company').innerHTML = unitname;
    };
</script>
</body>
</html>