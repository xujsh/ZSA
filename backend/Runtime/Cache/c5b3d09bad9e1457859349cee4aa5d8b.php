<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="LayoutIt! - Bootstrap可视化布局系统">
<meta name="description" content="LayoutIt! 可拖放排序在线编辑的Bootstrap可视化布局系统">
<meta name="keywords" content="可视化,布局,系统">
<link type="text/css" rel="stylesheet" href="/css/topdh.css">
<title>门户编辑</title>
<style>
	.devpreview .demo .column 
	#login a:link{color:#666666;}
	.box box-element ui-draggable{border:1px solid red;}
</style>
<!-- Le styles -->
<link href="/images/boot/bootstrap-combined.css" rel="stylesheet">
<link href="/images/boot/layoutit.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
	<![endif]-->
	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="/images/boot/favicon.png">
	<script type="text/javascript" src="/images/boot/jquery-2.js"></script>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="/images/boot/bootstrap.js"></script>
	<script type="text/javascript" src="/images/boot/jquery-ui.js"></script>
	<script type="text/javascript" src="/images/boot/jquery.js"></script>
	<script type="text/javascript" src="/images/boot/jquery_002.js"></script>
	<script type="text/javascript" src="/images/boot/ckeditor.js"></script>
	<style>.cke{visibility:hidden;}</style>
	<script type="text/javascript" src="/images/boot/config_002.js"></script>
	<script type="text/javascript" src="/images/boot/scripts.js"></script>
	<script src="/images/boot/config.js" type="text/javascript"></script>
	<link href="/images/boot/editor_gecko.css" type="text/css" rel="stylesheet">
	<script src="/images/boot/zh-cn.js" type="text/javascript"></script>
	<script src="/images/boot/styles.js" type="text/javascript"></script></head>
