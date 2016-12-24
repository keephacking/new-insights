$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
/***************time Ago*********************/

    function timeSince(date) {

        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = Math.floor(seconds / 31536000);

        if (interval > 1) {
            return interval + " years";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes";
        }
        return Math.floor(seconds) + " seconds";
    }
/***************question.php*****************/


    /****deleting and editing comments*****/
    $('.question-answer').on("click",".cmt-btn",function(){
    	action=$(this).html();
    	action=$.trim(action).toLowerCase();
    	cid=$(this).parent().parent().parent().find('input[name="cid"]').val();
    	cmt_box=$(this).parents('.comment-box');
    	if(action=="delete"){
	    	$.ajax({
	    		url:"pComment.php",
	    		method:"POST",
	    		data:{cid:cid,action:action},
	    		box:cmt_box,
	    		success:function(response){
	    			//alert(response);
	    			if($.trim(response)==1)
	    				{
	    		        this.box.hide("slow");
	    				}
	    			else alert("failed");
	    		}
	    	});
    	}
    	else if(action=="edit"){
    		cmt_body=cmt_box.find('input[name="cmt-body"]').val();
    		cmt_box.hide();
    		cmt_box.before(
				 '<div class="form-group">'+
				    '<form>'+
				      '<input type="hidden" name="action" value="'+action+'">'+
				      '<input type="hidden" name="cid" value="'+cid+'">'+
					  '<textarea class="form-control" rows="3" name="comment">'+cmt_body+'</textarea>'+
					  '<button type="button" class="post-btn post-edited-cmt-btn">post</button>'+
					'</form>'+
				'</div>'
    		);
    	}
    });

    $('.question-answer').on("click",".post-edited-cmt-btn",function(){
    	var cid=$(this).parent().find('input[name="cid"]').val();
    	var cmt_body=$(this).parent().find('textarea').val();
    	var action=$(this).parent().find('input[name="action"]').val();
    	var cmt_box=$(this).parent().parent();
    	var username=$('#username').val();
    	var uid=$('#uid').val();
    	$.ajax({
    		url:"pComment.php",
    		method:"POST",
    		data:{cid:cid,action:action,cmt_body:cmt_body},
    		box:cmt_box,
    		cmt_body:cmt_body,
    		username:username,
    		uid:uid,
    		cid:cid,
    		success:function(response){
    			//alert(response);
    			if($.trim(response)==1)
    				{
    		        this.box.hide("slow");

        		    this.box.before("<div class='well comment-box'>"+
        		    		   '<input type="hidden" name="cmt-body" value="'+this.cmt_body+'">'+
				               '<div class="cmt-body">'+this.cmt_body+
				               '--<span class="cmt-author"><a href="profile.php?uid='+this.uid+'">'+this.username+'</a></span></div>'+
				                 '<div class="cmt-options">'+
				                   '<div class="dropdown">'+
					                   '<button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">'+
					                   '<span class="glyphicon glyphicon-option-vertical"></span></button>'+
					                   '<input type="hidden" name="cid" value="'+this.cid+'">'+
					                       '<ul class="dropdown-menu">'+
										      '<li><button  class="cmt-btn clean-btn">Edit</button></li>'+
										      '<li><button  class="cmt-btn clean-btn">Delete</button></li>'+
										   '</ul>'+
					               '</div>'+
				              '</div>'+
					        "</div>");
    				}
    			else {
    				this.box.hide();this.box.before("<div class='well comment-box'>"+
     		    		   '<input type="hidden" name="cmt-body" value="'+this.cmt_body+'">'+
			               '<div class="cmt-body">'+this.cmt_body+
			               '--<span class="cmt-author"><a href="profile.php?uid='+this.uid+'">'+this.username+'</a></span></div>'+
			                 '<div class="cmt-options">'+
			                   '<div class="dropdown">'+
				                   '<button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">'+
				                   '<span class="glyphicon glyphicon-option-vertical"></span></button>'+
				                   '<input type="hidden" name="cid" value="'+this.cid+'">'+
				                       '<ul class="dropdown-menu">'+
									      '<li><button  class="cmt-btn clean-btn">Edit</button></li>'+
									      '<li><button  class="cmt-btn clean-btn">Delete</button></li>'+
									   '</ul>'+
				               '</div>'+
			              '</div>'+
				        "</div>");
    				alert("failed");
    			}
    		}
    	});

    });


    /************popping comment box **************
    var comment_area_length = $('.comment-textarea').length;
      if(comment_area_length>0){

    	  for(var i=0;i<comment_area_length;i++){
			open_comment(i);
    	  }
    	  function open_comment(i){
    		  $("#comment"+i+"btn").click(function(event){
    		  $("#comment"+i).slideToggle();

    		    });

    	  }
      }
   */
   /***********optimised one ***********
    $('.open-comment').click(function(){
    	$('#'+getCommentAreaId(this)).slideToggle();
    });
    function getCommentAreaId(btnClass){
    	btnId=$(btnClass).attr('id');
    	return btnId.replace('btn','');
    }

 ************more optimised one***********/
    $('.question-answer').on('click',".open-comment",function(){
    	$('#'+getCommentAreaId(this)).slideToggle();
    });
    function getCommentAreaId(btnClass){
    	btnId=$(btnClass).attr('id');
    	return btnId.replace('btn','');
    }



