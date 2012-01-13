//app/webroot/js/comments.js

//<!--


	function showcomments() {
		$("#leavecomment").fadeOut(500);
		$("#comment").fadeIn(500);
		$("#commentarea").focus();
	}

	function shownew(id) {
		$("#"+id+'new').fadeIn(500);
		$("#"+id+'newdef').focus();
		$("#"+id+'cur').hide();
	}
	function showcur(id) {
//		document.getElementById(id).style.display='none';
		$("#"+id+'new').hide();
		$("#"+id+'cur').fadeIn(500);
		$("#"+id+'curdef').focus();
	}
	function hidehelp(id) {
		$("#help"+id).fadeOut(500);
		$("#show"+id).show();
		$("#inhelp"+id).val(-1);
	}
	function showhelp(id) {
		$("#help"+id).fadeIn(500);
		$("#show"+id).hide();
		$("#inhelp"+id).val(1);
	}
	function edithelp(id) {
		$("#helpdsp"+id).hide();
		$("#helpedit"+id).show();
		$("#helpeditbox"+id).focus();
		$("#inedited"+id).val(1);
	}

//-->