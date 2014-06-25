//给导航增加当前样式
function set_class(li,cur,text){  //选择器,加的样式 、文本
 var name=li; 
 text=jQuery.trim(text);
  jQuery(name).each(function(){
   var li_text=jQuery.trim(jQuery(this).text()+"");
	
   if(li_text==text){
       jQuery(this).addClass(cur);
  }
});
}
/******标签切换*******/
//"id"为需要切换样式的层的id,与切换相对应的内容id命名规则为id_main_i."cur"为当前层的样式名字."s"为需要切换样式的每个容器的标签,如p、span、li等.
function tabs(id,cur,s){
	var content="_main_";
	if ( jQuery("#"+id).length){
	function closeContent(id,length){
		for(var i=1;i<=length;i++){
		jQuery("#"+id+content+i).hide();
			}	
		}
	var length=jQuery("#"+id+"  "+s).length;
	 jQuery("#"+id+"  "+s).each(function(i){
		jQuery(this).hover(function(){
			 jQuery("#"+id+"  "+s).removeClass(cur);   
			 closeContent(id,length);
			 jQuery(this).addClass(cur);
			 jQuery("#"+id+content+(i+1)).show();
		},function(){
		});						 
	});
	}//end length
}

function tab(id,cur,s){
	var content="_main_";
	if ( jQuery("#"+id).length){
	function closeContent(id,length){
		for(var i=1;i<=length;i++){
		jQuery("#"+id+content+i).hide();
			}	
		}
	var obj=jQuery("#"+id+"  "+s);
	var length=obj.length;
	 obj.each(function(i){
		jQuery(this).click(function(){
			 obj.removeClass(cur);   
			 closeContent(id,length);
			 jQuery(this).addClass(cur);
			 jQuery("#"+id+content+(i+1)).show();
		});						 
	});
	}//end length
}
/******标签切换*******/
//"id"为需要切换样式的层的id,与切换相对应的内容id命名规则为id_main_i."cur"为当前层的样式名字."s"为需要切换样式的每个容器的标签,如p、span、li等.
function tabs_hover(id,cur,s){
	var content="_main_";
	if ( jQuery("#"+id).length){
	function closeContent(id,length){
		for(var i=1;i<=length;i++){
		jQuery("#"+id+content+i).hide();
			}	
		}
	var length=jQuery("#"+id+"  "+s).length;
	 jQuery("#"+id+"  "+s).each(function(i){
		jQuery(this).hover(function(){
			 jQuery("#"+id+"  "+s).removeClass(cur);   
			 closeContent(id,length);
			 jQuery(this).addClass(cur);
			 jQuery("#"+id+content+(i+1)).show();
		},function(){
		});						 
	});
	}//end length
}

