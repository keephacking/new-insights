<?php require_once 'include/head.php';?>

        
  
		<link rel="stylesheet" href="include/contact.css">

   
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="include/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="include/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="include/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="include/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="include/ico/apple-touch-icon-57-precomposed.png">
<?php require 'header.php';?>
      <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Feel Free to Contact Us</strong></h1>
                            <div class="description">
                            	<p>
	                            	Some description
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Contact us</h3>
                            		<p>Fill in the form below to send us a message:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-envelope"></i>
                        		</div>
                            </div>
                            <div class="form-bottom contact-form">
			                    <form role="form" action="assets/contact.php" method="post">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="contact-email">Email</label>
			                        	<input type="text" name="email" placeholder="Email..." class="contact-email form-control" id="contact-email">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="contact-subject">Subject</label>
			                        	<input type="text" name="subject" placeholder="Subject..." class="contact-subject form-control" id="contact-subject">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="contact-message">Message</label>
			                        	<textarea name="message" placeholder="Message..." class="contact-message form-control" id="contact-message"></textarea>
			                        </div>
			                        <button type="submit" class="btn">Send message</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
 
     <script src="include/js/jquery.backstretch.min.js"></script>
     <script src="include/js/retina-1.1.0.min.js"></script>
     <script src="include/contact.js"></script>
     <script>
$(document).ready(function(){
$('.main-nav').hide();
	
});
 </script> 
<?php require_once 'footer.php';?>                               		                                		