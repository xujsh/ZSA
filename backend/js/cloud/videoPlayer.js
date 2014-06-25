/*  Last update 2013-10-31 16:17 */
var b__ua=navigator.userAgent;
var d__i=false;
var d__a=false;
if(/(iPhone|iPad|iPod|iOS)/i.test(b__ua)){
	d__i=true;
}else if(/(Android)/i.test(b__ua)){
	d__a=true;
};
if(!d__i&&!d__cf()){
	d__i=true;
}
var b__pld=null;
var _tide_play_num=0;
var _id_temp=new Object();
function showPlayer(obj){

	if(!obj.skin){
		obj.skin="0,0,0,0";
	}
	if(obj.autoplay==undefined){
		obj.autoplay=true;
	}
	var _dom_name=obj.name;
	if(!obj.name){
		_dom_name="TIDE_PLAYER_"+(_tide_play_num++);
	}
	var _path="v.swf"/*tpa=http://shouye.guoshi.com/js/v.swf*/;//------------------------------------------------注意修改这里
	var _w=obj.width;
	if(!_w) _w=740;
	var _h=obj.height;
	if(!_h) _h=453;
	var _hs;
	if(d__i){
		_hs=d__shv(_dom_name,_w,_h,obj);
	}else{
		_hs=d__sf(_path,_dom_name,_w,_h,false,d__vo(obj));
		if(!obj.notool){		
			_hs="<div style='position:relative;z-index:300;'>"+_hs+"</div>";
		}
	}
	if(obj.divid){
		try{
			document.getElementById(obj.divid).innerHTML=_hs;
		}catch(e){};
	}else{
		document.write(_hs);
	};
}
function d__sf(a,b,w,h,c,d){var e='<object id="'+b+'" width="'+w+'" height="'+h+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="'+a+'" /><param name="FlashVars" value="'+d+'" /><param name="wmode" value="'+(c?'transparent':'opaque')+'" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><embed name="'+b+'" width="'+w+'" height="'+h+'" src="'+a+'" wmode="'+(c?'transparent':'opaque')+'" allowFullScreen="true" allowScriptAccess="always" FlashVars="'+d+'" type="application/x-shockwave-flash"></embed></object>';return e;}
function d__shv(n,w,h,o){_id_temp.id=n;_id_temp.w=w;_id_temp.h=h;var a=o.josn;var b;if(a){if(a.indexOf("http://")==-1){a=d__url(o.josn)};d__cjp(a+"&funcname=d__ihtml5");b="正在读取请稍候..."}else{var c=o.video;if(c){var d=c.toLowerCase();var e=d.substr(d.lastIndexOf(".")+1);if(e=="mp4"){b=d__ihtml5(c,true)}}if(!b){b="此视频暂时不支持苹果设备播放，请在电脑上浏览观看！"}}return'<div id='+n+' style="width:'+w+'px;height:'+h+'px;background:#000;line-height:'+h+'px;text-align:center;color:#fff;font-size:16px;clear:both;">'+b+'</div>'}
function d__ihtml5(a,b){var c;if(b){c=a}else{for(var i=0;i<a.videos.length;i++){c=a.videos[i].url;if(c){break}}}if(c){var d='<video width="'+_id_temp.w+'" height="'+_id_temp.h+'" controls="controls" autoplay="autoplay" src="'+c+'"></video>';if(b){return d}else{document.getElementById(_id_temp.id).innerHTML=d}}}
function d__cf(){if(navigator.mimeTypes.length>0){return navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin!=null}else if(window.ActiveXObject){try{new ActiveXObject("ShockwaveFlash.ShockwaveFlash");return true}catch(e){return false}}else{return false}}
function d__vo(a){var b=new Array();for(var c in a){b.push(c+"="+encodeURIComponent(a[c]))}return b.join("&")}
function d__pld(){var d=document.createElement("div");d.style.position="absolute";d.style.display="none";d.style.width="100%";d.style.height=document.documentElement.scrollHeight+"px";d.style.zIndex=299;d.style.left="0px";d.style.top="0px";d.style.backgroundColor="#000";return d}
function d__url(a){var b=new Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,62,-1,-1,-1,63,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1);var c,c2,c3,c4;var i,len,out;len=a.length;i=0;out="";while(i<len){do{c=b[a.charCodeAt(i++)&0xff]}while(i<len&&c==-1);if(c==-1)break;do{c2=b[a.charCodeAt(i++)&0xff]}while(i<len&&c2==-1);if(c2==-1)break;out+=String.fromCharCode((c<<2)|((c2&0x30)>>4));do{c3=a.charCodeAt(i++)&0xff;if(c3==61)return out;c3=b[c3]}while(i<len&&c3==-1);if(c3==-1)break;out+=String.fromCharCode(((c2&0XF)<<4)|((c3&0x3C)>>2));do{c4=a.charCodeAt(i++)&0xff;if(c4==61)return out;c4=b[c4]}while(i<len&&c4==-1);if(c4==-1)break;out+=String.fromCharCode(((c3&0x03)<<6)|c4)}return out}
function d__cjp(a){var b=document.createElement("script");b.onload=b.onreadystatechange=function(){if(!this.readyState||this.readyState==="loaded"||this.readyState==="complete"){b.onload=null;b.onreadystatechange=null}};b.type="text/javascript";b.charset="utf-8";b.src=a;document.getElementsByTagName("head")[0].appendChild(b)}
function getFlashDom(a){return document[a]}
function getPlayerPageUrl(){
	return window.location.href;
}
//--------------控制灯
function controlLight(show){
	if(!b__pld){
		b__pld=d__pld();
		document.body.appendChild(b__pld);
	}
	b__pld.style.display=show?"none":"block";
}
