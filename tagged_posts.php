<?php 
require_once 'include/head.php';
if(isset($_GET['tid'])){
	$tid=$_GET['tid'];
	
	$tagObj=new item_class("tags",$tid);
	if(!$tagObj->load_vars()){
		die("INVALID");
	}
}
?>
<script>
  $(function(){
         var currentPage=1;
         var filter="creation_date";
         $("#by-creation_date").addClass("active-filter");
         
         loadData(currentPage,filter,1);
         $(window).scroll(function(){
        	 if(Math.round($(window).scrollTop()) == Math.round($(document).height()-$(window).height()))
                 {                     
					currentPage+=1;
					loadData(currentPage,filter,0);
                 }
             });

         $(".filter").on("click",function(){
     		if($(".filter").hasClass("active-filter")){
                $(".filter").removeClass("active-filter");
 			}
     		$(this).addClass("active-filter");
        	 currentPage=1;
             filter=$(this).attr("id").replace("by-","");
             loadData(1,filter,1);
             
          });
});
  
  function loadData(currentPage,filter,replace)
  {
	  var tid=$("#tid").val();
      $.ajax({
          url:"loadIndex.php",
		     method:"post",
		     data:{pageNumber:currentPage,pageSize:10,filter:filter,tid:tid},
		     r:replace,
		     beforeSend:function(){
                 $(".questions-loading-gif").show();
			     },
		     success :function(html){
		    	 $(".questions-loading-gif").hide();		        
			     if(this.r==1){
			    	 $(".ques-title-container").html(html);
			     }else{		        
					$(".ques-title-container").append(html);
			        }
			     }
		     
          });
  }
</script>
<?php
require_once 'header.php';

?>
<input type="hidden" id="tid" value=<?=$tid;?>>
 <div class="container-fluid index-main">   

    <div class="index-ques-container">  
    
       <div class="wrap-post-filters">
          <div class="post-filters">
             <div class="filter" id="by-creation_date">by date</div>
             <div class="filter" id="by-vote">by vote</div>
             <div class="filter" id="by-_views">by views</div>
          </div>
       </div>
       <div class="ques-title-container">

       </div>
       <div class="questions-loading-gif">
          <img src="post-loading.gif">
       </div>
    </div> 
    <div class="right-side-nav"> 
	    <div class="tag-details-container">
	      <div class="wrap-tag-head">
	        <span class="index-tag-name"><?=ucfirst($tagObj->tag)?></span>
	        <span class="index-tag-edit-btn">edit</span>
	      </div>
	      <div class="wrap-tag-des">
	        <span class="index-tag-des"><?=$tagObj->description?></span>
	      </div>
	      <div class="index-tag-details">
	        <label>followers:</label><span class="index-tag-followers"><?=$tagObj->followers?></span>
	        <label>posts:</label><span class="index-tag-posts"><?=$tagObj->maxpost?></span>
	      </div>
	    </div>	
	    
	   <div class="tag-edit-area">
		     <div>
		      <input class="tag-input" id="new-tag-name">
		      <textarea class="des-textarea" id="new-tag-des"></textarea>
		      </div>
	         <button class="post-btn tag-update-btn">Update</button>
	    </div>      
    </div>
  
</div>
<script >
$(function(){
	document.title="Home-Solucion";

$(function(){
	$(".index-tag-edit-btn").on("click",function(){
            $(".tag-edit-area").show();
            $(".tag-details-container").hide();
            $("#new-tag-name").val($(".index-tag-name").html());
            $("#new-tag-des").val($(".index-tag-des").html());
		});
	$(".tag-update-btn").on("click",function(){
        $(".tag-edit-area").hide();
        $(".tag-details-container").show();

		var tid=$("#tid").val();
		var tag=$("#new-tag-name").val();
		var des=$("#new-tag-des").val();
        $.ajax({
                 url:"manageTags.php",
                 method:"post",
                 dataType:"json",
                 data:{update:1,tid:tid,tag:tag,des:des},
                 success:function(response){
                       if(response.out=="success"){
                    	   $(".index-tag-name").html($("#new-tag-name").val());
                           $(".index-tag-des").html($("#new-tag-des").val());
                         }
                       else alert("Internal Error");
                     }
 
            })
       
	});
	
})

})
</script>
<?php require 'footer.php';?>
 