<?php
require_once 'include/head.php';
if($user->loggedin){
$tagObj=new item_class();
	$tagObj->sql_query("select * from user_tags LEFT JOIN tags on tags.id=tid where user_tags.uid=$user->id");
	$tags=array();
    while($tag=$tagObj->load_datas()){
    	$tags+=array($tag['id']=>$tag['tag']);
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
             /******************jus for testing purpose******************
             var data="<h1>$(window).scrollTop() == $(document).height() - $(window).height()";
             data+="<br>$(window).scrollTop()="+Math.round($(window).scrollTop());

             data+="<br>$(document).height()="+$(document).height()+"<br>";
             data+="$(window).height()="+$(window).height()+"<br>";
             data+="$(document).height() - $(window).height()="+Math.round($(document).height() - $(window).height()-1)+"</h1>";

             $("#check").html(data);

           ******************jus for testing purpose*******************/
                 if(Math.round($(window).scrollTop()) == Math.round($(document).height() - $(window).height()))
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
             loadData(currentPage,filter,1);

          });

	  });
</script>
<?php
require_once 'header.php';

?>
<!--
<div id="check"style="color:#fff;text-align:center;background-color:rgba(0,0,0,.3);position:fixed;top:0;left:0;bottom:0;right:0;"></div>
-->

 <div class="container-fluid index-main">

    <div class="index-ques-container">
			<?php if(!isset($_GET['search'])){?>
       <div class="wrap-post-filters">
          <div class="post-filters">
             <div class="filter" id="by-creation_date">by date</div>
             <div class="filter" id="by-vote">by vote</div>
             <div class="filter" id="by-_views">by views</div>
          </div>
       </div>
       <?php } ?>
       <div class="ques-title-container">

       </div>
       <div class="questions-loading-gif">
          <img src="post-loading.gif">
       </div>
    </div>
    <div class="right-side-nav">

      <?php if($user->loggedin){?>
	    <div class="index-fav-tag-container">
	        <p>Favorite Tags <a href="#" class="open-edit-tag-area-btn">edit</a></p>

		     <div class="related-tags">
		       <?php foreach($tags as $k=>$v){ ?>
		       <div class="related-tag">
	                <input type="hidden" id="tid" value='<?=$k?>'>
	                <div class="wrap-tag"><?=$v;?><span class="delete-fav-tag-btn">✖</span></div>
		       </div>
		       <?php }?>
		     </div>
		     <div class=edit-tag-area>
		        <input type="text" class="add-tag-input" id="new-tag">
		        <input type="hidden"id="new-tag-id" value="">
		        <button type="button" class="post-btn add-tag-btn">Add</button>
		     </div>
		     <div class="tag-sug-container"></div>
	    </div>


	   <?php }?>

    </div>

</div>
<script >
$(function(){
	document.title="Home-Solucion";

/***********************suggestTags for adding new ones***********/
   $(".tag-sug-container").hide();
   $("#new-tag").on("keyup",function(e){
           var tag=$(this).val();
            if($.trim(tag)!=""){
             $.ajax({
                  url:"tagSuggest.php",
				  method:"post",
				  data:{tag:tag},
				  success:function(response){
					  $(".tag-sug-container").show();
							  if($.trim(response)!=""){
		                       $(".tag-sug-container").html(response);
							  }else $(".tag-sug-container").hide();

					  }
                });
            }
            else $(".tag-sug-container").hide();


	   });


 $(".tag-sug-container").on({

    mouseleave:function(){$(this).find(".mask-suggested-tag").hide();},
    mouseover:function(){$(this).find(".mask-suggested-tag").show();},
    click:function(e)
          {
    	        var tag=$.trim($(this).find(".suggested-item-name").html());
    	        var tid=$(this).find("input[name='tid']").val();
    	        $(this).parents(".index-fav-tag-container").find("#new-tag-id").val(tid);

    	        $("#new-tag").val(tag);
    	        $(".tag-sug-container").hide();
          }
	 },".suggested-item");

 $(".add-tag-btn").on("click",function(){
		var tag=$(this).parent().find("#new-tag").val();
		var idin=$(this).parent().find("#new-tag-id");
		if(idin.length>0){
		   var tid=idin.val();
		}
		else {
              var tid=0;
			}
	  $.ajax({
				url:"manageUserTags.php",
				method:"post",
				dataType:"json",
				data:{tid:tid,add:1,tag:tag},
				input:$(this).parent().find("#new-tag"),
				div:$(this).parents(".index-fav-tag-container").find(".related-tags"),
				tag:tag,
				tid:tid,
				idin:idin,
				success:function(response){
					idin.val("");
					if(response.out=="added"){
			            this.input.val("");
		                this.div.append(
		                      "<div class=related-tag>"+
	           	                "<input type=hidden id=tid value="+response.tid+">"+
	           	                "<div class=wrap-tag>"+this.tag+"<span class=delete-fav-tag-btn style='display:block;'>✖</span></div>"+
	           		       "</div>"
	                             );
		                $(".tag-sug-container").hide();
					}
					if(response.out=="exists")
					{
                       alert("Already exists");
                       this.input.val("");
                       $(".tag-sug-container").hide();
					}
					if(response.out=="unavailable")
					{
                       alert("Can choose from available tags only");
                       this.input.val("");
                       $(".tag-sug-container").hide();
					}
				}
	        })
	 })
	 /****************filter post***********************/


});


function loadData(cp,filter,replace)
{

    $.ajax({
        url:"loadIndex.php",
		     method:"post",
		     data:{pageNumber:cp,pageSize:10,filter:filter},
		     r:replace,
		     beforeSend:function(){
                    $(".questions-loading-gif").show();
			     },
		     success:function(html){
			     if($.trim(html)!=0){
				     if(this.r==1){
				    	 $(".ques-title-container").html(html);
				     }else{
						$(".ques-title-container").append(html);
				        }
				     }
			     $(".questions-loading-gif").hide();
		         }

        });
}
</script>
<?php require 'footer.php';?>
