var htmlbody = document.getElementById("bodyonline");
var div_mask = document.getElementById("mask");
var div_showcon1 = document.getElementById("tabs-body");

var div_nowshowcon = div_showcon1;
var isMove = false;


//body滚动
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
        addSlowTouchObj(div_nowshowcon);
    }
    else
    {
        div_mask.style.display = "block";
        removeSlowTouchObj(div_nowshowcon);
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
        addSlowTouchObj(div_nowshowcon);
    }
    else
    {
        div_mask.style.display = "block";
        removeSlowTouchObj(div_nowshowcon);
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
        addSlowTouchObj(div_nowshowcon);

    }
    else
    {
        //alert("isMove: " + isMove);
        if(isMove)
        {
            div_mask.style.display = "block";
            removeSlowTouchObj(div_nowshowcon);
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
window.onscroll = htmlbodyscrollend;
div_mask.addEventListener("touchmove", htmlbodyscroll, false);
div_mask.addEventListener("touchend", htmlbodytouchend, false);
div_mask.addEventListener("touchstart", htmlbodytouchstart, false);
alert('ok');