/***************usertags.php styling**************/
	c=$('.tag-box').length;
	for(i=0;i<c;i++)
	{
		check_mark(i);
	}

	function check_mark(i){
		$(".tag-box"+i).click(function(){
		if($('#check-tag' + i).is(":checked")){
        $('.tag-box'+i).toggleClass("fa fa-check-circle");
         }
		});

	}

/***************style on resize*******************
	if($(window).width()<675){
		$('body,html,.container,.main-content,.col-sm-8').addClass('resize');
	}
	$(window).resize(function() {
		if($(window).width()<675){
			$('body,html,.container,.main-content,.col-sm-8').addClass('resize');
		}
		else {
			$('body,html,.container,.main-content,.col-sm-8').removeClass('resize');
		}
	});*/

/********************content action menu**********
    var action_menu_length = $('.action-menu').length;
    if(action_menu_length>0){

  	  for(var i=0;i<action_menu_length;i++){


			open_menu(i);
  	  }
    }
  	  function open_menu(i){
  		  $("#action"+i+"menu-btn").click(function(){
  		  $("#action"+i+"menu").slideToggle();
  		  });
  	}
  	*/
	$('.question-answer').on('click','.open-action',function(event){
		$('#'+getActionAreaId(this)).slideToggle();
    });
    function getActionAreaId(btnClass){
    	btnId=$(btnClass).attr('id');
    	return btnId.replace('-btn','');
    }



  	/*
  		  var am=$("#action"+i+"menu");

  		  if(am.height()>('100vh'-$(window).scrollTop())){
  			  alert("menu height is large");
  			 $("#action"+i+"menu").css("e");
  		  }
  		  	*/




