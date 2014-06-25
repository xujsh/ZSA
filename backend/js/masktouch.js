var htmlBody;
var divMask;

//拖动侦听
var isMove = false;
var isShowMask = function()
{
	//取网页卷上去的高度
	h1=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
	//取网页中能看到高
    h2=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight
	//取网页正文高，包含被卷上去的内容
    h3=document.documentElement.scrollHeight?document.documentElement.scrollHeight:document.body.scrollHeight;
	//alert(h1 + " : " + h2 + " : " + h3);
    //alert('didHtmlbodyTouchend');
	if((h1+h2)>=h3)
	{
		divMask.style.display = "none";
    }
	else
	{
       	if(isMove)
       	{
       		divMask.style.display = "block";
       	}
       	else
       	{
       		isMove = true;
       		timeOut = window.setTimeout("isShowMask()", 400);
    	}
	}
}
var onMaskTouchStart = function(event)
{
	//isShowMask();
	isMove = false;
	divMask.style.display = "none";
};
var onMaskTouchMove = function(event)
{
	isMove = true;
	isShowMask();
};
var onMaskTouchEnd = function(event)
{
	isShowMask();
};

var addMaskTouchObj = function(bodyObj, maskObj)
{
    htmlBody = bodyObj;
    divMask = maskObj;
    var heightP	= window.screen.height;
	var maskHeight = heightP + 235 - 390 + 'px';
	divMask.style.height=maskHeight;
    htmlBody.addEventListener("touchmove", onMaskTouchMove, false);
    htmlBody.addEventListener("touchend", onMaskTouchEnd, false);
    htmlBody.addEventListener("touchstart", onMaskTouchStart, false);
}