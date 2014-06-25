function checkUserInfoForm()
{
	
	_mobile = $("form input[name=mobile]").val();
	
	if(_mobile == "")
	{
		alert("请填写手机");
		return false;
	}
	
	_qq = $("form input[name=qq]").val();	
	_skype = $("form input[name=skype]").val();	
	
	if(_qq == "" && _skype == "")
	{
		alert("请填写QQ或 skype");
		return false;
	}
	
	
}
function init_r_score(rsfilter)
{
	$("#r_score_"+rsfilter+"_td div").mouseover(function(){
		
		$("#r_score_"+rsfilter+"_td div").each(function(){
			
			//$(this).attr("src","/images/star_g.png");
			
			$(this).removeClass("curB");
		})
		
		_nowsn = parseInt($(this).attr("name"));
		
		for(_i=1;_i<=_nowsn;_i++)
		{
			//$("#r_score_"+rsfilter+"_"+_i).attr("src","/images/star_y.png");
			
			$("#r_score_"+rsfilter+"_"+_i).addClass("curB");
		}
		
		$("#r_score_"+rsfilter+"_v").html(_nowsn+"分");
	})
	$("#r_score_"+rsfilter+"_td div").mouseout(function(){
		
		
		_clksn = parseInt($("#r_score_"+rsfilter+"").val());
		
		
		
		$("#r_score_"+rsfilter+"_td div").each(function(){
			//$(this).attr("src","/images/star_g.png");
			$(this).removeClass("curB");
		})
		
		if(_clksn == 0 )
		{
			$("#r_score_"+rsfilter+"_v").html("0分");
			return ;
		}
		for(_i=1;_i<=_clksn;_i++)
		{
			$("#r_score_"+rsfilter+"_"+_i).addClass("curB");
			
		}
		$("#r_score_"+rsfilter+"_v").html(_clksn + "分");
	})
	
	$("#r_score_"+rsfilter+"_td div").click(function(){
		_nowsn = parseInt($(this).attr("name"));
		
		$("#r_score_"+rsfilter+"").val(_nowsn);
		$("#r_score_"+rsfilter+"_v").html(_nowsn+"分");
		
	})
}
$(document).ready(function(){
	
	
	
	$(".cancelbook").click(function(){
		 
		 _scid = $(this).attr("id");
		 
		if(confirm("确定取消这个预定么?"))
		{
			$.post("/Course/cancelbooking", {id:_scid},function(json){
		         
				 if(json.status == 1)
		         {
					alert("取消成功");
		         	window.location.reload();
		         }
		         else
		         {
		         	alert(json.info);
		         }
		       
		   
		  },"json");
		}
		
		return false;
	 })
})