/***********notification icon settings**********/


    $('#mess-icon').click(function(){

    			//alert($("#mess-wrap ul").css("display"));
    			if($("#mess-wrap ul").css("display")!="block"){
    			   $("#mess-icon").css({"background-color":"#f2f2f2","color":"#777"});
    			   $("#notif-icon").css({"background-color":"inherit","color":"9d9d9d"});
    			   loadNewMessages(1,10);
    			}
    			else{
    				$("#mess-icon").css({"background-color":"inherit","color":"9d9d9d"});
    			}
    	$('#notif-wrap').find('ul.notif-child').slideUp(0);
    	$("#mess-wrap").find('ul.notif-child').slideToggle(200);



    });
    $('#notif-icon').click(function(){
		var pn=1;

		if($("#notif-wrap ul").css("display")!="block"){
		   $("#notif-icon").css({"background-color":"#f2f2f2","color":"#777"});
		   $("#mess-icon").css({"background-color":"inherit","color":"9d9d9d"});
		   loadNewNotifications(pn,10);
		}
		else{
			$("#notif-icon").css({"background-color":"inherit","color":"9d9d9d"});
		}

    	$('#mess-wrap').find('ul.notif-child').slideUp(0);
    	$("#notif-wrap").find('ul.notif-child').slideToggle(200);
    });

	var viewportWidth = $(window).width();
	if(viewportWidth <= 580){
        $('.notif-parent').on({
        	swipe:function(){
        		if($(this).find("#lm_mid").length!=0){
		            var mid=$(this).find("#lm_mid").val();
		            updateTwoToNotified(mid);
        		}
            if($(this).find("#nid").length!=0){
            	var nid=$(this).find("#nid").val();
            	deleteNotification(nid);
            }
        	$(this).hide("fast");
        }
        },'.notif-child-body li');


	} /*******************hide notif close button***********/
	else{
		$('.notif-parent').on({          //display close button on notifications
        	mouseover:function(){
        		$(this).find(".close-notif-btn").show();
        	},
        	mouseleave:function(){
        		$(this).find(".close-notif-btn").hide();
        	},
        },'.notif-child-body li');


		$('.notif-parent').on({
        	click:function(){

 	            if($(this).parents("li.notif-item-box").find("#nid").length!=0){
 	            	var nid=$(this).parents("li.notif-item-box").find("#nid").val();
 	            	deleteNotification(nid);
 	            	$(this).parents("li.notif-item-box").hide();
 	            }
 	            if($(this).parents("li.notif-item-box").find("#lm_mid").length!=0){
 	            	var mid=$(this).parents("li.notif-item-box").find("#lm_mid").val();
 	            	updateTwoToNotified(mid);
 	            	$(this).parents("li.notif-item-box").hide();
 	            }
        	}
        },'.close-notif-btn');

	}
/*************Add swipe feature and hide close button************/

     $(window).resize(function() {
    	var viewportWidth = $(window).width();
    	if(viewportWidth > 580){

    	      $('.notif-parent').off( "swipe");

    	      $('.notif-parent').on({
    	        	mouseover:function(){
    	        		$(this).find(".close-notif-btn").show();
    	        	},
    	        	mouseleave:function(){
    	        		$(this).find(".close-notif-btn").hide();
    	        	},
    	        },'.notif-child-body li');


    			$('.notif-parent').on({
    	        	click:function(){
    	        		$(this).parents("li.notif-item-box").hide();
    	 	            if($(this).parents("li.notif-item-box").find("#nid").length!=0){
    	 	            	var nid=$(this).parents("li.notif-item-box").find("#nid").val();
    	 	            	deleteNotification(nid);
    	 	            }
    	        	}
    	        },'.close-notif-btn');

      	      $('.notif-parent').on("click",'.close-notif-btn',function(){ //close mess on click
      	    	  if($(this).find("#lm_mid").length>0){
	    	    	  var mid=$(this).find("#lm_mid").val();
	    	          updateTwoToNotified(mid);
	    	    	  $(this).parents("li.notif-item-box").hide("fast");
      	    	  }

    	        });


            }
    	else{
    	      $('.notif-parent').on("swipe",'.notif-child-body li',function(){
    	    	  var mid=$(this).find("#lm_mid").val();
    	          updateTwoToNotified(mid);

    	           if($(this).find("#nid").length!=0){
    	            	var nid=$(this).find("#nid").val();
    	            	deleteNotification(nid);
    	            }
    	    	  $(this).hide("fast");

    	        });

    	}

    });
 function updateTwoToNotified(id){
	 $.ajax({
		 url:"loadMessages.php",
		 method:"post",
		 data:{mid:id}
	 });
 }



/***********account details*******************/

    $(document).ready(function(){

        $("#acc").click(function(){
           $(".privacy").fadeOut("fast");
           $(".notification").fadeOut("500");
           $(".account").slideDown('1000');
        });
        $("#pri").click(function(){
           $(".account").fadeOut("500");
           $(".notification").fadeOut("500");
           $(".privacy").slideDown('1000');
        });
        $("#not").click(function(){
           $(".account").fadeOut("500");
           $(".privacy").fadeOut("500");
           $(".notification").slideDown('1000');
        });


    });


  /*************notification and message***********/

});