//幻灯切换
(function($) {                                          // update by liyonghai 2010-07-02
$.fn.jCarouselLite = function(o) {
    o = $.extend({
        btnPrev:null,
        btnNext:null,
        btnGo:null,
        btnGoOver:false,
        mouseWheel:false,
        auto:null,
        speed:200,
        easing:null,
        vertical:false,
        circular:true,
        visible:3,
        start:0,
        scroll:1,
        stop:null,//鼠标悬停
		currClass:"on",
		timer:null,
        beforeStart:null,
        afterEnd:null
    }, o || {});

    return this.each(function() {                           // Returns the element collection. Chainable.

        var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
        var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi.size(), v = o.visible;

        if(o.circular) {
            ul.prepend(tLi.slice(tl-v-1+1).clone())
              .append(tLi.slice(0,v).clone());
            o.start += v;
        }

        var li = $("li", ul), itemLength = li.size(), curr = o.start;
        div.css("visibility", "visible");

        li.css({overflow: "hidden", float: o.vertical ? "none" : "left"});
        ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
        div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});

        var liSize = o.vertical ? height(li) : width(li);   // Full li size(incl margin)-Used for animation
        var ulSize = liSize * itemLength;                   // size of full ul(total length, not just for the visible items)
        var divSize = liSize * v;                           // size of entire div(total length for just the visible items)

        li.css({width: li.width(), height: li.height()});
        ul.css(sizeCss, ulSize+"px").css(animCss, -(curr*liSize));

        div.css(sizeCss, divSize+"px");                     // Width of the DIV. length of visible images

        if(o.btnPrev)
            $(o.btnPrev).click(function() {
                return go(curr-o.scroll);
            });

        if(o.btnNext)
            $(o.btnNext).click(function() {
                return go(curr+o.scroll);
            });

        if(o.btnGo)
            o.btnGo.each(function(i, val) {
                $(this).click(function() {
					if(o.timer)clearInterval(o.timer);
					o.btnGo.removeClass(o.currClass);
					$(this).addClass(o.currClass);
					var g = o.circular ? o.visible*(i+1) : i;
					//window.console.info("g:"+g+","+o.circular);
                    			go(g);
                });
                if(o.btnGoOver){
                $(this).mouseover(function() {
                    running = false;
                    if(o.timer)clearInterval(o.timer);
                    var r = go(o.circular ? o.visible+i : i);
                    $.each(o.btnGo, function(i, val) {$(this).removeClass(o.currClass);});
                    //o.btnGo.removeClass(o.currClass);
		    $(this).addClass(o.currClass);
		    return r;
                });}
            });

        if(o.mouseWheel && div.mousewheel)
            div.mousewheel(function(e, d) {
                return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
            });

        if(o.auto){autoscroll();}

		if(o.stop){
			o.stop.mouseover(function(){
			 if(o.timer)clearInterval(o.timer);
			}).mouseout(function(){
				autoscroll();
			});
		}

		function autoscroll()
		{
		       if(o.auto){
			o.timer = setInterval(function() {
                go(curr+o.scroll);
            }, o.auto+o.speed);}
		};

        function vis() {
            return li.slice(curr).slice(0,v);
        };

        function go(to) {
            if(!running) {

                if(o.beforeStart)
                    o.beforeStart.call(this, vis());

                if(o.circular) {            // If circular we are in first or last, then goto the other end
                    if(to<=o.start-v-1) {           // If first, then goto last
                        ul.css(animCss, -((itemLength-(v*2))*liSize)+"px");
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be lesser depending on the number of elements.
                        curr = to==o.start-v-1 ? itemLength-(v*2)-1 : itemLength-(v*2)-o.scroll;
                    } else if(to>=itemLength-v+1) { // If last, then goto first
                        ul.css(animCss, -( (v) * liSize ) + "px" );
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be greater depending on the number of elements.
                        curr = to==itemLength-v+1 ? v+1 : v+o.scroll;
                    } else curr = to;
                } else {                    // If non-circular and to points to first or last, we just return.
                    if(to<0 || to>itemLength-v) return;
                    else curr = to;
                }                           // If neither overrides it, the curr will still be "to" and we can proceed.

                running = true;

                ul.stop().animate(
                    animCss == "left" ? { left: -(curr*liSize) } : { top: -(curr*liSize) } , o.speed, o.easing,
                    function() {
                        if(o.afterEnd)
                            o.afterEnd.call(this, vis());
                        if(o.btnGo)
                        {
                            $(o.btnGo).each(function(i,j){
                            //window.console.info(i+","+j);
                             $(j).removeClass(o.currClass); }); 
                            var index = curr;
                            var tlt = o.visible * o.btnGo.size();
                            //window.console.info("tlt:"+tlt);                        
                            if(index>tlt){index =1;}else{
                            if(index<=0){index=o.btnGo.size();}
                            else{index = index /o.visible;}
                            }
                            //window.console.info("v:"+v+","+tl+",curr:"+curr+","+index+","+o.btnGo[index-1]);
                            $(o.btnGo[index-1]).addClass(o.currClass);
                        }
                        running = false;
                    }
                );
                // Disable buttons when the carousel reaches the last/first, and enable when not
                if(!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass("disabled");
                    $( (curr-o.scroll<0 && o.btnPrev)
                        ||
                       (curr+o.scroll > itemLength-v && o.btnNext)
                        ||
                       []
                     ).addClass("disabled");
                }

            }
            return false;
        };
    });
};

