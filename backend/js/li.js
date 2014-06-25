var ul = document.getElementById('title_ul');
var lis = ul.getElementsByTagName('li');
console.log(ul);
for(var i=0;i<lis.length;i++)
{
	lis[i].addEventListener("touchend", function(event)
	//lis[i].addEventListener("click", function(event)
	{
		var index = $(this).index();
		var divs  = $("#tabs-body >div");
		$(this).parent().attr("class", "touched" + event.target.id);
		$(this).parent().children("li").attr("class", "");
		$(this).attr("class", "clicked");
		divs.hide();//隐藏所有选中项内容
		divs.eq(index).show(); //显示选中项对应内容
		//removeSlowTouchObj(nowSlowtouchObj);
		//nowSlowtouchObj = divs.eq(index);
		//alert("nowSlowtouchObj: " + index);
		changeNowSlowtouchObjByID(index);
		//addSlowTouchObj(nowSlowtouchObj);
	});
}