/******************displaying options above ****************/
$(document).ready(function() {
	if($('.ques-area').length){
	            var area = $('.ques-area') ;
	            var top_document = area.offset().top;
	            var window_height = $( window ).height();


	            $(window).scroll(function() {
		          var top_window = top_document - $(window).scrollTop();
                  var area_height = area.height();
                  var options = $('#options');
				  var ques_sub= $('.ques-sub').height();

		               if ((area_height + top_window-ques_sub) >= window_height) {
			            var action_menu =$('#options .action-menu');
	                    options.switchClass("content-options",'makeOptionFixed');
	                    action_menu.switchClass("action-menu",'newActionMenu');

                        	 $(".makeOptionFixed").css({"min-width":$('.ques-sub').width()});



	                } else {
		                var action_menu =$('#options .newActionMenu');
		                options.switchClass("makeOptionFixed",'content-options');
		                action_menu.switchClass('newActionMenu',"action-menu");
	                }
	          });
	}
  });

/*****************status ************************/

$(function(){

	getStatus();
	$(".change-status-btn").on("click",function(){
		var  status=$(this).attr("id");
      if(status=="online")
        updateStatus(0);
      else
        updateStatus(1);
	});

});
    
function updateStatus(status_val){
  $.ajax({
     url: 'user_status.php',
     type: 'POST',
     dataType:"json",
     data: {status_val:status_val},
     success:function(response){

         if(response.status==1){
           $(".change-status-btn").html('<span class="glyphicon glyphicon-globe text-success fa-lg"></span> Go offline');
           $(".change-status-btn").attr({"id":"online"});
         }
         else{
            $(".change-status-btn").html('<span class="glyphicon glyphicon-globe text-muted fa-lg"></span> Go online');
            $(".change-status-btn").attr({"id":"offline"});
         }

       }
   });
}

function getStatus(){

 if($(".online-status").length != 0){

	var  status_id=$(".online-status").attr("id");
	var friendBox=$("#get-friend-id");
  var user=friendBox.parent().find(".online-status");
  var friendId=friendBox.val();
	var status=$.trim(status_id.replace("-profile"," "));
//alert(status);
	   $.ajax({
		   url: 'user_status.php',
		   type: 'POST',
       dataType:"json",
		   data: {getStatus:status,friendId:friendId},
       user:user,
       friendBox:friendBox,
		   success:function(response){
         //alert(response.change);
		             		if(response.change==1){
                         if(response.status==0){
                           this.user.find("span").switchClass("green-color","red-color");
                           this.user.attr({"id":"offline-profile"});
                         }
                         else{
                            this.user.find("span").switchClass("red-color","green-color");
                            this.user.attr({"id":"online-profile"});
                         }
		             		}
			   }
       });
		 }
/******************************check new messages for header*************/
	   $.ajax({
		   url: 'loadMessages.php',
		   type: 'POST',
		   data: {check_new_mess:1},
		   success:function(response){

			   response=$.trim(response);
				   if(response!=0){
					   $("#mess-icon .new-notif").fadeIn();
		               $("#mess-icon span").html(response);
				   }
				   else{
					   $("#mess-icon .new-notif").hide();
				   }
			   }
		});
/************************check new notification for users*******************/
	   $.ajax({
		   url: 'loadNotifications.php',
		   type: 'POST',
		   data: {check_new_not:1},
		   success:function(response){

			   response=$.trim(response);
				   if(response!=0){
					   $("#notif-icon .new-notif").fadeIn();
		               $("#notif-icon span").html(response);


				   }
				   else{
					   $("#notif-icon .new-notif").hide();
				   }
			   }
		});
	   setTimeout("getStatus()",1000);
 }


	/******************************load new messages for header*************/
$(function(){
	 var currentPage=1;
     $(".notif-child").scroll(function(){
    	 var top=$(this).scrollTop();
    	 var docHeight=$(this).prop("scrollHeight");
    	 var height=$(this).outerHeight();
    	 var incHeight=height+top;

             if(docHeight<=incHeight+5)
             {
            	 currentPage+=1;
				loadNewMessagesOnScroll(currentPage,3);
             }
         });
});

