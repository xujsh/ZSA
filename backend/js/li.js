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
		divs.hide();//��������ѡ��������
		divs.eq(index).show(); //��ʾѡ�����Ӧ����
		//removeSlowTouchObj(nowSlowtouchObj);
		//nowSlowtouchObj = divs.eq(index);
		//alert("nowSlowtouchObj: " + index);
		changeNowSlowtouchObjByID(index);
		//addSlowTouchObj(nowSlowtouchObj);
	});
}