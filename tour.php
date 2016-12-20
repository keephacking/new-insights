<?php require "include/head.php"; ?>

    <style type="text/css">
         body{
         margin:0;
         }
        .imgStyle {
            width: 100px;
            height: 100px;
            border: 3px solid grey;
        }
        .imageGallery{
        
        display: flex;
	    flex-direction:row;
	    flex-wrap:wrap;
        }
        .selectedImage{
        position:fixed;
        top:70px;
        right:100px;
        }
        .thumbnails{
        position:relative;
        left:100px;
        display:flex;
        flex-direction:column;
        }
    </style>
    <script type="text/javascript">

        $(document).ready(function () {
        	
        	$('.main-nav').hide();
        	
        	
            $('#thumbnail').on({
                mouseover: function () {
                    $(this).stop().animate({
                        'cursor': 'hand',
                        'border-Color': 'red',
                        'height':'110',
                        'width':'110'
                       
                    },100);
                    
                },
                mouseout: function () {
                    $(this).stop().animate({
                        'cursor': 'default',
                        'border-Color': 'grey',
                        'height':'100',
                        'width':'100',
                        'position':'static'
                    },500);
                   
                },
                click: function () {
                	
                    var imageURL = $(this).attr('src');
                    $('#mainImage').fadeOut(100, function () {
                        $(this).attr('src', imageURL);
                    }).fadeIn(100);
                }
            },'img');
        });
    </script>
<?php require 'header.php'; ?>
  <div class="imageGallery">
   <div class="selectedImage">
    <img  id="mainImage" style="border:3px solid grey"
         src="tour/1.jpg" height="550" width="640" />
   </div>
    <div class="thumbnails" id="thumbnail">
        <img class="imgStyle" src="tour/1.jpg" />
        <img class="imgStyle" src="tour/20.jpg" />
        <img class="imgStyle" src="tour/2.jpg" />
        <img class="imgStyle" src="tour/19.jpg" />
        <img class="imgStyle" src="tour/3.jpg" />
        <img class="imgStyle" src="tour/18.jpg" />
        <img class="imgStyle" src="tour/1.jpg" />
        <img class="imgStyle" src="tour/20.jpg" />
        <img class="imgStyle" src="tour/2.jpg" />
        <img class="imgStyle" src="tour/19.jpg" />
        <img class="imgStyle" src="tour/3.jpg" />
        <img class="imgStyle" src="tour/18.jpg" />
        <img class="imgStyle" src="tour/1.jpg" />
        <img class="imgStyle" src="tour/20.jpg" />
        <img class="imgStyle" src="tour/2.jpg" />
        <img class="imgStyle" src="tour/19.jpg" />
        <img class="imgStyle" src="tour/3.jpg" />
        <img class="imgStyle" src="tour/18.jpg" />
        <img class="imgStyle" src="tour/1.jpg" />
        <img class="imgStyle" src="tour/20.jpg" />
        <img class="imgStyle" src="tour/2.jpg" />
        <img class="imgStyle" src="tour/19.jpg" />
        <img class="imgStyle" src="tour/3.jpg" />
        <img class="imgStyle" src="tour/18.jpg" />
    </div>
  </div>
</body>
</html>