function loadNewMessagesOnScroll(pn,ps){
	$.ajax({
		   url: 'loadMessages.php',
		   type: 'POST',
		   data:{pn:pn,ps:ps},
		   beforeSend:function(){
			 $("#mess-load-icon").show();
		   },
		   success:function(response){
			   $("#mess-load-icon").hide();
			   response=$.trim(response);
				   if(response!=""){
					   $("#mess-icon .new-notif").fadeOut();
		               $("#mess-icon").parent().find(".notif-child-body")
		               .append(response);
				   }

			   }
		});
}

function loadNewMessages(pn,ps){
	$.ajax({
		url: 'loadMessages.php',
		type: 'POST',
		data:{pn:pn,ps:ps},
		beforeSend:function(){
			$("#mess-load-icon").show();
		},
		success:function(response){
			$("#mess-load-icon").hide();
			response=$.trim(response);
			if(response!=""){
				$("#mess-icon .new-notif").fadeOut();
				$("#mess-icon").parent().find(".notif-child-body")
				.html(response);
			}

		}
	});
}
/******************************load new notifications for header*************/
$(function(){
	var currentPage=1;
	$(".notif-child").scroll(function(){
		var top=$(this).scrollTop();
		var docHeight=$(this).prop("scrollHeight");
		var height=$(this).outerHeight();
		var incHeight=height+top;

		if(docHeight<=incHeight+5)
		{
			currentPage+=1;
			loadNewNotificationsOnScroll(currentPage,3);
		}
	});
});

function loadNewNotificationsOnScroll(pn,ps){
	$.ajax({
		url: 'loadNotifications.php',
		type: 'POST',
		data:{pn:pn,ps:ps,load:1},
		beforeSend:function(){
			$("#nitif-load-icon").show();
		},
		success:function(response){
			$("#notif-load-icon").hide();
			response=$.trim(response);
			if(response!=""){
				$("#notif-icon .new-notif").fadeOut();
				$("#notif-icon").parent().find(".notif-child-body")
				.append(response);
			}

		}
	});
}

function loadNewNotifications(pn,ps){
	$.ajax({
		url: 'loadNotifications.php',
		type: 'POST',
		data:{pn:pn,ps:ps,load:1},
		beforeSend:function(){
			$("#notif-load-icon").show();
		},
		success:function(response){
			$("#notif-load-icon").hide();
			response=$.trim(response);
			if(response!=""){
				$("#notif-icon .new-notif").fadeOut();
				$("#notif-icon").parent().find(".notif-child-body")
				.html(response);
			}

		}
	});
}
function deleteNotification(id){
	$.ajax({
		url: 'loadNotifications.php',
		method: 'POST',
		data:{id:id},
	});
}

