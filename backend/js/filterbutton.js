$(function(){
	$('#filter-button').click(function(){
		if ($(this).html() == '收起筛选')
		{
			$('.pm_sx').hide();
			$(this).html('展开筛选');
		}
		else
		{
			$('.pm_sx').show();
			$(this).html('收起筛选');
		}
		
		return false;
	});
});