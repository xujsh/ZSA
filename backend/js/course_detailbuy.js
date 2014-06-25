
//滑动效果
var headerHeader=document.getElementById("header").offsetHeight;
var centent=document.getElementById("centent").offsetHeight;
var topHeight = centent+headerHeader;
var top1 = $(".body_top").offset().top;
var top2 = 0;
//var conheight=0;
//var h1=0;
//var h2=0;
var div_all=document.getElementById("all");
var divMsg=document.getElementById("message");
var divCou=document.getElementById("course");
var divIntro=document.getElementById("intro");
var htmlbody = document.getElementById("bodyonline");
var div_mask = document.getElementById("mask");
var div_showcon1 = document.getElementById("pinl");
var div_showcon2 = document.getElementById("showcon2");
var div_showcon3 = document.getElementById("showcon3");

var div_nowshowcon = div_showcon1;
$(".con").css("overflow-x","hidden");
var isMove = false;
var timeOut;

var htmlbodyscroll = function()
{
    isMove = true;
    //取网页卷上去的高度
    h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
    //取网页中能看到高
    h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
    //取网页正文高，包含被卷上去的内容
    h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
    if((h1+h2)>=h3)
    {
        //alert('scroll 滚动条已经到最下面啦');
        div_mask.style.display = "none";
        //addShowconEventListener();
        addSlowTouchObj(div_nowshowcon);
        //addSlowTouchObj(div_showcon2);
        //addSlowTouchObj(div_showcon3);
    }
    else
    {
        div_mask.style.display = "block";
        //removeShowconEventListener();
        removeSlowTouchObj(div_nowshowcon);
        //removeSlowTouchObj(div_showcon2);
        //removeSlowTouchObj(div_showcon3);
    }
}

var showMask = function()
{
    //取网页卷上去的高度
    h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
    //取网页中能看到高
    h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
    //取网页正文高，包含被卷上去的内容
    h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
    if(!(h1+h2)>=h3)
    {
        div_mask.style.display = "block";
    }
    removeSlowTouchObj(div_nowshowcon);
    clearnTimeout(timeOut);
}


var htmlbodyscrollend = function()
{
    //alert("htmlbodyscrollend end");
    //取网页卷上去的高度
    h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
    //取网页中能看到高
    h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
    //取网页正文高，包含被卷上去的内容
    h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
    if((h1+h2)>=h3)
    {
        //alert('touch end 滚动条已经到最下面啦');
        div_mask.style.display = "none";
        //addShowconEventListener();
        addSlowTouchObj(div_nowshowcon);
        //addSlowTouchObj(div_showcon2);
        //addSlowTouchObj(div_showcon3);
    }
    else
    {
        div_mask.style.display = "block";
        //removeShowconEventListener();
        removeSlowTouchObj(div_nowshowcon);
        //removeSlowTouchObj(div_showcon2);
        //removeSlowTouchObj(div_showcon3);
    }
}

var htmlbodytouchend = function()
{
    //alert("htmltouch end");
    //取网页卷上去的高度
    h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
    //取网页中能看到高
    h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
    //取网页正文高，包含被卷上去的内容
    h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
    if((h1+h2)>=h3)
    {
        //alert('touch end 滚动条已经到最下面啦');
        div_mask.style.display = "none";
        //addShowconEventListener();
        addSlowTouchObj(div_nowshowcon);
        //addSlowTouchObj(div_showcon2);
        //addSlowTouchObj(div_showcon3);

    }
    else
    {
        //alert("isMove: " + isMove);
        if(isMove)
        {
            div_mask.style.display = "block";
            //removeShowconEventListener();
            removeSlowTouchObj(div_nowshowcon);
            //removeSlowTouchObj(div_showcon2);
            //removeSlowTouchObj(div_showcon3);
        }
        else
        {
            timeOut = window.setTimeout("showMask()", 1000);
            //showMask();
        }
    }
    isMove = false;
}
var htmlbodytouchstart = function()
{
    div_mask.style.display = "none";
}

htmlbody.addEventListener("touchmove", htmlbodyscroll, false);
htmlbody.addEventListener("touchend", htmlbodytouchend, false);
//htmlbody.addEventListener("onscroll", htmlbodytouchend2, false);
window.onscroll = htmlbodyscrollend;
div_mask.addEventListener("touchmove", htmlbodyscroll, false);
div_mask.addEventListener("touchend", htmlbodytouchend, false);
div_mask.addEventListener("touchstart", htmlbodytouchstart, false);



$(document).ready(function()
{		
	var availHeight=window.screen.availHeight;
	var conheight=availHeight-195;
	$(".con").css("height",conheight);
	$("#alert_win").css("height",conheight-14);
	$(".message").css("height",conheight-97);
	$(".course").css("height",conheight-77);
	$("#pinl").css("height",conheight-105);
	$("#mask").css("height",conheight);
	$(".beian_winBG").css("height",conheight-14);
	$(".tijiao").css("top",conheight-64);
	$("#all").css("height",conheight+topHeight);
})



