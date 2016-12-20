<?php require_once 'include/head.php';?>
<style>
<!--
.container{
height:88%;
}
-->
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
<?php require_once 'header.php';

if(isset($_GET['new'])&isset($_GET['id'])&isset($_GET['x']))
{
	$user->x=$_GET['x'];
	$user->id=$_GET['id'];

	if($user->activate_user())
	{?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Welcome</h4>
      </div>
      <div class="modal-body">
        <p>Now you can login with your registered mail id and password.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
	}
}
?>


 <div class="container">
    		<p><br/></p>
  		<div class="row">
  	 			<div class="col-md-4">
  				<div class="panel-default">
  					<div class="panel-body">
    						<div class="page-header">
  							<h3>Login Area</h3>
						    </div>
						<form role="form" id='login_form' name='login_form' method="post" action="pLogin.php">
  							<div class="form-group">
    								<label for="InputEmail">Email</label>
    								<div class="input-group">
  									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
  									<input type="text" class="form-control" name="email" id="em" placeholder="Enter email">
								</div>
  							</div>
  							<div id="email_error_mess" >

  							</div>

  							<div class="form-group">
    								<label for="InputPassword">Password</label>
    								<div class="input-group">
  									<span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
  									<input type="password" name="password" class="form-control" id="pw" placeholder="Password">
								</div>
  							</div>
  							<div id="password_error_mess">

  							</div>
  							<hr/>

  							<button type="submit" id="login" name="login" class="btn btn-primary" ><span class="glyphicon glyphicon-lock"></span> Login</button>
  							<p><br/></p>
						</form>
  					</div>
				</div>
  			</div>
		</div>
    </div>
<script src="include/login.js"></script>
<?php require_once 'footer.php';?>
