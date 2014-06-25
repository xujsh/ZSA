var sceditorInstance;

$(function(){
	$.sceditor.command.set("image", {
		exec: function() {
			upload_dialog_type=2;
			$('#upload-dialog').dialog("open");
		},
		tooltip: "Insert an image"
	});

	$("textarea").sceditor({
		plugins: "xhtml",
		style: "/static/css/jquery.sceditor.default.css",
		locale: "cn",
		fonts: "微软雅黑,宋体,仿宋,黑体,楷书"
    });
    
    sceditorInstance = $("textarea").sceditor("instance");

});