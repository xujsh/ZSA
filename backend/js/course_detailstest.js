
alert('cxx');
//滑到底部自动加载
	var htmlbodyscrollend = function()
	{
		
		//取网页卷上去的高度
		h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
		//取网页中能看到高
		h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
		//取网页正文高，包含被卷上去的内容
		h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
		//alert(h3);
		if((h1+h2)>=h3)
		{
			//alert('touch end 滚动条已经到最下面啦');
			funMore();
		}
	}
	window.onscroll = htmlbodyscrollend;
	//加载更多
	var nowpage = 2;
	function funMore(){

		var foucsInfo  = $('#foucsInfo');
		var pageNum    = 10;
		$.post('/Wrong/morecont',{nowpage:nowpage,pageNum:pageNum},function(data){
			
			$.each(data,function(key,val){
				
				foucsInfo.append("<div id="+val.wid+"><p>"+val.wid+"、"+val.title+"]</p>");
				$.each(val.quesChild,function(k,v){
  
					foucsInfo.append("<p><input type='radio' id='a_"+v.eid+"' name='ch"+val.qid+"[]' value="+v.eid+" >"+v.title+"</p>");
				}) 
				var a=$("#a_"+val.eid).attr("checked","checked");
				foucsInfo.append("<div class='answer' width='320px' height='20px' style=''><font color='red'>答错<a href='#'>"+val.errornum+"</a>次</font>&nbsp;<font color='blue'>正确答案:"+val.correct+"</font> &nbsp;&nbsp;&nbsp;<span style='float:right'><font color='red'><a href='#' onclick='del("+val.wid+")'>移除</a></font></span></div><div class='analysis' id='analysis"+val.qid+"' width='320px' height='' style='font-size:12px;display:none'>要点说明：飞凤飞飞凤飞飞要点说明：飞凤飞飞凤飞飞要点说明：飞凤飞飞凤飞飞要点说明：飞凤飞飞凤飞飞</div><input type='hidden' value='{$tid}' name='tid' id='tid'><div class='und_line'></div></div>");
			
			}); 
			nowpage++;
			if(data.length<10){
				document.getElementById('mores').style.display = 'none';
			}
		},"json")
	}

	var heightP		= window.screen.height;
	var heightWeb   = heightP-117;
	document.getElementById('body').style.height=heightWeb+'px';
	
	//解析
	function fun(qid){
		
		var analysis = document.getElementById('analysis'+qid);

		if(analysis.style.display == 'block'){
			analysis.style.display = 'none';
			//return false;
		}else if(analysis.style.display == 'none'){
			analysis.style.display = 'block';
			//return false;
		}
	}
	//删除
	function del(wid){
		
		jConfirm('确定要移除吗', '确定对话框', function(r) {
			if(r==true){
				$.post('/Wrong/del',{wid:wid},function(data){
					if(data==1){
						document.getElementById(wid).style.display='none';
					}
				
				})
			}
		});

		
	}