<body style="min-height: 541px; cursor: auto;" class="edit">
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="brand" href="#">门户编辑</a>
      <div class="nav-collapse collapse">
      	<ul class="nav" id="menu-layoutit">
          <li class="divider-vertical"></li>
          <li>
            <div class="btn-group" data-toggle="buttons-radio">
			  <button type="button" id="edit" class="btn btn-primary active"><i class="icon-edit icon-white"></i>编辑</button>
			  <button type="button" class="btn btn-primary" id="devpreview"><i class="icon-eye-close icon-white"></i>布局编辑</button>
			  <button type="button" class="btn btn-primary" id="sourcepreview"><i class="icon-eye-open icon-white"></i>预览</button>
            </div>
            <div class="btn-group">
   			<button class="btn btn-primary" role="button" data-toggle="modal" data-target="#shareModal"><i class="icon-share icon-white"></i>保存</button>
              <button class="btn btn-primary" href="#clear" id="clear"><i class="icon-trash icon-white"></i>清空</button>
            </div>
            <div class="btn-group">
				<button class="btn btn-primary" href="#undo" id="undo"><i class="icon-arrow-left icon-white"></i>撤销</button>
				<button class="btn btn-primary" href="#redo" id="redo"><i class="icon-arrow-right icon-white"></i>重做</button>
			</div>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="">
      <div class="sidebar-nav">
        <ul class="nav nav-list accordion-group">
          <li class="nav-header">
            <div class="pull-right popover-info"><i class="icon-question-sign "></i>
              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">功能</h3>
                <div class="popover-content">在这里设置你的栅格布局, 栅格总数默认为12, 用空格分割每列的栅格值, 如果您需要了解更多信息，请访问<a target="_blank" href="http://twitter.github.io/bootstrap/scaffolding.html#gridSystem">Bootstrap栅格系统.</a></div>
              </div>
            </div>
          <i class="icon-plus icon-white"></i> 布局设置 </li>
          <li style="display: none;" class="rows" id="estRows">
            <div class="lyrow ui-draggable"><a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="12" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span12 column"></div>
                </div>
              </div>
            </div>
            <div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="6 6" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span6 column"></div>
                  <div class="span6 column"></div>
                </div>
              </div>
            </div>
			<!-----新添加样式363------------->
			<div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="3 6 3" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span3 column"></div>
                  <div class="span6 column"></div>
				  <div class="span3 column"></div>
                </div>
              </div>
            </div>
			<!--------//新添加样式结束--------------------->
            <div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="8 4" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span8 column"></div>
                  <div class="span4 column"></div>
                </div>
              </div>
            </div>
            <div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="4 4 4" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span4 column"></div>
                  <div class="span4 column"></div>
                  <div class="span4 column"></div>
                </div>
              </div>
            </div>
            <div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <div class="preview">
                <input value="2 6 4" type="text">
              </div>
              <div class="view">
                <div class="row-fluid clearfix">
                  <div class="span2 column"></div>
                  <div class="span6 column"></div>
                  <div class="span4 column"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <!--<ul class="nav nav-list accordion-group">
          <li class="nav-header"><i class="icon-plus icon-white"></i> 基本CSS
            <div class="pull-right popover-info"><i class="icon-question-sign "></i>
              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>
                <div class="popover-content">这里提供了一系列基本元素样式，你可以通过区块右上角的编辑按钮修改样式设置。如需了解更多信息，请访问<a target="_blank" href="http://twitter.github.io/bootstrap/base-css.html">基本CSS.</a></div>
              </div>
            </div>
          </li>
          <li style="display: list-item;" class="boxes" id="elmBase">
            <div class="box box-element ui-draggable" style="border:1px solid red;"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> 
            	 <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">对齐 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="text-left">靠左</a></li>
                <li class=""><a href="#" rel="text-center">居中</a></li>
                <li class=""><a href="#" rel="text-right">靠右</a></li>
              </ul>
              </span> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">标记 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="muted">禁用</a></li>
                <li class=""><a href="#" rel="text-warning">警告</a></li>
                <li class=""><a href="#" rel="text-error">错误</a></li>
                <li class=""><a href="#" rel="text-info">提示</a></li>
                <li class=""><a href="#" rel="text-success">成功</a></li>
              </ul>
              </span></span>
              <div class="preview">标题栏</div>
              <div class="view">
                <h3 contenteditable="true">h3. 这是一套可视化布局系统.</h3>
              </div>
            </div>
            <div class="lyrow ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">对齐 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="text-left">靠左</a></li>
                <li class=""><a href="#" rel="text-center">居中</a></li>
                <li class=""><a href="#" rel="text-right">靠右</a></li>
              </ul>
              </span> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">标记 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="muted">禁用</a></li>
                <li class=""><a href="#" rel="text-warning">警告</a></li>
                <li class=""><a href="#" rel="text-error">错误</a></li>
                <li class=""><a href="#" rel="text-info">提示</a></li>
                <li class=""><a href="#" rel="text-success">成功</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="lead">Lead</a> </span>


              <div class="preview">段落</div>
              <div class="view" contenteditable="true">
                <p><em>Git</em>是一个分布式的版本控制系统，最初由<b>Linus Torvalds</b>编写，用作Linux内核代码的管理。在推出后，Git在其它项目中也取得了很大成功，尤其是在Ruby社区中。 </p>
              </div>
            </div>
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button></span>
              <div class="preview">地址</div>
              <div class="view">
                <address contenteditable="true">
                <strong>Twitter, Inc.</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                <abbr title="Phone">P:</abbr> (123) 456-7890
                </address>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <a class="btn btn-mini" href="#" rel="pull-right">右对齐</a> </span>
              <div class="preview">引用块</div>
              <div class="view clearfix">
                <blockquote contenteditable="true">
                  <p>github是一个全球化的开源社区.</p>
				  <p>github是一个全球化的开源社区.</p>
                  <small>关键词 <cite title="Source Title">开源</cite></small> </blockquote>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="unstyled">无样式</a> <a class="btn btn-mini" href="#" rel="inline">嵌入</a> </span>
              <div class="preview">无序列表</div>
              <div class="view">
                <ul contenteditable="true">
                  <li>新闻资讯</li>
                  <li>体育竞技</li>
                  <li>娱乐八卦</li>
                  <li>前沿科技</li>
                  <li>环球财经</li>
                  <li>天气预报</li>
                  <li>房产家居</li>
                  <li>网络游戏</li>
                </ul>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="unstyled">无样式</a> <a class="btn btn-mini" href="#" rel="inline">嵌入</a> </span>
              <div class="preview">有序列表</div>
              <div class="view">
                <ol contenteditable="true">
                  <li>新闻资讯</li>
                  <li>体育竞技</li>
                  <li>娱乐八卦</li>
                  <li>前沿科技</li>
                  <li>环球财经</li>
                  <li>天气预报</li>
                  <li>房产家居</li>
                  <li>网络游戏</li>
                </ol>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="dl-horizontal">竖向对齐</a> </span>
              <div class="preview">详细描述</div>
              <div class="view">
                <dl contenteditable="true">
                  <dt>Rolex</dt>
                  <dd>劳力士创始人为汉斯.威尔斯多夫，1908年他在瑞士将劳力士注册为商标。</dd>
                  <dt>Vacheron Constantin</dt>
                  <dd>始创于1775年的江诗丹顿已有250年历史，</dd>
                  <dd>是世界上历史最悠久、延续时间最长的名表之一。</dd>
                  <dt>IWC</dt>
                  <dd>创立于1868年的万国表有“机械表专家”之称。</dd>
                  <dt>Cartier</dt>
                  <dd>卡地亚拥有150多年历史，是法国珠宝金银首饰的制造名家。</dd>
                </dl>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="table-striped">条纹</a></li>
                <li class=""><a href="#" rel="table-bordered">边框</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="table-hover">鼠标指示</a> <a class="btn btn-mini" href="#" rel="table-condensed">紧凑</a> </span>
              <div class="preview">表格</div>
              <div class="view">
                <table class="table" contenteditable="true">
                  <thead>
                    <tr>
                      <th>编号</th>
                      <th>产品</th>
                      <th>交付时间</th>
                      <th>状态</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>TB - Monthly</td>
                      <td>01/04/2012</td>
                      <td>Default</td>
                    </tr>
                    <tr class="success">
                      <td>1</td>
                      <td>TB - Monthly</td>
                      <td>01/04/2012</td>
                      <td>Approved</td>
                    </tr>
                    <tr class="error">
                      <td>2</td>
                      <td>TB - Monthly</td>
                      <td>02/04/2012</td>
                      <td>Declined</td>
                    </tr>
                    <tr class="warning">
                      <td>3</td>
                      <td>TB - Monthly</td>
                      <td>03/04/2012</td>
                      <td>Pending</td>
                    </tr>
                    <tr class="info">
                      <td>4</td>
                      <td>TB - Monthly</td>
                      <td>04/04/2012</td>
                      <td>Call in to confirm</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="form-inline">嵌入</a> </span>
              <div class="preview">提交表单</div>
              <div class="view">
				<form>
					<fieldset>
					<legend contenteditable="true">表单项</legend>
					<label contenteditable="true">表签名</label>
					<input placeholder="Type something…" type="text">
					<span class="help-block" contenteditable="true">这里填写帮助信息.</span>
					<label class="checkbox" contenteditable="true">
					<input type="checkbox"> 勾选同意
					</label>
					<button type="submit" class="btn" contenteditable="true">提交</button>
					</fieldset>
				</form>
              </div>
            </div>

			<div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="form-inline">嵌入</a> </span>
              <div class="preview">留言板</div>
              <div class="view">
				<form>
					<fieldset>
					<textarea cols="50" rows="5"></textarea>
					<br>
					<button type="submit" class="btn" contenteditable="true">提交</button>
					</fieldset>
				</form>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="form-inline">嵌入</a> </span>
              <div class="preview">搜索框</div>
              <div class="view">
                <form class="form-search">
                  <input class="input-medium search-query" type="text">
                  <button type="submit" class="btn" contenteditable="true">查找</button>
                </form>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> </span>
              <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button></span>
              <div class="preview">纵向表单</div>
              <div class="view">
                <form class="form-horizontal">
                  <div class="control-group">
                    <label class="control-label" for="inputEmail" contenteditable="true">邮箱</label>
                    <div class="controls">
                      <input id="inputEmail" placeholder="Email" type="text">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword" contenteditable="true">密码</label>
                    <div class="controls">
                      <input id="inputPassword" placeholder="Password" type="password">
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">
                      <label class="checkbox" contenteditable="true">
                        <input type="checkbox">
                        Remember me </label>
                      <button type="submit" class="btn" contenteditable="true">登陆</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="btn-primary">重点</a></li>
                <li class=""><a href="#" rel="btn-info">信息</a></li>
                <li class=""><a href="#" rel="btn-success">成功</a></li>
                <li class=""><a href="#" rel="btn-warning">提醒</a></li>
                <li class=""><a href="#" rel="btn-danger">危险</a></li>
                <li class=""><a href="#" rel="btn-inverse">反转</a></li>
                <li class=""><a href="#" rel="btn-link">链接</a></li>
              </ul>
              </span> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">尺寸 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class=""><a href="#" rel="btn-large">大</a></li>
                <li class="active"><a href="#" rel="">中</a></li>
                <li class=""><a href="#" rel="btn-small">小</a></li>
                <li class=""><a href="#" rel="btn-mini">微型</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="btn-block">通栏</a> <a class="btn btn-mini" href="#" rel="disabled">禁用</a> </span>
              <div class="preview">按钮</div>
              <div class="view">
                <button class="btn" type="button" contenteditable="true">按钮</button>
              </div>
            </div>

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="img-rounded">圆角</a></li>
                <li class=""><a href="#" rel="img-circle">圆圈</a></li>
                <li class=""><a href="#" rel="img-polaroid">相框</a></li>
              </ul>
              </span> </span>
              <div class="preview">图片</div>
              <div class="view"> <img alt="140x140" src="/images/boot/a.jpg"> </div>
            </div>
			<!----------新添加----------------->
			<!--<div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="img-rounded">圆角</a></li>
                <li class=""><a href="#" rel="img-circle">圆圈</a></li>
                <li class=""><a href="#" rel="img-polaroid">相框</a></li>
              </ul>
              </span> </span>
              <div class="preview">头部图片</div>
              <div class="view"> <img alt="140x140" src="/images/boot/header.jpg"> </div>
            </div>
			添加结束------>
          <!---</li>
        </ul>-->
               <ul class="nav nav-list accordion-group">
          <li class="nav-header"><i class="icon-plus icon-white"></i> 主题设置
            <div class="pull-right popover-info"><i class="icon-question-sign "></i>
              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>
                <div class="popover-content">拖放组件到布局框内. 拖入后你可以设置组件样式. 查看这里获取更多帮助 <a target="_blank" href="http://twitter.github.io/bootstrap/components.html">Components.</a></div>
              </div>
            </div>
          </li>
          <li style="display: none;" class="boxes" id="elmComponents">

        		<div class="preview">红色</div>
			    <div class="preview">白色</div>
                <div class="preview">绿色</div>
				<div class="preview">浅绿色</div>
				<div class="preview">橙色</div>
				<div class="preview">紫色</div>
				<div class="preview">灰色</div>
				<div class="preview">白色</div>
				<div class="preview">黑色</div>
				<div class="preview">浅红色</div>
				<div class="preview">粉色</div>
				<div class="preview">橄榄色</div>
				
				<div class="preview">校园主题1</div>
				<div class="preview">校园主题2</div>
				<div class="preview">校园主题3</div>
				<div class="preview">校园主题4</div>
				<div class="preview">校园主题5</div>
				<div class="preview">校园主题6</div>
				<div class="preview">校园主题7</div>
				<div class="preview">校园主题8</div>
				<div class="preview">校园主题9</div>
				<div class="preview">校园主题10</div>
				
         </li>
        </ul>
        <ul class="nav nav-list accordion-group">
          <li class="nav-header"><i class="icon-plus icon-white"></i> 应用组件
            <div class="pull-right popover-info"><i class="icon-question-sign "></i>
              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>
                <div class="popover-content">拖放组件到布局框内. 拖入后你可以设置组件样式. 查看这里获取更多帮助 <a target="_blank" href="http://twitter.github.io/bootstrap/components.html">Components.</a></div>
              </div>
            </div>
          </li>
          <li style="display: none;" class="boxes" id="elmComponents">

            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">果实邮件</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">云应用组件</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
              <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">企业管理课程</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
