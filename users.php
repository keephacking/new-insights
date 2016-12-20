<?php require 'include/head.php';

?>
<script>
$(function(){
	$('#user-container').load("searchUser.php");
	$('#search-user').keyup(function(){
          user=$(this).val();
          $('#user-container').load("searchUser.php",{"user":user});
		});
});
</script>
<?php require 'header.php';?>

<div class="container-fluid">
	<form class="form-horizontal" role="form">
	  <div class="form-group">
	    <label class="control-label col-sm-2" for="Find">Find user:</label>
	    <div class="col-sm-2">
	      <input type="text" class="form-control" name='user'id="search-user" placeholder="Enter user name">
	    </div>
	  </div>
	</form>
</div>

<div class="container">
  <div class="box-container" id="user-container">

  </div>
</div>
<br>
<?php require 'footer.php';?>
