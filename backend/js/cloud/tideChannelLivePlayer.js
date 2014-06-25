var b__ua=navigator.userAgent;
var isSafari=false;
var isAndroid=false;
if(/(iPhone|iPad|iPod|iOS)/i.test(b__ua)){
	isSafari=true;
}else if(/(Android)/i.test(b__ua)){
	isAndroid=true;
};
if(!isSafari&&!d__cf()){
	isSafari=true;
}
var _playerlightDiv=null;
var _tide_play_name="TIDE_CHANNEL_";
var _tide_play_num=0;
var _hlsPathArr=new Object();
var _now_channelID=null;
function showTideChannelLivePlayer(obj){
	var _dom_name=obj.name;
	if(!_dom_name) _dom_name=_tide_play_name+(_tide_play_num++);
	var _path="/live/player/cv";
	var _w=obj.width;
	if(!_w) _w=590;
	var _h=obj.height;
	if(!_h) _h=400;
	var _hs;
	if(isSafari){
		_hs=showChannelHtmlVideo(_dom_name,_w,_h,obj);
	}else{
		obj.amf=_req_amf;
		_hs=showFlash(_path,_dom_name,_w,_h,false,getVarsByObject(obj));
		if(!obj.notool){		
			_hs="<div style='position:relative;z-index:300;'>"+_hs+"</div>";
		}
	}
	if(obj.divid){
		try{document.getElementById(obj.divid).innerHTML=_hs;}catch(e){}
	}else{document.write(_hs);};
}
function showFlash(a,b,w,h,c,d){var e='<object id="'+b+'" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'+w+'" height="'+h+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="'+a+'.swf" /><param name="FlashVars" value="'+d+'" /><param name="wmode" value="'+(c?'transparent':'opaque')+'" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><embed name="'+b+'" width="'+w+'" height="'+h+'" src="'+a+'.swf" wmode="'+(c?'transparent':'opaque')+'" allowFullScreen="true" allowScriptAccess="always" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" FlashVars="'+d+'" type="application/x-shockwave-flash"></embed></object>';return e;}function getFlashDom(a){return document[a];}
function playInfoCallBack(obj){
	if(obj.results.ip){
		_hlsPathArr[_now_channelID]=getChannelLiveM3u8(obj.results.ip);
		var _vdom=document.getElementById(_tide_play_name+"0");
		if(isAndroid){
			//_vdom.parentNode.innerHTML="";
		}else{
			_vdom.src=_hlsPathArr[_now_channelID];
		}
	}
}
function d__cf(){if(navigator.mimeTypes.length>0){try{return navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin!=null}catch(e){return false}}else if(window.ActiveXObject){try{new ActiveXObject("ShockwaveFlash.ShockwaveFlash");return true}catch(e){return false}}else{return false}}
var _req_p="http://119.167.247.30:81/crossdomain/";
var _req_e="http://119.167.247.30:81/live/ajax/getprogrammelist2/";
var _req_amf="http://119.167.247.31/cms_live/messagebroker/amf";
function showChannelHtmlVideo(n,w,h,o){
	var src_url=null;
	_now_channelID=o.channelId;
	if(_hlsPathArr[_now_channelID]){
		src_url='src="'+_hlsPathArr[_now_channelID]+'"';
	}else{
		loadDataByJsonp(getPIM(_now_channelID));
	}
	return '<video title="'+o.channel+'" width="'+w+'" height="'+h+'" controls="controls" autoplay="autoplay" id="'+n+'" '+(src_url?src_url:'')+'></video>';
}
function getPIM(id){
	return _req_p+"timeshiftinglive/gettslplayinfo/channelId/"+id;
}
function getVarsByObject(obj){
	var _arr=new Array();
	for(var key in obj){_arr.push(key+"="+encodeURIComponent(obj[key]));}
	return _arr.join("&");
}
function getChannelPlayerPageUrl(){
	return window.location.href;
}
function getChannelPlayerPageVar(){
	var lh=getChannelPlayerPageUrl();
	var varstr=lh.substr(lh.lastIndexOf("?")+1).split("&");
	var verobj=new Object();
	for(var i=0;i<varstr.length;i++){
		var _t=varstr[i].split("=");
		verobj[_t[0]]=_t[1];
	}
	return verobj;
}
function getPlayerLightDom(){
	var d=document.createElement("div");
	d.style.position="absolute";
	d.style.display="none";
	d.style.width="100%";
	d.style.height=document.documentElement.scrollHeight+"px";
	d.style.zIndex=299;
	d.style.left="0px";
	d.style.top="0px";
	d.style.backgroundColor="#000";
	return d;
}
function controlLight(show){
	if(!_playerlightDiv){
		_playerlightDiv=getPlayerLightDom();
		document.body.appendChild(_playerlightDiv);
	}
	_playerlightDiv.style.display=show?"none":"block";
}
function getTideChannelLivePlayer(){
	if(isSafari){
		return {setPlayLive:setChannelLiveM3u8};
	}else{
		return getFlashDom(_tide_play_name+"0");
	}
}
function setChannelLiveM3u8(cid){
	_now_channelID=cid;
	if(_hlsPathArr[_now_channelID]){
		var _vdom=document.getElementById(_tide_play_name+"0");
		_vdom.src=_hlsPathArr[_now_channelID];
	}else{


		loadDataByJsonp(getPIM(_now_channelID));
	}
}
function getChannelLiveM3u8(obj){
        //alert("http://124.127.99.167/"+"tslslive/"+_now_channelID+"/hls/live_sd"+".m3u8");
	return "http://124.127.99.167/"+"tslslive/"+_now_channelID+"/hls/live_sd"+".m3u8";

}
function loadDataByJsonp(url){
	var JSONP=document.createElement("script");
	JSONP.onload=JSONP.onreadystatechange=function(){
		if(!this.readyState||this.readyState==="loaded"||this.readyState==="complete"){
			JSONP.onload=null;
			JSONP.onreadystatechange=null;
		}
	};
	JSONP.type="text/javascript";
	JSONP.charset="utf-8";
	JSONP.src=url;
	document.getElementsByTagName("head")[0].appendChild(JSONP); 
}