function css(el, prop) {
    return parseInt($.css(el[0], prop)) || 0;
};
function width(el) {
    return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {
    return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};

})(jQuery);

//scroll效果
$( document ).ready(function(){
	$(".index_tab_prev").hide();	
	$( ".index_tab_prev,.index_tab_next" ).click( function(){											   
		var liWidth = $( "#big_tab .big_li" ).width(),
			ul = $( "#big_tab .big_ul" ),leftCss=ul.css( "left" );			
			if( $( this ).hasClass( "index_tab_prev" ) ){
				if( parseInt( leftCss ) != 0  ){
					$(".index_tab_prev").hide();
					$(".index_tab_next").show();
					$( "#big_tab .big_ul:not(:animated)" ).animate( {"left": "+=" + liWidth}, 500 );
				}
			}else{			
				if(  parseInt( leftCss ) != -($(".big_ul .big_li").length-1) * liWidth ){
					$( "#big_tab .big_ul:not(:animated)" ).animate( {"left": "-=" + liWidth}, 500 );
					$(".index_tab_prev").show();
					$(".index_tab_next").hide();

				}
			}
	});	
});

//code
$(document).ready(function(){
	$(".weixin").click(function(){
		$("#weixin").show()
		$("#mobile").hide();
	})
	$(".mob").click(function(){
		$("#mobile").show();
		$("#weixin").hide();	
	});	
	$("#weixin div.code_close").click(function(){
		$("#weixin").hide();	
	})
	$("#mobile div.code_close").click(function(){
		$("#mobile").hide();	
	})
	
})

//展开更多
jQuery(function ($){
   $(".show_more").click(function(){
  var t=this;
  if($.trim($(t).html())=="全部信息"){
    $(".sp_summ .text p,.sp_summ").css("height","auto");
	var big_h=parseInt($(".taobap_p_box").height());
	var change_h=parseInt($(".sp_summ .text p").height());
	big_h2=big_h+change_h+"px";
	$(".taobap_p_box").height(big_h2);
	$(t).html("收起");
  }else{
	$(".sp_summ .text p").height(96+"px");
	$(".taobap_p_box").height(950+"px");
	$(t).html("全部信息");
  }  
  })
})   

//顶踩

function dingcai(action,op){
$.ajax({
	type:"GET",
	dataType:"json",
	url:"/php/dingcai.php?id="+cid+"&action="+action+"&op="+op+"&random="+Math.random(),
	success:function(data){
	//window.console.info(data);
	$(".btn_ding").html("顶("+data.ding_num+")");
	$(".btn_cai").html("踩("+data.cai_num+")");
	}
	})
	}


function setCookie(key,value,days){
	if(days==null || days==""){
		days=10;
	}
	var exp = new Date(); 
	exp.setTime(exp.getTime()+ days*24*60*60*1000); 
	document.cookie=key+"="+escape(value)+";path=/;expires="+exp.toUTCString();
  //      if(window.console)window.console.info(getCookie("title1"));
}
function getCookie(key) {
	cookies = document.cookie;
	if (cookies) {
		var start = cookies.indexOf(key + '=');
		if (start == -1) { return ""; }
		var end = cookies.indexOf(";", start);
		if (end == -1) { end = cookies.length; }
		end -= start;
		var cookie = cookies.substr(start,end);
		return unescape(cookie.substr(cookie.indexOf('=') + 1, cookie.length - cookie.indexOf('=') + 1));
	}
	else { return ""; }
}


function zan(type){
if(getCookie("zan_"+gid)==1 && type=="update"){
              }else{
$.ajax({
	type:"GET",
	dataType:"json",
	url:"/php/zan.php?gid="+gid+"&type="+type+"&random="+Math.random(),
	success:function(data){
	if(data.num==""){
	$(".E a").html("0");
	}else{
	$(".E a").html(data.num);
	}
	if(type=="update"){
	 setCookie("zan_"+gid,"1",1);
	}
	}
	})
			  }
}


