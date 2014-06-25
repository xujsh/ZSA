//-----缓动效果kidliuxu--------

var touchObj;
var showConStartY = 0;
var endTouchY = 0;
var ismoveup = 0;


var startTop = 0;
var endTop = 0;

var lastY = 0;
var chaNum = 0;
var chaNumTimeout;
var gogotime;
var gogoNum = 10;
var isTouchEnd = false;

//计算差值数据
var checkChaNum = function()
{
    var nowY = touchObj.scrollTop;
    chaNum = lastY - nowY;
    //alert("check: " + chaNum);
    if(!isTouchEnd)
    {
        chaNumTimeout = window.setTimeout("checkChaNum()", 10);
    }
}

var onshowcontouchstart = function(event)
{
    isTouchEnd = false;
    showConStartY = event.targetTouches[0].pageY;
    startTop = touchObj.scrollTop;
    lastY = touchObj.scrollTop;
    chaNumTimeout = window.setTimeout("checkChaNum()", 10);

}

var onshowcontouchmove = function(event)
{
    endTop = touchObj.scrollTop;
    lastY = touchObj.scrollTop;
}

var gogo = function()
{
    //alert("gogo chanum: " + chaNum);
    //    alert("speed1: " + chaNum);
    chaNum = chaNum / 1.2;
    touchObj.scrollTop -= chaNum;
    //alert("speed2: " + Math.round(Math.abs(chaNum)) + " : " + (Math.round(Math.abs(chaNum)) > 0));
    if(Math.round(Math.abs(chaNum)) > 0)
    {

        //chaNum = speed;
        gogotime = window.setTimeout("gogo()", 50);
    }
}

var onshowcontouchend = function(event)
{
    //alert("onshowcontouchend: " + chaNum + " abs: " + Math.abs(chaNum));
    isTouchEnd = true;
    gogotime = window.setTimeout("gogo()", 1);
}

var addSlowTouchObj = function(obj)
{
    touchObj = obj;
    obj.addEventListener("touchmove", onshowcontouchmove, false);
    obj.addEventListener("touchend", onshowcontouchend, false);
    obj.addEventListener("touchstart", onshowcontouchstart, false);
}

var removeSlowTouchObj = function(obj)
{
    touchObj = obj;
    obj.removeEventListener("touchmove", onshowcontouchmove, false);
    obj.removeEventListener("touchend", onshowcontouchend, false);
    obj.removeEventListener("touchstart", onshowcontouchstart, false);
}

//-----缓动效果end--------