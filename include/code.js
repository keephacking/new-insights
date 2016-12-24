//$(document).ready(function(){	
  function selectText(containerid) {
		window.getSelection().removeAllRanges();
		if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(containerid));
		range.select();
		} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().addRange(range);
		}
	}
//});