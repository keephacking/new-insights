<?php require_once 'include/head.php';?>

<script src="include/wysiwyg/wysiwyg.js"></script>
<link rel="stylesheet" href="include/wysiwyg/wysiwyg.css">
<link rel="stylesheet" href="include/tag/bootstrap-tagsinput.css">
<?php require_once 'header.php';?>

<div class="container">
  <h2>Ask Question</h2>
   <form name="q_form" id="q_form" role="form" method="post" action="questionpost.php"> 
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="text" name="title" >
      </div>
   
    <div class="wysiwyg-container ">  
	 <textarea name="myTextArea" id="myTextArea"></textarea>
   </div>
    <div id="source"></div>		
    <br><br>
    
    <div class="form-group tag-input" style="clear:both;">
      <label for="tags">Tags:</label>
      <select multiple data-role="tagsinput" class='form-control' id="tag-input-field" name='tags[]'></select>
      <div class="tag-sug-container"></div>
    </div>
<?php     
/***********user details***************/
if($user->loggedin)
{
	echo "<input type='hidden' name='owner_id' value='$user->id'>";
}

 ?>   
    <button type="submit" id="post" class="post-btn" name="submit">Post</button>
  </form>


</div>

<script src="include/tag/bootstrap-tagsinput.js"></script>
<script>
 $(function(){
   $(".tag-input").on("keyup",function(e){
	     
           var tag=$(".tag-input input[type='text']").val();
            if($.trim(tag)!=""){
             $.ajax({
                  url:"tagSuggest.php",
				  method:"post",
				  data:{tag:tag},
				  success:function(response){
                       $(".tag-sug-container").html(response);
					  }
                });
            }
            else $(".tag-sug-container").html("");
            
	      
	   });
  
   
	 });

 $(".tag-sug-container").on({
    
    mouseleave:function(){$(this).find(".mask-suggested-tag").hide();},
    mouseover:function(){$(this).find(".mask-suggested-tag").show();},
    click:function()
     { 
        var tag=$.trim($(this).find(".suggested-item-name").html());
        $(".tag-input input[type='text']").val(tag);

		        var e = jQuery.Event("keypress");
		        e.which = 13; 
		        $(".tag-input input[type='text']").trigger(e);
        
        },
	 },".suggested-item");

 </script>
 
 	 <script>
	 $(function(){
		 alert("hii");
		 if($("richTextField")){
	 field = document.getElementById("richTextField");
	 field.contentDocument.designMode = "On";
		 }
	 });
	 </script>
<?php require_once 'footer.php';?>