<div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">集邮趣谈</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
            
         </li>
        </ul>
    
        <ul class="nav nav-list accordion-group">
          <li class="nav-header"><i class="icon-plus icon-white"></i> 自定义组件
            <div class="pull-right popover-info"><i class="icon-question-sign "></i>
              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>
                <div class="popover-content">拖放组件到布局框内. 拖入后你可以设置组件样式. 查看这里获取更多帮助 <a target="_blank" href="http://twitter.github.io/bootstrap/components.html">Components.</a></div>
              </div>
            </div>
          </li>
          <li style="display: none;" class="boxes" id="elmComponents">
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">方向<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">横向</a></li>
                <li class=""><a href="#" rel="btn-group-vertical">竖向</a></li>
              </ul>
              </span> </span>
              <div class="preview">标题版块</div>
              <div class="view">
                <div class="btn-group">
                  <button class="btn" type="button"><i class="icon-align-left"></i></button>
                  <button class="btn" type="button"><i class="icon-align-center"></i></button>
                  <button class="btn" type="button"><i class="icon-align-right"></i></button>
                  <button class="btn" type="button"><i class="icon-align-justify"></i></button>
                </div>
              </div>
            </div>



            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="dropup">上拉</a> </span>
              <div class="preview">图文版块</div>
              <div class="view">
                <div class="btn-group">
                  <button class="btn" contenteditable="true">Action</button>
                  <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                  <ul class="dropdown-menu" contenteditable="true">
                    <li><a href="#">操作</a></li>
                    <li><a href="#">设置栏目</a></li>
                    <li><a href="#">更多设置</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">更多选项</a>
                      <ul class="dropdown-menu">
                        <li><a href="#">操作</a></li>
                        <li><a href="#">设置栏目</a></li>
                        <li><a href="#">更多设置</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

           
           
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button></span>
              <div class="preview">院校简介</div>
              <div class="view">
                <h2 contenteditable="true">北京101中学</h2>
                <p contenteditable="true">位于北京海淀区，是一所重点中学.</p>
                
              </div>
            </div>
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span>
              <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button></span>
              <div class="preview">图文列表</div>
              <div class="view">
                <ul class="thumbnails">
                  <li class="span4">
                    <div class="thumbnail"> <img alt="300x200" src="/images/boot/people.jpg">
                      <div class="caption" contenteditable="true">
                        <h3>冯诺尔曼结构</h3>
                        <p>也称普林斯顿结构，是一种将程序指令存储器和数据存储器合并在一起的存储器结构。程序指令存储地址和数据存储地址指向同一个存储器的不同物理位置。</p>
                        <p><a class="btn btn-primary" href="#">浏览</a> <a class="btn" href="#">分享</a></p>
                      </div>
                    </div>
                  </li>
                  <li class="span4">
                    <div class="thumbnail"> <img alt="300x200" src="/images/boot/city.jpg">
                      <div class="caption" contenteditable="true">
                        <h3>哈佛结构</h3>
                        <p>哈佛结构是一种将程序指令存储和数据存储分开的存储器结构，它的主要特点是将程序和数据存储在不同的存储空间中，进行独立编址。</p>
                        <p><a class="btn btn-primary" href="#">浏览</a> <a class="btn" href="#">分享</a></p>
                      </div>
                    </div>
                  </li>
                  <li class="span4">
                    <div class="thumbnail"> <img alt="300x200" src="/images/boot/sports.jpg">
                      <div class="caption" contenteditable="true">
                        <h3>改进型哈佛结构</h3>
                        <p>改进型的哈佛结构具有一条独立的地址总线和一条独立的数据总线，两条总线由程序存储器和数据存储器分时复用，使结构更紧凑。</p>
                        <p><a class="btn btn-primary" href="#">浏览</a> <a class="btn" href="#">分享</a></p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">邮件版块</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
            
             <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"> <span class="btn-group"> <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">样式 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="#" rel="">默认</a></li>
                <li class=""><a href="#" rel="progress-info">提示</a></li>
                <li class=""><a href="#" rel="progress-success">成功</a></li>
                <li class=""><a href="#" rel="progress-warning">警告</a></li>
                <li class=""><a href="#" rel="progress-danger">危险</a></li>
              </ul>
              </span> <a class="btn btn-mini" href="#" rel="progress-striped">条纹</a> <a class="btn btn-mini" href="#" rel="active">动画</a> </span>
              <div class="preview">应用版块</div>
              <div class="view">
                <div class="progress">
                  <div class="bar" style="width: 60%;"></div>
                </div>
              </div>
            </div>
            <div class="box box-element ui-draggable"> <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>删除</a> <span class="drag label"><i class="icon-move"></i>拖动</span> <span class="configuration"><button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">编辑</button> <a class="btn btn-mini" href="#" rel="well">嵌入</a> </span>
              <div class="preview">嵌入媒体</div>
              <div class="view">
                <div class="media"> <a href="#" class="pull-left"> <img src="Bootstrap%E5%8F%AF%E8%A7%86%E5%8C%96%E5%B8%83%E5%B1%80%E7%B3%BB%E7%BB%9F_files/a_002.jpg" class="media-object"> </a>
                  <div class="media-body" contenteditable="true">
                    <h4 class="media-heading">嵌入媒体标题</h4>
                   请尽量使用HTML5兼容的视频格式和视频代码实现视频播放, 以达到更好的体验效果. </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
    
      
      </div>
    </div>
    <!--/span-->
    <!--开发开始-->
		<div style="display:block;width:100%;height:200px;background:red;">
		<div style="width:100%;height:34px;">
			<div class="wrapper_topbar2_m" style="position:relative;">
				<div class="topbar_line_m c_0071cd"></div>
				<div class="topbar_nav2_m clearfixed_m">
					<div class="nav2_left_m fl_m">
						<a href="#" class="logo_small_m fl_m">云应用</a>
						<a class="guoshiEmail_m fl_m" href="#" target="_blank">云邮箱</a>
						<div class="guoshi_hot_m fl_m">
						<ul>
							<li>
								<a href="#" class="guoshi_hot_a_m">云热点<!--[if IE 7]><!--></a><!--<![endif]-->
								<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
									<li><a href="#">留学中国</a></li>
									<li><a href="#">1921</a>
								</ul>
								<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
						</ul>
					</div>
						<div class="guoshi_tool_m fl_m">
						<ul>
							<li>
								<a href="##" class="guoshi_tool_a_m">云工具<!--[if IE 7]><!--></a><!--<![endif]-->
								<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
									<li class="t"><a href="#">云下载</a></li>           
									<li><a href="#">2.5D课堂</a></li>
									<li class="t"><a href="#">3D课堂</a></li>
									<li><a href="#p">实时课堂</a></li>
									<li class="t"><a href="#">移动课堂</a></li>
									<li><a href="#">云微博</a></li>
									<li><a href="#">分享书窝</a></li> 
									<li><a href="#">练学测</a></li>
								</ul>
								<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
						</ul>
					</div>
						<form action="#" class="fl_m" onSubmit="return searchCheck();">
							<input type="text" class="txt" id="headq" name="q" onFocus="this.value=&#39;&#39;;" onBlur="if(this.value == &#39;&#39;){ this.value = &#39;搜索一下&#39;}" value="搜索一下">
							<input type="submit" value="搜索" class="btn">
						</form>
					</div>
					<div class="nav2_right_m fr_m">
						<ul class="fr_m shequ_m">
							<li><a href="#" class="study on1">学习社区</a></li>
							<li><a href="#" class="news c_study">新闻社区</a></li>
							<li><a href="#" class="idea c_study">创意社区</a></li>
						</ul>
						<div class="l_wei_m fr_m" id="login" style="width:183px">
							<a href="javascript:void(0);" class="loginBtn">登录</a>
							<a href="javascript:void(0);" onClick="myAddBookmark(&#39;云应用&#39;,&#39;http:#)">收藏</a>
							<a href="#" target="_blank">指南</a>
						</div>
					</div>
				</div>
			</div>
	
		</div>
		</div>
		<div style="min-height: 471px;" class="demo ui-sortable">
			    	
                <div class="container-fluid">
				<?php echo ($test); ?>
				</div>

		</div>
    <!--/span-->
    <div id="download-layout">
      <div class="container-fluid"></div>
    </div>
  </div>
  <!--/row--> 
