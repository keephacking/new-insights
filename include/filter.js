$(document).ready(function(){
	
	var iframeBody=$('#richTextField').contents().find('body');
	iframeBody.attr('contenteditable', true);
	$(iframeBody).on( 'keyup',function() {
	    var txt = $(this).html();
	    var regex = /xxx/gi;
	    var result=regex.test(txt);
	    if(result){
        alert("Such words cannot be used in this site");
	    }

	});
	
});
