//<!--
	function rating(r) {
		if(r==1 && $("#rating").val()==1) {r=0;}
		$(".tdBox").find("#on").each(function(i){
			if(i>=r) {$(this).fadeOut(500);}
			else {$(this).fadeIn(500);}
		})
		$("#rating").val(r);
	}
//-->
