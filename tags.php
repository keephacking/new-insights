<?php require 'include/head.php';

?>
<script>
$(function(){
	$('#tag-container').load("searchTags.php");
	$('#search-tag').keyup(function(){
          tag=$(this).val();
          tag=$.trim(tag);
          $('#tag-container').load("searchTags.php",{"tag":tag});
		});

    $(".add-tag-btn").on("click",function(){
          $(".tag-input-area").toggle("show");
	   });

});

</script>
<?php require 'header.php';
if(isset($_POST['submit'])){
	$tagObj=new item_class();
	$tagObj->set("tags");

	$tag=trim($_POST['tag']);
	$tag=$tagObj::$link->real_escape_string($tag);
	$tagDes=$tagObj::$link->real_escape_string($_POST['tag-des']);

	$tagObj->sql_query("select * from tags where tag='".$tag."'");

	if($tagObj->num_rows>0){
		$tag_id=$tagObj->load_datas();
		$tagObj->set("tags",$tag_id['id']);
		$tag_data=array("description"=>$tagDes);
		$tagObj->update($tag_data);
		 if($tagObj->affected_rows>0){
		 	echo "Success";
		 }
		 else echo "Error";
	}
	else{
		    $tag_data=array("tag"=>$tag,"description"=>$tagDes);
			$tagObj->insert($tag_data);

	}
}
?>
<?php if($user->loggedin){
	if($user->admin==1 or $user->moderator==1){?>
<div class="add-tag-container">
  <button class="post-btn add-tag-btn" >Add</button>
  <div class="tag-input-area">
    <form role="form" action="tags.php" method="post">
	  <div class="form-group">
	    <label for="tag">Tag Name:</label>
	    <input type="text" class="form-control" id="tag" name="tag">
	    <label for="tag-des">Tag Description:</label>
	    <textarea class="form-control" id="tag-des" name="tag-des"></textarea>
	    <button type="submit" class="post-btn" name="submit">post</button>
	  </div>
	</form>
  </div>
</div>
<?php }}?>

<div class="container-fluid">
	<form class="form-horizontal" role="form">
	  <div class="form-group">
	    <label class="control-label col-sm-2" for="Find">Find tags:</label>
	    <div class="col-sm-2">
	      <input type="text" class="form-control" name="tag" id="search-tag" placeholder="Enter tag name">
	    </div>
	  </div>
	</form>
</div>

<div class="container">
  <div class="box-container" id='tag-container'>

  </div>
</div>
<br>

<?php require 'footer.php';?>
