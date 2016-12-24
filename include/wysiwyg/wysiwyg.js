$(document).ready(wysiwyg);

		function wysiwyg(){

	$(".wysiwyg-container").append('<div class="wysiwyg">'+
			 '<div class="row" style="margin:0;border-bottom:#b3d8ff 1px solid;width:100%;display:flex;justify-content:flex-start;align-items:center;flex-wrap:wrap;">'+
  '<button id="iBold"          data-toggle="tooltip" data-placement="top" title="Bold"class="btn btn-default tool" type="button" ><span class="glyphicon glyphicon-bold"></span></button> '+
  '<button id="iUnderline"     data-toggle="tooltip" data-placement="top" title="Underline"class="btn btn-default tool" type="button" ><span class="fa fa-underline"></span></button>'+
  '<button id="iItalic"        data-toggle="tooltip" data-placement="top" title="Italic SIze"class="btn btn-default tool" type="button" ><span class="glyphicon  glyphicon-italic"></span></button>'+
  '<button id="iColor"         data-toggle="tooltip" data-placement="top" title="Color"class="btn btn-default tool" type="button" ><span class="glyphicon glyphicon-text-color"></span></button>'+
  '<button id="iHorizontalRule"data-toggle="tooltip" data-placement="top" title="Horizontal Rule"class="btn btn-default tool" type="button" ><span class="fa fa-bars"></span></button>'+
  '<button id="iUnorderedList" data-toggle="tooltip" data-placement="top" title="Unordered List"class="btn btn-default tool" type="button" ><span class="fa fa-list-ul"></span></button>'+
  '<button id="iOrderedList"   data-toggle="tooltip" data-placement="top" title="Ordered List"class="btn btn-default tool" type="button" ><span class="fa fa-list-ol"></span></button>'+
  '<button id="iLink"          data-toggle="tooltip" data-placement="top" title="Link"class="btn btn-default tool" type="button" ><span class="glyphicon glyphicon-link"></span></button>'+
  '<button id="iUnlink"        data-toggle="tooltip" data-placement="top" title="Unlink"class="btn btn-default tool" type="button" ><span class="fa fa-chain-broken"></span></button>'+
  '<span  data-toggle="tooltip" data-placement="top" title="Image" class="glyphicon glyphicon-picture image-btn"></span><input  style="display:none;"id="iImage"class="btn btn-info btn-sm tool" name="images[]"  type="file">'+
  '<span  data-toggle="tooltip" data-placement="top" title="Video" class="fa fa-file-video-o icon-2x video-btn"></span><input  style="display:none;"id="iVideo"class="btn btn-info btn-sm tool" name="videos[]"  type="file">'+
  '<button id="iCode"          data-toggle="tooltip" data-placement="top" title="Enter Code"class="btn btn-default tool"      type="button" ><span class="fa fa-code"></span></button>'+
  '<button id="iEmbed"         data-toggle="tooltip" data-placement="top" title="Embed link"class="btn btn-default tool"      type="button" ><span class="fa fa-plus-square"></span></button>'+
  '<button id="iHtml"          data-toggle="tooltip" data-placement="top" title="HTML"class="tool"      type="button">HTML</button>'+
  '<button id="iMax"          data-toggle="tooltip" data-placement="top" title="Maximize" class="tool"    type="button"><span class="glyphicon glyphicon-resize-full fa-lg"></span></button>'+
  '</div></div>');
	if($(".wysiwyg-container").append('<iframe contenteditable="true" name="richTextField" id="richTextField" class="myframe"></iframe>'))
	{
		$('#richTextField').contents().prop('designMode','on');
	}

 	$('#iMax').click(iMax);
 	$('#iEmbed').click(iEmbed);
	$('#iBold').click(iBold);
	$('#iUnderline').click(iUnderline);
	$('#iItalic').click(iItalic);
	$('#iColor').click(iColor);
	$('#iHorizontalRule').click(iHorizontalRule);
	$('#iUnorderedList').click(iUnorderedList);
	$('#iOrderedList').click(iOrderedList);
	$('#iLink').click(iLink);
	$('#iUnLink').click(iUnLink);
	$('.image-btn').click(function(){$('#iImage').trigger('click')});
	$('#iImage').change(iImage);
	$('#iCode').click(iCode);
	$('#iHtml').click(iHtml);
  $('#richTextField').contents().find('body').keypress(brEnter);
	$('.video-btn').click(function(){$('#iVideo').trigger('click')});
	$('#iVideo').change(iVideo);



//bind={active:false};
 function iMax()
 {
	 $('#iMax span').toggleClass('glyphicon-resize-full');
	 $('.wysiwyg-container ').toggleClass('fullscreen');
	 $('body').toggleClass('fullscreen');
	 $('#iMax span').toggleClass('glyphicon-resize-small');
	 $("body").animate({ scrollTop: $('body').prop("scrollHeight")}, 1000);

	 /*
	 $('html, body').on('touchmove', function(e){
		 e.preventDefault();
	 });

	 if(!bind.active)
	    {
			$('html, body').on('touchstart touchmove', disable_touch(e));
			 bind.active=true;
	    }
	 else{
		 $('html, body').off('touchmove',disable_touch(e));
		 bind.active=false;
	 }

	function disable_touch(e){
		 e.preventDefault();
	 }*/
 }



    function brEnter(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		   if(code == 13) {
			   richTextField.document.execCommand('insertHTML', false, '<br>');
		   }
		 }
	if($('#richTextField').length){
    richTextField.document.addEventListener("paste", function(e) {
	    e.preventDefault();
	    var text = e.clipboardData.getData("text/plain");
	    richTextField.document.execCommand("insertHTML", false, text);
	});}

function iEmbed(){
	    var urlPrompt = prompt("Enter Youtube Url:", "http://");
	    var urlReplace = urlPrompt.replace("watch?v=", "embed/");
	    var embed = '<div style="height:500;max-width:540;"><iframe title="YouTube video player" src="'+urlReplace+'" allowfullscreen="true" width="100%" frameborder="0" height="100%"></div>';
	    if(embed != null){
	    	$('#richTextField').contents().find('body').focus();
	        richTextField.document.execCommand("Inserthtml", false, embed);
	    }

	}

function iHtml(){
	//$(".wysiwyg-container").append('<div id="source"></div>');
	var iframe_val=$("#richTextField").contents().find("body").html();
    $('#source').text(iframe_val);
}



function iCode(){
	  $('#richTextField').contents().find('body').focus();
	  richTextField.document.execCommand("insertHTML", false,"<pre class='prettyprint linenums' >Enter Code here"+richTextField.document.getSelection()+"</pre>");
}
function iBold(){
	richTextField.document.execCommand('bold',false,null);
	$('#richTextField').contents().find('body').focus();
}
function iUnderline(){
	richTextField.document.execCommand('underline',false,null);
	$('#richTextField').contents().find('body').focus();
}
function iItalic(){
	richTextField.document.execCommand('italic',false,null);
	$('#richTextField').contents().find('body').focus();
}
function iColor(){
	var color = prompt('Define a basic color or apply a hexadecimal color code for advanced colors:', '');
	richTextField.document.execCommand('ForeColor',false,color);
	$('#richTextField').contents().find('body').focus();
}
function iHorizontalRule(){
	richTextField.document.execCommand('inserthorizontalrule',false,null);
	$('#richTextField').contents().find('body').focus();
}
function iUnorderedList(){
	richTextField.document.execCommand("InsertOrderedList", false,"newOL");
	$('#richTextField').contents().find('body').focus();
}
function iOrderedList(){
	richTextField.document.execCommand("InsertUnorderedList", false,"newUL");
	$('#richTextField').contents().find('body').focus();
}
function iLink(){
	var linkURL = prompt("Enter the URL for this link:", "http://");
	richTextField.document.execCommand("CreateLink", false, linkURL);
	$('#richTextField').contents().find('body').focus();
}
function iUnLink(){
	richTextField.document.execCommand("Unlink", false, null);
	$('#richTextField').contents().find('body').focus();
}

/*$(".wysiwyg-container").append(
		'<div id="myModal" class="modal fade" role="dialog">'+
		'<div class="modal-dialog"><div class="modal-content"><div class="modal-header">'+
		'<button type="button" class="close" data-dismiss="modal">&times;</button>'+
		'<h4 class="modal-title">Upload</h4>'+
		'<p><div id="preview"></div></p>'+
		'</div><div class="modal-body">'+
		'<input type="file" id="image"name="image[]" value="choose" multiple="multiple"></div>'+
		'<p><input type="button"value="Upload" data-dismiss="modal" id="upload"></p></div>'+
		'</div></div></div>');*/

function iImage(){

	var filesSelected = document.getElementById("iImage").files;
	if (filesSelected.length > 0)
	{
	    var fileToLoad = filesSelected[0];

	    if (fileToLoad.type.match("image.*"))
	    {
	        var fileReader = new FileReader();
	        fileReader.onload = function(fileLoadedEvent)
	        {
	            var imageLoaded = document.createElement("img");
	            imageLoaded.src = fileLoadedEvent.target.result;
	            $('#richTextField').contents().find('body').focus();
	            richTextField.document.execCommand('insertimage', false,imageLoaded.src);
	            var images=$('#richTextField').contents().find('img');
	            images.css({"max-height":"75%","max-width":"75%"});
	        };
	        fileReader.readAsDataURL(fileToLoad);
	    }
	    else{alert("This file is not a supported");}
	}
};

 /* if (window.File && window.FileList && window.FileReader) {

        var files = event.target.files; //FileList object
        var output = document.getElementById("preview");
        var picFile=[];
	    for (var i = 0,j=0; i < files.length; i++,j++) {
         var file = files[i];
         //Only pics
        // if (!file.type.match('image')) continue;

         var picReader = new FileReader();
         picReader.addEventListener("load", function (event) {

             picFile[i]= event.target;
             var div = document.createElement("div");
             div.innerHTML = "<img class='thumbnail' src='" + picFile[i].result + "'" + "title='" + picFile[i].name + "'/>";
             output.insertBefore(div, null);
         });
         //Read the image
         picReader.readAsDataURL(file);
     }
// } else {
  //   console.log("Your browser does not support File API");
// }

document.getElementById('image').addEventListener('change', handleFileSelect, false);
*/
var i=1;
function iVideo(){
	var filesSelected = document.getElementById("iVideo").files;
	if (filesSelected.length > 0)
	{
	    var fileToLoad = filesSelected[0];

	    if (fileToLoad.type.match("video.*"))
	    {
	        var fileReader = new FileReader();
	        fileReader.onload = function(fileLoadedEvent)
	        {
	           // var videoLoaded = document.createElement("video");
	            //var sourceLoaded = document.createElement("source");
	           // sourceLoaded.src = fileLoadedEvent.target.result;
	        	videoSrc= fileLoadedEvent.target.result;
	        	area=$('#richTextField').contents().find('body');
	        	var video = $('<video />', {
	        	    id: 'video_'+i,
	        	    class:'video_file',
	        	    src: videoSrc,
	        	    type: 'video/mp4',
	        	    controls: true,
	        	    height:'315',
	        	    width:'560'
	        	});
	        	video.appendTo($(area));

                $('#richTextField').contents().find('video').html("Video not Supporting");
	            i++;
	        	 richTextField.document.execCommand('insertHTML', false, '<br>');
	               area.focus();
	            //alert(frame);
	           // richTextField.document.execCommand('insertHTML', false,frame);
	          // v=$('#richTextField').contents().find('video');
	           //v.append(sourceLoaded);
	          //  var videos=$('#richTextField').contents().find('video');
	           // videos.css({"max-height":"720px","max-width":"720px"});
	        };
	        fileReader.readAsDataURL(fileToLoad);
	    }
	    else{alert("This file is not a supported");}
	}
};

	$("#post").click(function(){
		var iframe_val=$("#richTextField").contents().find("body").html();
		$('textarea#myTextArea').html(iframe_val);
	});
	}
