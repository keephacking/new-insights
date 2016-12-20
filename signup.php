<?php require_once 'include/head.php';?>

<?php require_once 'header.php';?>
<div class="container">
   
	<div class="panel-body panel-default">   
			<div class="page-header">
				<h1>Join Us</h1>
			</div>

		 <form id="signup_form" action="pSignup.php" method="post" role="form">
		   <div class="form-group">
			<table class="signup-table">
					<tr><td class="text">
					
					<label>Display name</label> </td></tr>
					<tr><td>
					<input type="text" id="un" name="username" data-toggle="tooltip" title="your fav name for simplicity" placeholder="sachu" class="form-control"></td>
					
					<td><span class="error_mess" id="username_error_mess"></span></td></tr>
					
					
					<tr><td class="text"><label>Email</label></td></tr>
					
					<tr><td><input type="email" id="em" name="email" data-toggle="tooltip" title="your mail id" placeholder="ymail@ydomain.com" class="form-control"></td>
					
					<td><span class="error_mess" id="email_error_mess"></span></td></tr>
					
					
					<tr><td class="text"><label>Password</label></td></tr>
					
					<tr><td><input type="password" id="pw" name="password" data-toggle="tooltip" title="should be atleast 6 char long" class="form-control"></td>
					
					<td><label  class="showPassword"id="showpw" ><span class="glyphicon glyphicon-eye-open"><input type="checkbox"style="display: none;"></span></label></td>
					
					<td><span class="error_mess" id="password_error_mess"></span></td></tr>
					
					
					<tr><td class="text"><label>Retype Password</label></td></tr>
					
					<tr><td><input type="password" id="rpw" name="rpassword" data-toggle="tooltip" title="Retype the password to avoid mistakes" class="form-control"></td>
					
					<td><label class="showPassword" id="showrpw"><span class="glyphicon glyphicon-eye-open"><input  type="checkbox"  style="display: none;"></span></label></td>
					
					<td><span class="error_mess" id="rpassword_error_mess"></span></td></tr>
					
					
					<tr><td><button type="submit" id="button" class="btn btn-default btn-sm" name="SignUp" class="form-control">
					
					<span class="glyphicon glyphicon-lock"></span> Sign Up</button></td></tr>
					
					
					<tr><td class="sm-info">By registering ,you agree to the <a>terms and conditions</a></td></tr>
			</table>
		  </div>
		 </form>
		 <hr/>
	 </div>	

</div>
<script src="include/signup.js"></script>
<script>
$(document).ready(function(){
	$('.showPassword').on('click',function(){
       var id=$(this).attr('id');
       $('#'+id.replace('show','')).attr('type', $("#"+id+ "  input").is(':checked') ? 'text' : 'password');
		});
});
</script>
<?php require_once 'footer.php';?>