</div>
<!--/.fluid-container--> 
<div aria-hidden="true" style="display: none;" class="modal hide fade" role="dialog" id="editorModal">
  <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
    <h3>编辑</h3>
  </div>
  <div class="modal-body">
    <p>
      <textarea style="visibility: hidden; display: none;" id="contenteditor"></textarea><div id="cke_contenteditor" class="cke_1 cke cke_reset cke_chrome cke_editor_contenteditor cke_ltr cke_browser_gecko" dir="ltr" role="application" aria-labelledby="cke_contenteditor_arialbl" lang="zh-cn">
	  <span id="cke_contenteditor_arialbl" class="cke_voice_label">所见即所得编辑器</span><div class="cke_inner cke_reset" role="presentation"><span id="cke_1_top" class="cke_top cke_reset_all" role="presentation" style="height: auto; -moz-user-select: none;"><span id="cke_5" class="cke_voice_label">工具栏</span><span id="cke_1_toolbox" class="cke_toolbox" role="group" aria-labelledby="cke_5" onmousedown="return false;"><span id="cke_8" class="cke_toolbar" aria-labelledby="cke_8_label" role="toolbar"><span id="cke_8_label" class="cke_voice_label">剪贴板/撤销</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a aria-disabled="true" id="cke_9" class="cke_button cke_button__cut cke_button_disabled" title="剪切" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_9_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(2,event);" onfocus="return CKEDITOR.tools.callFunction(3,event);" onmousedown="return CKEDITOR.tools.callFunction(4,event);" onclick="CKEDITOR.tools.callFunction(5,this);return false;"><span class="cke_button_icon cke_button__cut_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -352px;">&nbsp;</span><span id="cke_9_label" class="cke_button_label cke_button__cut_label">剪切</span></a><a aria-disabled="true" id="cke_10" class="cke_button cke_button__copy cke_button_disabled" title="复制" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_10_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(6,event);" onfocus="return CKEDITOR.tools.callFunction(7,event);" onmousedown="return CKEDITOR.tools.callFunction(8,event);" onclick="CKEDITOR.tools.callFunction(9,this);return false;"><span class="cke_button_icon cke_button__copy_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -288px;">&nbsp;</span><span id="cke_10_label" class="cke_button_label cke_button__copy_label">复制</span></a><a id="cke_11" class="cke_button cke_button__paste  cke_button_off" title="粘贴" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_11_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(10,event);" onfocus="return CKEDITOR.tools.callFunction(11,event);" onmousedown="return CKEDITOR.tools.callFunction(12,event);" onclick="CKEDITOR.tools.callFunction(13,this);return false;"><span class="cke_button_icon cke_button__paste_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -416px;">&nbsp;</span><span id="cke_11_label" class="cke_button_label cke_button__paste_label">粘贴</span></a><a id="cke_12" class="cke_button cke_button__pastetext  cke_button_off" title="粘贴为无格式文本" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_12_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(14,event);" onfocus="return CKEDITOR.tools.callFunction(15,event);" onmousedown="return CKEDITOR.tools.callFunction(16,event);" onclick="CKEDITOR.tools.callFunction(17,this);return false;"><span class="cke_button_icon cke_button__pastetext_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -960px;">&nbsp;</span><span id="cke_12_label" class="cke_button_label cke_button__pastetext_label">粘贴为无格式文本</span></a><a id="cke_13" class="cke_button cke_button__pastefromword  cke_button_off" title="从 MS Word 粘贴" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_13_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(18,event);" onfocus="return CKEDITOR.tools.callFunction(19,event);" onmousedown="return CKEDITOR.tools.callFunction(20,event);" onclick="CKEDITOR.tools.callFunction(21,this);return false;"><span class="cke_button_icon cke_button__pastefromword_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1024px;">&nbsp;</span><span id="cke_13_label" class="cke_button_label cke_button__pastefromword_label">从 MS Word 粘贴</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_14" class="cke_button cke_button__undo cke_button_off" title="撤消" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_14_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(22,event);" onfocus="return CKEDITOR.tools.callFunction(23,event);" onmousedown="return CKEDITOR.tools.callFunction(24,event);" onclick="CKEDITOR.tools.callFunction(25,this);return false;"><span class="cke_button_icon cke_button__undo_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1344px;">&nbsp;</span><span id="cke_14_label" class="cke_button_label cke_button__undo_label">撤消</span></a><a aria-disabled="true" id="cke_15" class="cke_button cke_button__redo cke_button_disabled" title="重做" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_15_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(26,event);" onfocus="return CKEDITOR.tools.callFunction(27,event);" onmousedown="return CKEDITOR.tools.callFunction(28,event);" onclick="CKEDITOR.tools.callFunction(29,this);return false;"><span class="cke_button_icon cke_button__redo_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1280px;">&nbsp;</span><span id="cke_15_label" class="cke_button_label cke_button__redo_label">重做</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_16" class="cke_toolbar" aria-labelledby="cke_16_label" role="toolbar"><span id="cke_16_label" class="cke_voice_label">编辑</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_17" class="cke_button cke_button__scayt cke_button_off " title="即时拼写检查" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_17_label" aria-haspopup="true" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(30,event);" onfocus="return CKEDITOR.tools.callFunction(31,event);" onmousedown="return CKEDITOR.tools.callFunction(32,event);" onclick="CKEDITOR.tools.callFunction(33,this);return false;"><span class="cke_button_icon cke_button__scayt_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1184px;">&nbsp;</span><span id="cke_17_label" class="cke_button_label cke_button__scayt_label">即时拼写检查</span><span class="cke_button_arrow"></span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_18" class="cke_toolbar" aria-labelledby="cke_18_label" role="toolbar"><span id="cke_18_label" class="cke_voice_label">链接</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_19" class="cke_button cke_button__link  cke_button_off" title="插入/编辑超链接" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_19_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(34,event);" onfocus="return CKEDITOR.tools.callFunction(35,event);" onmousedown="return CKEDITOR.tools.callFunction(36,event);" onclick="CKEDITOR.tools.callFunction(37,this);return false;"><span class="cke_button_icon cke_button__link_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -832px;">&nbsp;</span><span id="cke_19_label" class="cke_button_label cke_button__link_label">插入/编辑超链接</span></a><a aria-disabled="true" id="cke_20" class="cke_button cke_button__unlink cke_button_disabled" title="取消超链接" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_20_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(38,event);" onfocus="return CKEDITOR.tools.callFunction(39,event);" onmousedown="return CKEDITOR.tools.callFunction(40,event);" onclick="CKEDITOR.tools.callFunction(41,this);return false;"><span class="cke_button_icon cke_button__unlink_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -864px;">&nbsp;</span><span id="cke_20_label" class="cke_button_label cke_button__unlink_label">取消超链接</span></a><a id="cke_21" class="cke_button cke_button__anchor  cke_button_off" title="插入/编辑锚点链接" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_21_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(42,event);" onfocus="return CKEDITOR.tools.callFunction(43,event);" onmousedown="return CKEDITOR.tools.callFunction(44,event);" onclick="CKEDITOR.tools.callFunction(45,this);return false;"><span class="cke_button_icon cke_button__anchor_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -800px;">&nbsp;</span><span id="cke_21_label" class="cke_button_label cke_button__anchor_label">插入/编辑锚点链接</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_22" class="cke_toolbar" aria-labelledby="cke_22_label" role="toolbar"><span id="cke_22_label" class="cke_voice_label">插入</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_23" class="cke_button cke_button__image  cke_button_off" title="图象" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_23_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(46,event);" onfocus="return CKEDITOR.tools.callFunction(47,event);" onmousedown="return CKEDITOR.tools.callFunction(48,event);" onclick="CKEDITOR.tools.callFunction(49,this);return false;"><span class="cke_button_icon cke_button__image_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -736px;">&nbsp;</span><span id="cke_23_label" class="cke_button_label cke_button__image_label">图象</span></a><a id="cke_24" class="cke_button cke_button__table  cke_button_off" title="表格" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_24_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(50,event);" onfocus="return CKEDITOR.tools.callFunction(51,event);" onmousedown="return CKEDITOR.tools.callFunction(52,event);" onclick="CKEDITOR.tools.callFunction(53,this);return false;"><span class="cke_button_icon cke_button__table_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1216px;">&nbsp;</span><span id="cke_24_label" class="cke_button_label cke_button__table_label">表格</span></a><a id="cke_25" class="cke_button cke_button__horizontalrule  cke_button_off" title="插入水平线" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_25_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(54,event);" onfocus="return CKEDITOR.tools.callFunction(55,event);" onmousedown="return CKEDITOR.tools.callFunction(56,event);" onclick="CKEDITOR.tools.callFunction(57,this);return false;"><span class="cke_button_icon cke_button__horizontalrule_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -704px;">&nbsp;</span><span id="cke_25_label" class="cke_button_label cke_button__horizontalrule_label">插入水平线</span></a><a id="cke_26" class="cke_button cke_button__specialchar  cke_button_off" title="插入特殊符号" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_26_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(58,event);" onfocus="return CKEDITOR.tools.callFunction(59,event);" onmousedown="return CKEDITOR.tools.callFunction(60,event);" onclick="CKEDITOR.tools.callFunction(61,this);return false;"><span class="cke_button_icon cke_button__specialchar_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1152px;">&nbsp;</span><span id="cke_26_label" class="cke_button_label cke_button__specialchar_label">插入特殊符号</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_27" class="cke_toolbar" aria-labelledby="cke_27_label" role="toolbar"><span id="cke_27_label" class="cke_voice_label">工具</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_28" class="cke_button cke_button__maximize  cke_button_off" title="全屏" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_28_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(62,event);" onfocus="return CKEDITOR.tools.callFunction(63,event);" onmousedown="return CKEDITOR.tools.callFunction(64,event);" onclick="CKEDITOR.tools.callFunction(65,this);return false;"><span class="cke_button_icon cke_button__maximize_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -896px;">&nbsp;</span><span id="cke_28_label" class="cke_button_label cke_button__maximize_label">全屏</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_29" class="cke_toolbar" aria-labelledby="cke_29_label" role="toolbar"><span id="cke_29_label" class="cke_voice_label">文档</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_30" class="cke_button cke_button__source  cke_button_off" title="源码" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_30_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(66,event);" onfocus="return CKEDITOR.tools.callFunction(67,event);" onmousedown="return CKEDITOR.tools.callFunction(68,event);" onclick="CKEDITOR.tools.callFunction(69,this);return false;"><span class="cke_button_icon cke_button__source_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1120px;">&nbsp;</span><span id="cke_30_label" class="cke_button_label cke_button__source_label">源码</span></a></span><span class="cke_toolbar_end"></span></span><span class="cke_toolbar_break"></span><span id="cke_31" class="cke_toolbar" aria-labelledby="cke_31_label" role="toolbar"><span id="cke_31_label" class="cke_voice_label">基本格式</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_32" class="cke_button cke_button__bold  cke_button_off" title="加粗" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_32_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(70,event);" onfocus="return CKEDITOR.tools.callFunction(71,event);" onmousedown="return CKEDITOR.tools.callFunction(72,event);" onclick="CKEDITOR.tools.callFunction(73,this);return false;"><span class="cke_button_icon cke_button__bold_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -32px;">&nbsp;</span><span id="cke_32_label" class="cke_button_label cke_button__bold_label">加粗</span></a><a id="cke_33" class="cke_button cke_button__italic  cke_button_off" title="倾斜" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_33_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(74,event);" onfocus="return CKEDITOR.tools.callFunction(75,event);" onmousedown="return CKEDITOR.tools.callFunction(76,event);" onclick="CKEDITOR.tools.callFunction(77,this);return false;"><span class="cke_button_icon cke_button__italic_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -64px;">&nbsp;</span><span id="cke_33_label" class="cke_button_label cke_button__italic_label">倾斜</span></a><a id="cke_34" class="cke_button cke_button__underline  cke_button_off" title="下划线" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_34_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(78,event);" onfocus="return CKEDITOR.tools.callFunction(79,event);" onmousedown="return CKEDITOR.tools.callFunction(80,event);" onclick="CKEDITOR.tools.callFunction(81,this);return false;"><span class="cke_button_icon cke_button__underline_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -192px;">&nbsp;</span><span id="cke_34_label" class="cke_button_label cke_button__underline_label">下划线</span></a><a id="cke_35" class="cke_button cke_button__strike  cke_button_off" title="删除线" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_35_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(82,event);" onfocus="return CKEDITOR.tools.callFunction(83,event);" onmousedown="return CKEDITOR.tools.callFunction(84,event);" onclick="CKEDITOR.tools.callFunction(85,this);return false;"><span class="cke_button_icon cke_button__strike_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -96px;">&nbsp;</span><span id="cke_35_label" class="cke_button_label cke_button__strike_label">删除线</span></a><a id="cke_36" class="cke_button cke_button__subscript  cke_button_off" title="下标" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_36_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(86,event);" onfocus="return CKEDITOR.tools.callFunction(87,event);" onmousedown="return CKEDITOR.tools.callFunction(88,event);" onclick="CKEDITOR.tools.callFunction(89,this);return false;"><span class="cke_button_icon cke_button__subscript_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -128px;">&nbsp;</span><span id="cke_36_label" class="cke_button_label cke_button__subscript_label">下标</span></a><a id="cke_37" class="cke_button cke_button__superscript  cke_button_off" title="上标" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_37_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(90,event);" onfocus="return CKEDITOR.tools.callFunction(91,event);" onmousedown="return CKEDITOR.tools.callFunction(92,event);" onclick="CKEDITOR.tools.callFunction(93,this);return false;"><span class="cke_button_icon cke_button__superscript_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -160px;">&nbsp;</span><span id="cke_37_label" class="cke_button_label cke_button__superscript_label">上标</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_38" class="cke_button cke_button__removeformat  cke_button_off" title="清除格式" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_38_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(94,event);" onfocus="return CKEDITOR.tools.callFunction(95,event);" onmousedown="return CKEDITOR.tools.callFunction(96,event);" onclick="CKEDITOR.tools.callFunction(97,this);return false;"><span class="cke_button_icon cke_button__removeformat_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -1056px;">&nbsp;</span><span id="cke_38_label" class="cke_button_label cke_button__removeformat_label">清除格式</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_39" class="cke_toolbar" aria-labelledby="cke_39_label" role="toolbar"><span id="cke_39_label" class="cke_voice_label">段落</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_40" class="cke_button cke_button__numberedlist  cke_button_off" title="编号列表" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_40_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(98,event);" onfocus="return CKEDITOR.tools.callFunction(99,event);" onmousedown="return CKEDITOR.tools.callFunction(100,event);" onclick="CKEDITOR.tools.callFunction(101,this);return false;"><span class="cke_button_icon cke_button__numberedlist_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -544px;">&nbsp;</span><span id="cke_40_label" class="cke_button_label cke_button__numberedlist_label">编号列表</span></a><a id="cke_41" class="cke_button cke_button__bulletedlist  cke_button_off" title="项目列表" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_41_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(102,event);" onfocus="return CKEDITOR.tools.callFunction(103,event);" onmousedown="return CKEDITOR.tools.callFunction(104,event);" onclick="CKEDITOR.tools.callFunction(105,this);return false;"><span class="cke_button_icon cke_button__bulletedlist_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -480px;">&nbsp;</span><span id="cke_41_label" class="cke_button_label cke_button__bulletedlist_label">项目列表</span></a><span class="cke_toolbar_separator" role="separator"></span><a aria-disabled="true" id="cke_42" class="cke_button cke_button__outdent cke_button_disabled" title="减少缩进量" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_42_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(106,event);" onfocus="return CKEDITOR.tools.callFunction(107,event);" onmousedown="return CKEDITOR.tools.callFunction(108,event);" onclick="CKEDITOR.tools.callFunction(109,this);return false;"><span class="cke_button_icon cke_button__outdent_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -672px;">&nbsp;</span><span id="cke_42_label" class="cke_button_label cke_button__outdent_label">减少缩进量</span></a><a id="cke_43" class="cke_button cke_button__indent  cke_button_off" title="增加缩进量" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_43_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(110,event);" onfocus="return CKEDITOR.tools.callFunction(111,event);" onmousedown="return CKEDITOR.tools.callFunction(112,event);" onclick="CKEDITOR.tools.callFunction(113,this);return false;"><span class="cke_button_icon cke_button__indent_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -608px;">&nbsp;</span><span id="cke_43_label" class="cke_button_label cke_button__indent_label">增加缩进量</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_44" class="cke_button cke_button__blockquote  cke_button_off" title="块引用" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_44_label" aria-haspopup="false" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(114,event);" onfocus="return CKEDITOR.tools.callFunction(115,event);" onmousedown="return CKEDITOR.tools.callFunction(116,event);" onclick="CKEDITOR.tools.callFunction(117,this);return false;"><span class="cke_button_icon cke_button__blockquote_icon" style="background-image:url(http://www.bootcss.com/p/layoutit/ckeditor/plugins/icons.png?t=D3NA);background-position:0 -224px;">&nbsp;</span><span id="cke_44_label" class="cke_button_label cke_button__blockquote_label">块引用</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_45" class="cke_toolbar" aria-labelledby="cke_45_label" role="toolbar"><span id="cke_45_label" class="cke_voice_label">样式</span><span class="cke_toolbar_start"></span><span id="cke_6" class="cke_combo cke_combo__styles  cke_combo_off" role="presentation"><span id="cke_6_label" class="cke_combo_label">样式</span><a class="cke_combo_button" hidefocus="true" title="样式" tabindex="-1" role="button" aria-labelledby="cke_6_label" aria-haspopup="true" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(119,event,this);" onmousedown="return CKEDITOR.tools.callFunction(121,event);" onfocus="return CKEDITOR.tools.callFunction(120,event);" onclick="CKEDITOR.tools.callFunction(118,this);return false;"><span id="cke_6_text" class="cke_combo_text cke_combo_inlinelabel">样式</span><span class="cke_combo_open"><span class="cke_combo_arrow"></span></span></a></span><span id="cke_7" class="cke_combo cke_combo__format  cke_combo_off" role="presentation"><span id="cke_7_label" class="cke_combo_label">格式</span><a class="cke_combo_button" hidefocus="true" title="格式" tabindex="-1" role="button" aria-labelledby="cke_7_label" aria-haspopup="true" onblur="this.style.cssText = this.style.cssText;" onkeydown="return CKEDITOR.tools.callFunction(123,event,this);" onmousedown="return CKEDITOR.tools.callFunction(125,event);" onfocus="return CKEDITOR.tools.callFunction(124,event);" onclick="CKEDITOR.tools.callFunction(122,this);return false;"><span id="cke_7_text" class="cke_combo_text">普通</span><span class="cke_combo_open"><span class="cke_combo_arrow"></span></span></a></span><span class="cke_toolbar_end"></span></span></span></span><div style="height: 200px;" id="cke_1_contents" class="cke_contents cke_reset" role="presentation"><span id="cke_51" class="cke_voice_label">按 ALT+0 获得帮助</span><iframe allowtransparency="true" tabindex="0" src="" title="所见即所得编辑器,contenteditor" aria-describedby="cke_51" class="cke_wysiwyg_frame cke_reset" style="width: 100%; height: 100%;" frameborder="0"></iframe></div><span style="-moz-user-select: none;" id="cke_1_bottom" class="cke_bottom cke_reset_all" role="presentation"><span id="cke_1_resizer" class="cke_resizer cke_resizer_vertical cke_resizer_ltr" title="拖拽以改变尺寸" onmousedown="CKEDITOR.tools.callFunction(0, event)">◢</span><span id="cke_1_path_label" class="cke_voice_label">元素路径</span><span id="cke_1_path" class="cke_path" role="group" aria-labelledby="cke_1_path_label"><a id="cke_elementspath_46_2" href="javascript:void('body')" tabindex="-1" class="cke_path_item" title="body 元素" onblur="this.style.cssText = this.style.cssText;" hidefocus="true" onkeydown="return CKEDITOR.tools.callFunction(127,2, event );" onclick="CKEDITOR.tools.callFunction(126,2); return false;" role="button" aria-label="body 元素">body</a><a id="cke_elementspath_46_1" href="javascript:void('p')" tabindex="-1" class="cke_path_item" title="p 元素" onblur="this.style.cssText = this.style.cssText;" hidefocus="true" onkeydown="return CKEDITOR.tools.callFunction(127,1, event );" onclick="CKEDITOR.tools.callFunction(126,1); return false;" role="button" aria-label="p 元素">p</a><a id="cke_elementspath_46_0" href="javascript:void('span')" tabindex="-1" class="cke_path_item" title="span 元素" onblur="this.style.cssText = this.style.cssText;" hidefocus="true" onkeydown="return CKEDITOR.tools.callFunction(127,0, event );" onclick="CKEDITOR.tools.callFunction(126,0); return false;" role="button" aria-label="span 元素">span</a><span class="cke_path_empty">&nbsp;</span></span></span></div></div>
    </p>
  </div>
  <div class="modal-footer"> <a id="savecontent" class="btn btn-primary" data-dismiss="modal">保存</a> <a class="btn" data-dismiss="modal">关闭</a> </div>
</div>
<div class="modal hide fade" role="dialog" id="downloadModal">
  <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
    <h3>下载</h3>
  </div>
  <div class="modal-body">
    <p>已在下面生成干净的HTML, 可以复制粘贴代码到你的项目.</p>
    <div class="btn-group">
      <button type="button" id="fluidPage" class="active btn btn-info"><i class="icon-fullscreen icon-white"></i> 自适应宽度</button>
      <button type="button" class="btn btn-info" id="fixedPage"><i class="icon-screenshot icon-white"></i> 固定宽度</button>
    </div>
    <br>
    <br>
    <p>
      <textarea></textarea>
    </p>
  </div>
  <div class="modal-footer"> <a class="btn" data-dismiss="modal">关闭</a> </div>
</div>
<div class="modal hide fade" role="dialog" id="shareModal">
  <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
    <h3>保存</h3>
  </div>
  <div class="modal-body">保存成功</div>
  <div class="modal-footer"> <a class="btn" data-dismiss="modal">Close</a> </div>
</div>
<script>
	function savecss(){
	
		alert('点击保存');
		var classname = document.getElementsByClassName('');
	}
</script>


<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3d8e7fc0de8a2a75f2ca3bfe128e6391' type='text/javascript'%3E%3C/script%3E"));
</script><script src="/images/boot/h.js" type="text/javascript"></script>

</body></html>