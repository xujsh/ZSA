function showqtip(target, msg) {
	target.qtip({
		overwrite: true,
		content: msg,
		show: {
			ready: true
		},
		hide: {
			delay: 5000
		},
		events: {
			hide: function(event, api) {
				target.qtip('destroy')
			}
		}
	});
}