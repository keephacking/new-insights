<?php require 'include/head.php';
$user::$link->
?>

<?php require 'header.php';?>
<div data-role="page" id="my_view">
     <div data-role="header">
        <h1>My page</h1> 
    </div> 	
    <div role="main" class="ui-content">
    
        <div id="myItem">
<ul data-role="listview">
    <li>Acura</li>
    <li>Audi</li>
    <li>BMW</li>
    <li>Cadillac</li>
    <li>Ferrari</li>
</ul>            
        </div>
    
    </div> 

</div>  
<script>
$(document).on("pageinit", "#my_view", function(){   
    $('#my_view').on( "swipeleft swiperight", "#myItem li", function( event ){
        alert(event.type);

    });
});
</script>
<?php require 'footer.php';?>


<div class="ques-body-container">
			     		    			      
				      <div class="related-tags">
				      
					         <?php $tags->sql_query("select * from question_tags where qid=$id");
					               while($tag_id=$tags->load_datas()){
					              	  $tag_details->set("tags",$tag_id['tid']);
					              $tag_details->load_vars();
					               ?>
						        <div class="wrap-tag-del">
			                     <div class="related-tag"><?=$tag_details->tag;?></div>
			                     <span class="glyphicon glyphicon-remove-sign"></span></div>
			                     <?php }?>
		                     
		                     <input type="text" id="new-tag" name="new-tag" class="new-tag-input">
		                      
		                     <div class="dropdown">
							  <button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu">
							   <li> <span class="glyphicon glyphicon-plus fa-sm"></span><button class="clean-btn  edit-tag">Add</button></li>
							   <li> <span class="glyphicon glyphicon-minus-sign fa-sm"></span><button class="clean-btn  del-tag">Delete</button></li>
	                   
							  </ul>
							</div>                   
	                  </div>
			    
			      <div class="ques-body">
	                  
			         <?php echo $question->body;?>
			      </div>