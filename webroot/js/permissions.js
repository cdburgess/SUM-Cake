var PermissionControl = {};

PermissionControl.documentReady = function() {
	PermissionControl.allowToggle();
}


PermissionControl.allowToggle = function() {
	$('img.permission-toggle').unbind();
	$('img.permission-toggle').click(function() {
		var $this = $(this);
		var perm = $this.data('perm');
		var role = $this.data('role');
		var id = $this.data('id');

		// show loader
		$this.attr('src', '/img/circle_ball.gif');

		// prepare loadUrl
		var loadUrl = '/admin/permissions/toggle/';
		loadUrl    += perm+'/'+role+'/'+id+'/';

		// now load it
		var target = $this.parent();
		$.post(loadUrl, null, function(data, textStatus, jqXHR) {
			target.html(data);
			PermissionControl.allowToggle();
		});
		return false;
	});
}

$(document).ready(function() {
	$('table div.controller').click(function() {
		$('.controller-'+$(this).text()).toggle();
		if ($(this).hasClass('expand')) {
			$(this).removeClass('expand');
			$(this).addClass('collapse');
		} else {
			$(this).removeClass('collapse');
			$(this).addClass('expand');
		}
	});
	PermissionControl.allowToggle();
});
