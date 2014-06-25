<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=”format-detection” content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta content="email=no" name="format-detection" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>首页</title>
<link rel="stylesheet" href="/css/index.style.css"> 
<style>
  a{ -webkit-tap-highlight-color:transparent;}
 .j3{width:320x;height:373px; display:none;background:#f1f5f8; text-align:left; overflow-x:hidden;}
 .rowsone{width:319px;height:80px;margin:0; margin-left:3px; display:-webkit-box;-webkit-box-orient:horizontal;display:-moz-box;-moz-box-orient: horizontal;}
 .categoryICO{ display:inline-block; margin-left:-3px; margin-right:0px; width:79px;height:80px; border: 1px solid #e1e5e8; border-top-width:0px; border-left-width:0px; text-align:center; line-height:80px; vertical-align:middle; position:relative;}
 .categoryICO div{font-size:14px;width:78px; height:20px; text-align:center; position:absolute;top:24px; left:2px;}
 .categoryICO img{ margin-top:15px;}
  
.greyscale {
    -webkit-filter: grayscale(1);
    -moz-filter: grayscale(1);
    -ms-filter: grayscale(1);
    -o-filter: grayscale(1);
    filter: grayscale(1);
    filter: gray;
    opacity:0.3;
}

/*专家列表*/
.experts_row{border:1px solid #cccccc; background:#FFF; width:304px; height:105px; margin-left:7px; margin-bottom:8px;}
.experts_content{ padding-left:8px;width:304px;height:85px;}

/*专家头像*/
.experts_content_picture{width:80px;float:left; height:80px;}

/*专家头像*/
.experts_content_picture img{width:80px;height:80px; border-radius:80px; margin-top:14px;}
/*专家简介*/
.experts_content_au{width:213px; height:90px;float:left; padding-left:8px; padding-top:0px; margin-top:15px; overflow:hidden; text-align:left;}
.experts_content_title{font-size:12px; font-weight:bold; margin-top:0px;}
.experts_content_au_title{margin:0px; padding:0px; font-size:12px; font-weight:bold;}
.experts_content_au hr{margin-left:0px;};
.experts_content_b{ font-size:12px; color:#666666; margin:0px; padding:0px;}

</style>
</head>
<body id="body">
<!-- 导航 tab -->
<div class="box" id="box" align="center"> 
<div id="rtid" style="display:none;"><?php echo ($rtid); ?></div>
<!--内容页-->
    <!--最新--> 
    <div class="j1" id="j1_rows">
    	<?php if(is_array($newlist)): $i = 0; $__LIST__ = $newlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="rows">
         	    <?php if( $vo['price'] > 0): ?><a href="<?php echo ($appbasepath); ?>Cdetails/index?courseid=<?php echo ($vo['courseid']); ?>&sid=<?php echo ($sid); ?>" id="j1_like1">
                <?php else: ?>
				   <a href="<?php echo ($appbasepath); ?>LessonsHistory/getdetails/?courseid=<?php echo ($vo['courseid']); ?>&sid=<?php echo ($sid); ?>" id="j1_like1"><?php endif; ?>
                	<img src="/images/index/lazyLoad1.gif"  data-original="<?php echo ($vo['picture']); ?>" width="304" height="191" class="titleimg"></a>
                <div class="title1">
                       <?php echo ($vo['name']); ?>
                </div>
                <div class="rating">
                	     <span class="price"><font class="price_f2">
                	     	<?php if( $vo['price'] == 0): ?>免费 
							<?php elseif($vo['price'] == -1): ?>
							            已购买
							<?php elseif($vo['price'] == $vo['cheapprice']): ?>
							    ¥<?php echo ($vo['price']); ?>
							<?php else: ?>
								<?php if( $vo['cheapprice'] != 0): ?><s><font style="text-decoration :line-through;">¥<?php echo ($vo['price']); ?></font></s>&nbsp;
									  <font style="color:#2E8B14">¥<?php echo ($vo['cheapprice']); ?></font>
								 <?php else: ?>
								       <s><font style="text-decoration :line-through;">¥<?php echo ($vo['price']); ?></font></s>&nbsp;
									   <font style="color:#2E8B14">免费</font><?php endif; endif; ?> 
						 </font></span>
                         <span class="level">
                         	<?php $arr = $vo['icolevel']; foreach ($arr as $v){ echo "<img src='/$v' width='16' height='17'>"; } ?>
                        </span> 
                         <span class="liulannum">
                           <img src="<?php echo ($appbasepath); ?>images/public/s_num.png" width="13" height="17" >&nbsp;<span class="liulannum_n" > <?php echo ($vo['studennum']); ?></span>				
                         </span>
						 <span style=" clear:both"></span>
                </div>
                  <!--清除float-->
                <div style=" clear:both"></div>
                <hr />
                <div class="content">
                     <div class="content_upicture">
                                <img src="<?php echo ($vo['upicture']); ?>" width="75" height="75">
                     </div>
					 <section>
                     <div class="content_aut">
                    	<span class="title2"><?php echo ($vo['username']); ?></span>
                        <p class="content_brief">
                         &nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo['descp']); ?>
                        </p>
                    </div>
					</section>
                     <div style=" clear:both"></div>
           		</div>
        </div>
		<div class="bottom-mask"></div>
        <div class="brdiv"></div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <!--最热门--> 
        <div class="j2" id="j2_rows">
	         <?php if(is_array($hotlist)): $i = 0; $__LIST__ = $hotlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="rows">
	         	<?php if( $vo['price'] > 0): ?><a href="<?php echo ($appbasepath); ?>Cdetails/index?courseid=<?php echo ($vo['courseid']); ?>&sid=<?php echo ($sid); ?>" id="j1_like1">
                <?php else: ?>
				   <a href="<?php echo ($appbasepath); ?>LessonsHistory/getdetails/?courseid=<?php echo ($vo['courseid']); ?>&sid=<?php echo ($sid); ?>" id="j1_like1"><?php endif; ?>
					<img src="/images/index/lazyLoad1.gif" data-original="<?php echo ($vo['picture']); ?>" width="304" height="191" class="titleimg"></a>
	                <div class="title1">
	                       <?php echo ($vo['name']); ?>
	                </div>
	                <div class="rating">
	                	     <span class="price"><font class="price_f2">
	                	        <?php if( $vo['price'] == 0): ?>免费 
								<?php elseif($vo['price'] == $vo['cheapprice']): ?>
									¥<?php echo ($vo['price']); ?>			  
								<?php elseif($vo['price'] == -1): ?>
								            已购买
								<?php else: ?>
									<?php if( $vo['cheapprice'] != 0): ?><s><font style="text-decoration :line-through;">¥<?php echo ($vo['price']); ?></font></s>&nbsp;
										  <font style="color:#2E8B14">¥<?php echo ($vo['cheapprice']); ?></font>
									<?php else: ?>
									      <s><font style="text-decoration :line-through;">¥<?php echo ($vo['price']); ?></font></s>&nbsp;
									   	  <font style="color:#2E8B14">免费</font><?php endif; endif; ?> 
							 </font></span>
	                         <span class="level">
	                         	<?php $arr = $vo['icolevel']; foreach ($arr as $v){ echo "<img src='/$v' width='16' height='17'>"; } ?>
	                        </span> 
	                         <span class="liulannum">
	                           <img src="<?php echo ($appbasepath); ?>images/public/s_num.png" width="13" height="17" >&nbsp;<span class="liulannum_n" > <?php echo ($vo['studennum']); ?></span>				
	                         </span>
							 <span style=" clear:both"></span>
	                </div>
	                  <!--清除float-->
	                <div style=" clear:both"></div>
	                <hr />
	                <div class="content">
	                     <div class="content_upicture">
	                                <img src="<?php echo ($vo['upicture']); ?>" width="50" height="50">
	                     </div>
						 <section>
	                     <div class="content_aut">
	                    	<span class="title2"><?php echo ($vo['username']); ?></span>
	                        <p class="content_brief">
	                         &nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo['descp']); ?>
	                        </p>
	                    </div>
						</section>
	                     <div style=" clear:both"></div>
	           		</div>
	        </div>
			
			<div class="bottom-mask"></div>
	        <div class="brdiv"></div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div> 
		<!--分类-->
        <div class="j3" align="center" id="j3_rows">
           <?php if(is_array($categorylist)): $k = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if( $k == 1 ): ?><div class="rowsone"><?php endif; ?>
        	 <a class='action'  <?php if( ($vo['book'] == 0) ): ?>href="<?php echo ($appbasepath); ?>Index/getCourseList?categoryid=<?php echo ($vo['categoryid']); ?>&sid=<?php echo ($sid); ?>"<?php elseif($vo['book'] == 1): ?>href="<?php echo ($appbasepath); ?>Index/getBookList?sid=<?php echo ($sid); ?>"<?php endif; ?>>
			 <div class="categoryICO" style="<?php if( $vo['releases'] == 1 ): ?>color:#6a7177;<?php else: ?> color:#c5d1db;<?php endif; ?>">
			 	<img src='<?php echo ($vo["iocurl"]); ?>' width="40" height="40" <?php if( $vo['releases'] != 1 ): ?>class="greyscale"<?php endif; ?> />
				<div><?php echo ($vo['name']); ?></div>
        	 	<!--<div <?php if( $vo['releases'] != 1 ): ?>style="top:40px;"<?php endif; ?>"><?php echo ($vo['name']); ?></div>-->
			</div></a>
			 <?php if( $k != 1 ): if($k%4 == 0): ?></div><div class="rowsone"><?php endif; endif; ?>
				
            <?php if( $k == $length ): ?></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </div>
		<!--专家列表-->
		<div class="j4" align="center" id="j4_rows">
			<?php if(is_array($expertslist)): $i = 0; $__LIST__ = $expertslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="experts_row">
				 	<div class="experts_content">
	                     <div class="experts_content_picture">
	                          <img src="<?php echo ($vo['picture']); ?>">
	                     </div>
						 
						 <section>
	                     <div class="experts_content_au">
	                     	<a href="/Expert/index?uid=<?php echo ($vo['userid']); ?>&sid=<?php echo ($sid); ?>" style="color:#212121;">
	                    	<span class="experts_content_title"><?php echo ($vo['username']); ?></span>
							<p class="experts_content_au_title"><?php echo ($vo['title']); ?></p>
							</a>
							<hr/>
	                        <p class="experts_content_b">
	                        <?php echo ($vo['desc']); ?>
	                        </p>
	                    </div>
						</section>
	                     <div style=" clear:both"></div>
						
	           		</div>
				 </div><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</div>
</div>
<script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.lazyload.min.js"></script> 
<script type="text/javascript">  

$(document).ready(function(){     
//   var heightP		= window.screen.height;
//   var heightWeb	= heightP-64+'px';
//document.getElementById('box').style.height = heightWeb;

	  
	var rtid = $('#rtid').html();
	$('#j1_rows').hide();
	$('#j2_rows').hide();
	$('#j3_rows').hide();
	$('#j4_rows').hide();
    if(rtid =='new'){
		$('#j1_rows').show();
	}else if(rtid =='hot'){
		$('#j2_rows').show();
	}else if(rtid =='type'){
		$('#j3_rows').show();
	}else if(rtid =='experts'){
		$('#j4_rows').show();
	}
	
	 $("img.titleimg").lazyload({ 
	   threshold:100,  
       effect : "fadeIn"   
     });
	 
//	var ADSupportsTouches = ("createTouch" in document) || ('ontouchstart' in window) || 0;
//	var ADEndEvent = ADSupportsTouches ? "touchend" : "click";
//	 
//	$(".j3").has("a").bind(ADEndEvent, function(event){
//		//alert('ok');
//	});
	
});  
//console.log( $('*').length );    //加载DOM长度。越小越好
</script>  
<a href='http://c.mpnco.cn/chat/tp.aspx?gId=wTe7f3tstlAmuP3BWOo8nSOtXh~g937etS9IcnWAAj3rd46UGeUFoPpKdYbrEQEv' target='_blank'>图片或文字</a> 
</body>
</html>