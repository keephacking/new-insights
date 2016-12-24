$(function(){
	checkCounts();
    colors=["#009999","#ff9933","#339966","#666633","#663300","#330066","#660066","#660033","#660000"];
	$("#c").css({
	  "width":"100%",
	  "min-height":"100%",
	  "height":"100%",
	  "overflow":"hidden"
	});
  $(".main-content").on({
	  click:function(){

		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  dataType:"json",
			  data:{prepare:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("preparing ...");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
			  },
			  success:function(response){
				  $(".result-container span").html("Success");
				  $(".pre-ques-count").html(response.question);
				  $(".pre-tags-count").html(response.tag);
				  $("#c").css("display","none");
				  this.maxbtn.trigger("click");
				  this.maxbtn.hide();
			  }
		  });
	  }
  },".prepare-btn");
  $(".main-content").on({
	  click:function(){
		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  data:{fillDatas:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  this.maxbtn.trigger("click");
				  $("#c").css("display","block");
				  $(".result-container span").html("Loading ...");
			  },
			  success:function(response){
				  this.maxbtn.trigger("click");
				  $("#c").css("display","none");
				  $(".result-container span").html("success");
				  this.maxbtn.hide();
			  }
		  });
	  }
  },".fillDatas-btn");
  $(".main-content").on({
	  click:function(){
		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  data:{clearDatas:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("Loading ...");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
			  },
			  success:function(response){
				  this.maxbtn.trigger("click");
				  $(".result-container span").html("success");
				  $("#c").css("display","none");
				  this.maxbtn.hide();
			  }
		  });
	  }
  },".clearDatas-btn");
  $(".main-content").on({
	  click:function(){
		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  data:{findProbability:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("Loading ...");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
			  },
			  success:function(response){
				  $(".result-container span").html("success");
				  $("#c").css("display","none");
				  this.maxbtn.trigger("click");
				  this.maxbtn.hide();
			  }
		  });
	  }

  },".findProb-btn");


  $(".main-content").on({
	  click:function(){
		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  data:{norm:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("Loading ...");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
				  this.maxbtn.hide();
			  },
			  success:function(response){
				  $(".result-container span").html("success");
				  $("#c").css("display","none");
				  this.maxbtn.trigger("click");
			  }
		  });
	  }
  },".norm-btn");
  $(".main-content").on({
	  click:function(){

		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  data:{displayMatrix:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("Loading ...");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
			  },
			  success:function(response){
				  $(".result-container span").html(response);
				  $("#c").css("display","none");
				  this.maxbtn.show();
				  this.maxbtn.css("position","fixed");
			  }
		  });

	  }
  },".displayMatrix-btn");

  $(".main-content").on({
	  click:function(){
			var cby=$("#cby").val();
			if(cby!=""){
			  $.ajax({
				  url:"HAC/cluster.php",
				  method:"post",
				  //dataType:"json",
				  data:{findClusters:1,cby:cby},
				  maxbtn:$(".max-btn"),
				  beforeSend:function(){
					  $(".result-container span").html("Loading............");
					  $("#c").css("display","block");
					  this.maxbtn.trigger("click");
				  },
				  success:function(response){
					  $(".result-container span").html(response).fadeOut("slow");
					  $("#c").css("display","none");
					  setTimeout(function(){
					$(".result-container span").html("Success. click display to view it").fadeIn("slow");
					  },1000);
					  this.maxbtn.trigger("click");
					  this.maxbtn.hide();
				  }
			  });
			}
	  }
  },".findClusters-btn");
  $(".main-content").on({
	  click:function(){

		  $.ajax({
			  url:"HAC/cluster.php",
			  method:"post",
			  dataType:"json",
			  data:{displayClusters:1},
			  maxbtn:$(".max-btn"),
			  beforeSend:function(){
				  $(".result-container span").html("Loading............");
				  $("#c").css("display","block");
				  this.maxbtn.trigger("click");
			  },
			  success:function(response){
				  this.maxbtn.show();
				  this.maxbtn.css("position","relative");
				  $("#c").css("display","none");
				  structure="";
				  wrapper="";
				  var c="";
			/********************************
				  container="<div class=tag-container>";
				  $.each(response,function(key,value){
					  structure+="" +
				  		"<div class='tag-box tag"+value.cluster+"'>" +
                           value.tag+
				  		"</div>";
					  c=value.cluster;
				  })

				  wrapper="<div class=tag-wrapper>"+container+structure+"</div></div>";
				  $(".result-container span").html(wrapper);
                  for(i=1;i<=c;i++){
					$(".tag"+i).wrapAll("<div class=box></div>");
                  }
              ****************styling****************/

				  $.each(response,function(key,value){
					    $(".result-container span").hide().append(value.tag).fadeIn(300);
					    //$(".result-container").effect("explode","500");

				  });

				  setTimeout(function(){
					   $.each(response,function(key,value){
							  structure+="" +
						  		"<div>" +
						  		  "<input type=hidden class=cluster value=tag"+value.cluster+">"+
						  		   value.tag+
						  		"</div>";
							  c=value.cluster;
						  });
					     $(".result-container span").html(structure);
					  structure=$(".result-container span");
					  structure.find("div").addClass("tag-box");
					  structure.wrapInner("<div class=tag-container></div>");
					  wrapper="<div class=tag-wrapper></div>";
					  $(".tag-container").wrap(wrapper);
				  },2000);


				  setTimeout(function(){
				     $(".tag-container").addClass("anrot");
				  },2500);
				  setTimeout(function(){
					  $(".tag-box").each(function(){
						  var color=$(this).find('input').val();
						  $(this).addClass(color);
					  })
				  },3500);
				  setTimeout(function(){
					  $(".tag-container").removeClass("anrot");
					  for(i=1;i<=c;i++){
						  $(".tag"+i).wrapAll("<div class=box></div>");
						  $(".tag"+i).css("background-color",colors[i]);
					  }
				  },4000);



			  }
		  });
	  }
  },".displayClusters-btn");

  $.ajax({

	  url:"HAC/cluster.php",
	  dataType:"json",
	  method:"post",
	  data:{prev:1},
	  success:function(response){
		  $(".pre-ques-count").html(response.question);
		  $(".pre-tags-count").html(response.tag);
	  }
  });
/**************maximize****************/
  $(".max-btn").click(function(){
	  $(".result-container").toggleClass("fullscreen");

  });

});

function checkCounts(){
	  $.ajax({
		  url:"HAC/cluster.php",
		  dataType:"json",
		  method:"post",
		  data:{checkCount:1},
		  success:function(response){
			  $(".new-ques-count").html(response.question);
			  $(".new-tags-count").html(response.tag);
		  }
	  });
	  setTimeout("checkCounts()",5000);
}
/********************manage user**********************/
$(function(){
	$(".manage-user-btn").on({
		click:function(){
			$(".manage-user-container").css("display","flex");
			$.ajax({
				url:"manageUser.php",
				type:"post",
				data:{display_moderators:1},
				success:function(rep){
					rep=$.trim(rep);
					$(".user-container").html(rep);
				}
			})
		}
	});
	$(".mod-update-btn").on({
		click:function(){
			var btn=$(".manage-user-btn");
			$.ajax({
				url:"manageUser.php",
				type:"post",
				data:{updateMod:1},
				btn:btn,
				success:function(){
					 this.btn.trigger("click");
				}
			})
		}
	})
})