function loadTagDetails(pn,ps){
	$.ajax({
		url: 'loadNotifications.php',
		type: 'POST',
		data:{pn:pn,ps:ps,load:1},
		beforeSend:function(){
			$("#notif-load-icon").show();
		},
		success:function(response){
			$("#notif-load-icon").hide();
			response=$.trim(response);
			if(response!=""){
				$("#notif-icon .new-notif").fadeOut();
				$("#notif-icon").parent().find(".notif-child-body")
				.html(response);
			}

		}
	});
}
/*****************load tag details******************/
$(function(){
var timeout;
$(".question-answer,.index-main,.edit-ques").on({
    mouseenter:function(){
        var tid=$(this).find("#tid").val();

        var div=$(this).find(".related-tag-details");
        if(div.length>0){
        if (timeout != null) { clearTimeout(timeout); }

        timeout = setTimeout(function(){$.ajax({
				url:"loadTag.php",
				method:"post",
				data:{tid:tid},
				success:function(response){
					if($.trim(response)!="")
					{
						//var top=div.height();
						div.hide();
	  					div.html(response);
	  					div.animate({height: 'toggle',width:'toggle'});
					}
				}
	        })},1000);
        }

   },
   mouseleave:function(){
   	 if (timeout != null) {
            clearTimeout(timeout);

            timeout = null;
         }
       $(this).find(".tag-container").hide();

  },
},".related-tag");
//for mobile devices

	var windowWidth=$(window).width();
	if(windowWidth<750){
	$(".question-answer,.index-main,.edit-ques").off("mouseenter");
	$(".question-answer,.index-main,.edit-ques").off("mouseleave");

	$(".question-answer,.index-main").on({
       click:function(event){

       	var tid=$(this).find("#tid").val();
           var div=$(this).find(".related-tag-details");
           if(div.length>0){
            $.ajax({
  				url:"loadTag.php",
  				method:"post",
  				data:{tid:tid},
  				success:function(response){
  					if($.trim(response)!="")
  					{
  						var top=div.height();
  	  					div.html(response);
  	  					$(".close-tag-details").show();
  					}
  				}
  	        });
           }
        }
		},".related-tag");

	$(".question-answer,.index-main").on({
		 click:function(e){
    	        e.stopPropagation();

				$(this).parents(".tag-container").hide();
	 		 }

		},".close-tag-details");

	}


/*****************Add color to interesting tagged
 * post******************/
   	var favId=[];
	favTag=$(".index-fav-tag-container").find(".related-tags");
	var i=0;
	favTag.find(".related-tag").each(function(index,element){

		favId[i++]=$(element).find("#tid").val();

	})


    $(document).on('DOMNodeInserted', function(e) {
    	quesTag=$(e.target).find(".related-tags");
        var flag=0;
    	quesTag.find(".related-tag").each(function(index,element){
    		flag=$.inArray($(element).find("#tid").val(),favId)
    		if(flag!=-1){
    			$(this).parents(".ques-row-container").addClass("tagged-interesting");
    		}
    	})


    });
/***********index.php*********************/
	/********************delete favourite tag************/
		$(function(){
			$(".open-edit-tag-area-btn").on("click",function(){
				$(".edit-tag-area").css("display","flex");
				$(".delete-fav-tag-btn").show();
			})
			$(".index-main").on({
				click:function(){
					div=$(this).parents(".related-tag");
					var tid=div.find("#tid").val();
					$.ajax({
						url:"manageUserTags.php",
					    data:{tid:tid,del:"delete"},
					    dataType:"json",
					    method:"post",
					    success:function(response){
					    	if($.trim(response.out)=="deleted"){
					    	  div.hide();
					    	}
					    	else alert("Internal Error");
					    }
					});


					}
			},".delete-fav-tag-btn")
		})
/*************************header.php**************************/

    /***********************search posts*********************/
      $(".search-input").on("keypress",function(event){
        if(event.which==13)
         {
           var query=$(".search-input").val();
           window.location.assign('searchPosts.php?query='+query);
         }
      })
    /********************************************************/

		$(".site-options-btn").on("click",function(){
			$(".site-options-menu-area").animate({right:"0"});
			$("#dimScreen").addClass("overlayScreen");
		})
		$("#dimScreen").click(function(){
			$(".site-options-menu-area").animate({right:"-500px"});
			$(this).removeClass("overlayScreen");
			$(".expert-finding-zone").animate({height:"0"});
		});
		$(".find-expert-btn").on("click",function(){
//			$(".expert-finding-zone").css("height","100%");
			$(".expert-finding-zone").animate({height:"100%"});
		});
		$(".expert-back-btn").on("click",function(){
			$(".expert-finding-zone").animate({height:"0"});
		});

/********************expert*******************/

checkHelpReq();

})
function checkHelpReq(){

  var status=$(".change-status-btn").attr('id');
  //alert(status);
  if(status=="online"){

     $.ajax({
        url:"findExpert.php",
        type:"post",
        dataType:"json",
        data:{check_table:1},

        success:function(rep){
          if(rep.count>0){
             //alert("You have "+rep.count+" request for direct chat");
           }

        }
     })
  }
  setTimeout("checkHelpReq()",1000);
}
