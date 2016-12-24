

$(document).ready(function() {
    document.title = 'Login-Solucion';
    var empty=true;
    var email_error=true;
    $('#em').blur(function(){
    	var email_value = $('#em').val();
    	email_error_mess=$('#email_error_mess');
    	if(email_value !=""){
    	   email_error_mess.load('pLogin.php',{'check_email':email_value},function(data){
    		   email_error=$('#email_error_mess #email_error').val() == '1' ? true : false;              
    	   });

    	}
    	
    });


	
	function ifEmpty(){
		
		var email_value = $('#em').val();
		var password_value = $('#pw').val();
		if(email_value == '' || password_value == ''){
				$("#password_error_mess").html("Both fields are necessary");
				empty = true;
				
			}
			else{
				empty = false;
				
			}
		}


	
	$("#login_form").submit(function() {
	 
	     ifEmpty();
	 
		if(empty ==false && email_error ==false)
			return true;
		else
			return false;
		
		

	});
});
