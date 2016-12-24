

/************pop sound*************/
$(function(){


	$.ajaxSetup({ cache:false });
/****************resizing text area*******************/
	//var width=$(".mess-container").width();
	var widthContent=$(".mess-content").width();
	widthContent-=50;
	$(".mess-item-container img").css({"width":widthContent});
	//$("#mess-form").css("width",width);



	$(window).resize(function(){
	    widthContent=$(".mess-content").width();
		  widthContent-=50;
		$(".mess-item-container img").css({"width":widthContent});
	});


});


$(function(){

	var inht=$(".mess-input-wrapper").height();
	var textarea_ht=$(".mess-text-container").height();
	$('.insert-image').css({"height":textarea_ht});
	$('.mess-content').css({"margin-bottom":inht,"position":"relative","overflow":"auto"});

});


$(function(){
	  uid=$("#uid").val();
	  fid=$("#fid").val();
	  blocked=$("#blocked").val();
	  if(blocked==1){
		  $(".blocked-area").addClass("block-chat");
	  }
	  var file=0;
	  /**************load messages on scroll***************/


			         currentPage=1;
		             loadMessages(fid,currentPage);

             $(".mess-content").animate({ scrollTop: $('.mess-content').height()+1000},500);
	         $(".mess-content").scroll(function(){
	                 if($(".mess-content").scrollTop() <= 10)
	                 {
						currentPage+=1;
						loadMessages(fid,currentPage);
	                 }
	             });



  $("#mess-form").submit(function(){
	  var textarea=$(this).find('textarea');
	  var image=$(this).find('input');

	  var message=textarea.val();


		  var filesSelected = document.getElementById("iImage").files;

  		if (filesSelected.length > 0)
  		{

  			$("#image-load").show();
  		    var fileToLoad = filesSelected[0];

  		    if (fileToLoad.type.match("image.*"))
  		    {
  		        var fileReader = new FileReader();

  		        fileReader.onload = function(fileLoadedEvent)
  		        {

  		        	message+="<br><img src='"+fileLoadedEvent.target.result+"'>";



  				      $.ajax({
  				    	      url:'postChat.php',
  				    	      type:"POST",
  				    		  data:{
  	  				    		  message:message,
  	  				    		  uid:uid,
  	  				    		  fid:fid
  	  				    		  },
  				    	      success:function(response){
  							    textarea.val("");

  	  						  $('.mess-item-container').prepend(response);

									var	widthContent=$(".mess-content").width();
										widthContent-=50;
									$(".mess-item-container img").css({"width":widthContent});

  	  						  $(".mess-content").animate({ scrollTop: $('.mess-content').prop("scrollHeight")}, 500);

  	  					    var empty = $("#iImage");
  	  						empty.replaceWith( empty.val('').clone( true ) );
  				    	  },
  				    	  complete:function(){
  				    		$("#image-load").hide();
  				    	  }
  				      });

  		        };
  		        fileReader.readAsDataURL(fileToLoad);


  		    }
  		    else{alert("This file is not a supported");}
  		}
  		else{
  			if($.trim(message)!=""){
			  $.post('postChat.php',{
			      message:message,
			      uid:uid,
			      fid:fid
				  },function(response){
					  textarea.val("");
					  $('.mess-item-container').prepend(response);
					  $(".mess-content").animate({ scrollTop: $('.mess-content').prop("scrollHeight")}, 500);

				  });

  			}
  		}



	   return false;
  });

  $('.mess-item-container').on("click",'.mess-delete',function(){
	 var parent=$(this).parent();
	 var mid=$(this).attr('rel');

	 $.ajax({
			 url:"pChat.php",
			 method:'post',
			 data:{mid:mid,
				 action:"delete"},
			 parent:parent,
			 success:function(response){
				 response=$.trim(response);
				 if(response){
					 parent.hide("fast");
				 }
				 else alert("error");
			 }

	 });
  });
});

function loadMessages(fid,currentPage){
	$("#mess-loading").show();
	$.ajax({url:'loadChat.php',
	        data:{fid:fid,currentPage:currentPage,loadNew:0},
	        method:"post",
	        success:function(response){
	        		$('.mess-item-container').append(response);

	        },
	        complete: function(){
	            $('#mess-loading').hide();

	    	    widthContent=$(".mess-content").width();
	    		widthContent-=50;
	    		$(".mess-item-container img").css({"width":widthContent});
	    		loadNewPost();

	          }

	});

}

function loadNewPost(){
	  $.ajax({url:'loadChat.php',
		  method:"post",
		  data:{fid:fid,loadNew:1},
		  success:function(response){

		     if($.trim(response)=="blocked"){
				  if(!$(".blocked-area").hasClass("block-chat")){
				    $(".blocked-area").addClass("block-chat");
				    alert("blocked");
				  }

			  }
		     else{
		    	   if($(".blocked-area").hasClass("block-chat")){
		    		   $(".blocked-area").removeClass("block-chat");

		    	   }
		    	  if($.trim(response)!=0){

					$('.mess-item-container').prepend(response);

					/***************play sound************/
					  $("#pop-sound").trigger('play');


			    	    widthContent=$(".mess-content").width();
			    		widthContent-=50;
			    		$(".mess-item-container img").css({"width":widthContent});
		    	  }
			  }

		  }
	  });
	  if(blocked!=1){
	     checkSeen();
	  }
	  setTimeout("loadNewPost()",1000);
}
function checkSeen(){
	  var mid=$(".mess-item-container").find("a").attr("rel");

	  $.ajax({url:'pChat.php',
		  method:"post",
			dataType:"json",
		  data:{mid:mid,status:1},
		  success:function(response){
			  if($.trim(response.seen)!=0){
				  $('.mess-item-container').find(".unseen").switchClass("unseen","seen");

			  }
		  }
	  });

}

/**********insert image******************/
$(function(){
	$('#image-btn').click(function(){
		$("#iImage").trigger("click");
	});
});

/****************message activity*********************/
$(function(){
	checkIfWriting();

	$(".mess-textarea").keyup(function(){
		var mess=$.trim($(".mess-textarea").val());
			if(mess!=''){

				  $.ajax({
					  url:'pChat.php',
					  method:"post",
					  data:{
						  writing:1,
						  uid:uid,
						  fid:fid
						  }
				  });
			}
			else{
                 deleteMessageActivity();
			}

	});

	/****************continues check**************/



});

function checkIfWriting(){
	  $.ajax({
		  url:'pChat.php',
		  method:"post",
			dataType:"json",
		  data:{
			  checkWriting:1,
			  uid:uid,
			  fid:fid
			  },
	     success:function(response){

	    	 if(response.out!=0){
	    		   $("#write-notification").show();
		    	 }
		    else{
		    	$("#write-notification").hide();
		    	 }
	     }
	  });
	  setTimeout("checkIfWriting()",1000);
}
function deleteMessageActivity(){

		$.ajax({
			url:'pChat.php',
			method:"post",
			data:{
				writing:0,
				uid:uid,
				fid:fid
				  }
		});

}
$(document).ready(function()
		{
		    $(window).on("unload", function() {
		    	deleteMessageActivity();

		    });
			$(".mess-textarea").blur(function(){
				deleteMessageActivity();
			});
		});
