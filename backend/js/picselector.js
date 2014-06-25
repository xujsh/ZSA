var upload_dialog_type;
//var piccount = 0;

$(function() {

	$('#upload-dialog').dialog({
		autoOpen:false,
		modal:true,
		width: 700,
		height: 500,
		maxWidth: 700,
		maxHeight: 500,
		resizable: false,
		position: { my: "top", at: "top+20", of: window }
	});
	
	$('#select-pic-button').click(function(){
		upload_dialog_type=1;
		$('#upload-dialog').dialog("open");
	});
	
	$('#select-single-pic-button').click(function(){
		upload_dialog_type=3;
		$('#upload-dialog').dialog("open");
	});
	
	$('#remove-pic-button').click(function(){
		$('#titlepic').empty();
		$('#article_picid').attr('value', 0);
		$(this).hide();
	});
	
	var onUploadPicClicked = function() {
	
    	var picurl = $(this).find('img').attr('src');
    	var picid = $(this).attr('id').substr(3);
    	var orgpicurl = picurl.replace(/_thumb200/, '');
    	
    	if (upload_dialog_type == 1)
    	{
    		piccount++;
			$('#titlepic').after('<input type="hidden" name="pic['+piccount+']" value="'+picid+'" class="picid'+picid+'">');
			$('<img/>').attr('src', picurl).addClass('picid'+picid).appendTo('#titlepic');
			$('.picid'+picid).dblclick(function(){
				var picid = $(this).attr('class');
				$('.'+picid).remove();
			});
			
		}
		else if (upload_dialog_type == 2)
		{
			var htmlstr = '<img src="'+ orgpicurl +'" style="max-width:800px;">';
			sceditorInstance.wysiwygEditorInsertHtml(htmlstr);
		}
		else if (upload_dialog_type == 3)
    	{
    		$('#titlepic').html('');
			$('#titlepic').append('<input type="hidden" name="picid" value="'+picid+'" class="picid'+picid+'">');
			$('<img/>').attr('src', picurl).addClass('picid'+picid).appendTo('#titlepic');
			$('.picid'+picid).dblclick(function(){
				var picid = $(this).attr('class');
				$('.'+picid).remove();
			});
			
		}
		
		$('#upload-dialog').dialog("close");
    	return false;
    };
	
	$('#fileupload').fileupload({
    	dataType: 'json',
    	add: function (e, data) {
    		$('.fileinput-button').attr('disabled', 'disabled');
    		$('#file').attr('disabled', 'disabled');
    		$('<img/>').attr('src', '{$appbasepath}images/preload.gif').attr('id', 'loading').prependTo('#upload-pics');
    		data.submit();
    	},
    	done: function (e, data) {
    	
    		if (data.result.status != 1)
    		{
    			showqtip($('.fileinput-button'), data.result.info);
    		}
    		else
    		{
    			$('#loading').remove();
    			$('<a/>').attr('href','#').attr('id', 'pic'+data.result.picid ).addClass('uploadpic').append($('<img/>').attr('src', data.result.picurl).addClass('img-polaroid')).prependTo('#upload-pics').click(onUploadPicClicked);
    			$('.fileinput-button').removeAttr('disabled');
    			$('#file').removeAttr('disabled');
    		}
        }
    });
    
    $('#upload-pics .uploadpic').click(onUploadPicClicked);

});