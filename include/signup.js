$(document).ready(function() {
	
	document.title = 'SignUp-Solucion';
    $('#username_error_mess').hide();
	$('#email_error_mess').hide();
	$('#password_error_mess').hide();
	$('#rpassword_error_mess').hide();
	
	var error_username=false;
	var error_email=false;
	var error_password=false;
	var error_rpassword=false;
	
	$('#un').focusout(function(){
		check_username();
	});
	$('#em').focusout(function(){
		check_email();
	});
	$('#pw').focusout(function(){
		check_password();
	});
	$('#rpw').focusout(function(){
		check_rpassword();
	});
	
	function check_username(){
		
		var username_length = $('#un').val().length;
		
		if(username_length != 0){
		
			if(username_length < 4 || username_length > 20){
				$('#username_error_mess').html("Should be between 4 - 20 characters");
				$('#username_error_mess').show();
				error_username = true;
			}
			else {
				$('#username_error_mess').hide();
			}
		}
		else {
			error_username = true;
			$('#username_error_mess').hide();
		}
	}
	
	function check_email(){
		
		var email_value = $('#em').val();
		if(email_value != ''){
			
			var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
			
			if(pattern.test($('#em').val())) {
				$("#email_error_mess").hide();
			} else {
				$("#email_error_mess").html("Invalid email address");
				$("#email_error_mess").show();
				error_email = true;
			}
		}
		else{
			error_email =true;
			$("#email_error_mess").hide();
		}
	}
	
	function check_password(){
         
		var password_length = $('#pw').val().length;
		
		 if(password_length !=0){
			 
			if(password_length < 6){
				$('#password_error_mess').html("Should be more than 6 characters");
				$('#password_error_mess').show();
				error_password = true;
			}
			else {
				$('#password_error_mess').hide();
			}
		 }
		 else {
			 error_password =true;
			 $('#password_error_mess').hide();
		 }
	}
	function check_rpassword(){
		var password = $('#pw').val();
		var rpassword = $('#rpw').val();
		
		if(password != rpassword){
			$('#rpassword_error_mess').html("Password didn't match");
			$('#rpassword_error_mess').show();
			error_rpassword = true;
		}else{
			$('#rpassword_error_mess').hide();
		}
		
	}
	
	$("#signup_form").submit(function() {
		
    	error_username = false;
		error_password = false;
		error_rpassword = false;
		error_email = false;
											
		check_username();
		check_password();
		check_rpassword();
		check_email();
		
		if(error_username == false && error_password == false && error_rpassword == false && error_email == false) {
			email= $('#em').val();
			var result=false;
			$.ajax({
				url:"pSignup.php",
				method:"post",
				data:{ajax:1,email:email},
				dataType:"json",
				success:function(response){
					if(response.out=="error"){
						alert(response.mess);
						result=false;
					}
					else if(response.out=="success") {
						result=true;
					}
				},
				async: false
			});
			
			return result;
		} else {
			return false;	
		}

	});
});
	
