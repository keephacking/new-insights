<link type="text/css" rel="stylesheet" href="include/font-awesome/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="include/bootstrap-3.3.6-dist/css/bootstrap.min.css" >
<script src="include/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link type="text/css" href="include/style.css" rel="stylesheet">
<script src="include/script.js"></script>
<script src="include/moment.min.js"></script>
<script src="include/livestamp.min.js"></script>
<link rel="stylesheet" href="include/tag/bootstrap-tagsinput.css">
<script src="include/tag/bootstrap-tagsinput.js"></script>
<script>
$(function(){
 $(".tag-for-expert").on("keyup",function(e){
   var tag=$(".tag-for-expert input[type='text']").val();
    if($.trim(tag)!=""){
     $.ajax({
          url:"list_tag.php",
          method:"post",
          data:{tag:tag},
          success:function(response){
               $(".tag-list-container").html(response);
           }
        });
    }
    else $(".tag-list-container").html("");

 })
 $(".sub-expert-finding-tag-area").on("mouseleave",function(){
   $(".tag-list-container").html("");
 })

 $(".tag-list-container").on({
   click:function(){
     tag=$.trim($(this).html());
     var tag=$(".tag-for-expert input[type='text']").val(tag);

     var e = jQuery.Event("keypress");
     e.which = 13;
     $(".tag-for-expert input[type='text']").trigger(e);

   }
 },".listed-item-name");

/***********************ajax to find the expert***********/
    $(".expt-fnd-btn").on({
      click:function(){
        if($.trim($("#tag-for-expert-input").val())!=" "){
          tag=$("#tag-for-expert-input").val();
          $.ajax({
            url:"findExpert.php",
            type:"post",
            dataType:"json",
            data:{tag:tag},
              success:function(rep){
                var htm="";
                $(".open-expt-model").trigger("click");
                $(".site-options-menu-area").animate({right:"-200%"});
                $("#dimScreen").removeClass("overlayScreen");
                if(rep==""){
                  htm="no one available now";
                }
                else{
                  $(rep).each(function(index,element){
                    htm+="<div class=expt-user><img src='"+element.photo+"'><span>"+element.username+"</span><a href=chat.php?fid="+element.uid+">chat</a></div>";
                  })

                }
                 $(".display-expt-users").html(htm);
              }
          })

        }
      }
    });
})
</script>
</head>
<body>
<?php if($user->loggedin){?>

<!--  /**************model for displaying expert users**********/ -->
      <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg open-expt-model" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Experts available</h4>
          </div>
          <div class="modal-body display-expt-users">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
<!--  /*************************end*****************************/ -->

<input type="hidden" name="uid" id="uid" value="<?php echo $user->id;?>">
<input type="hidden" name="username" id="username" value="<?php echo $user->username;?>">
<input type="hidden" id="get-user-id" name="get-user-id" value="<?php echo $user->id;?>">
<input type="hidden" id="get-user-status" name="get-user-status" value="<?php echo $user->status;?>">
<?php }?>
<div id='dimScreen'></div>
<div class="wrap-document">
<nav class="navbar navbar-inverse main-header ">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
   <?php if($user->loggedin){?>
     <ul class="notif-parent">
	     <li id="notif-wrap">
	     <span   id="notif-icon"class="notif-btn  glyphicon glyphicon-bell">
	 <span class="green new-notif">1</span>
	     </span>
	        <ul class="notif-child">
	         <li><span class="notif-child-head">
	         <span>Notifications</span>
	         <img src="include/load_notif.gif" id="notif-load-icon"class="load_notif_icon">
	         </span>
	           <ul class="notif-child-body"></ul></li>
	        </ul>
	     </li>
	     <li id="mess-wrap">
	     <span id="mess-icon" class="notif-btn glyphicon glyphicon-envelope">
	             <span class="red new-notif"></span>
	      </span>
	        <ul class="notif-child">
	           <li><span class="notif-child-head">
	                 <span>New Messages</span>
	             <img src="include/load_notif.gif" id="mess-load-icon"class="load_notif_icon">
	           </span>
	           <ul class="notif-child-body"></ul></li>
	        </ul>
	     </li>
     </ul>
<?php }?>
    </div>



    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
            <!-- Search bar starts here************* -->
    <?php if($user->loggedin){?>
        <div class="search-div pull-right">
    <?php }else {?>
        <div class="search-div">
    <?php } ?>
          <input type="search" class="search-input" placeholder="search..">
        </div>

     <!-- Search bar ends here************* -->
      <ul class="nav navbar-nav navbar-right dropUser-wrap">
                    <?php
              if(!$user->loggedin)
              { ?>
	                 <li><a href="signup.php"><span class="glyphicon glyphicon-thumbs-up"></span> signup</a></li>

                     <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php
              }
	           ?>

      </ul>

    </div>
  </div>
</nav>
          <div class="main-container">
            <div class="panel text-left main-nav">
	            <div class="panel-body">

	             <a  href="index.php"> <img src="logo.png" id="logo"  alt="Logo" ></a>
	              <a href="tour.php" type="button" class="tour-button">
	                <span class="glyphicon glyphicon-thumbs-up"></span> Take a tour
	              </a>

	                 <ul class="nav  nav-pills  navbar-right ">
                       <li class="nav-buttons"><a href="tags.php">Tags</a></li>
                       <li class="nav-buttons"><a href="users.php">Users</a></li>
                   <?php
	              if($user->loggedin)
	              { ?>
                       <?php if($user->admin==1) {?>
                         <li class="nav-buttons"><a href="admin.php">ACP</a></li>
                       <?php } ?>
                       <li class="nav-buttons"><a href="favourite.php">Favourite</a></li>
                       <li class="site-options-btn pull-right"><a href="#"><span class="glyphicon glyphicon-menu-hamburger"></span></a></li>
                       </ul>
                       <div class="site-options-menu-area">
                          <div class="sidebar-user-details-container">
	                            <div class="sidebar-user-details">
		                             <div class="sidebar-user-image">
		                                <img src=<?=$user->profile_image?>>
		                             </div>
		                             <div class="sidebar-user-subdetails">
		                                  <?php if($user->status==1){?>
										  <button id="online" class="change-status-btn clean-btn"><span class="glyphicon glyphicon-globe text-success fa-lg"></span> Go offline</button>
										  <?php }else {?>
										  <button id="offline" class="change-status-btn clean-btn"><span class="glyphicon glyphicon-globe text-muted fa-lg"></span> Go online</button>
										  <?php }?>
		                               <span class="sidebar-user-name"><?=$user->username?></span>
		                               <span class="sidebar-user-rep"><?=$user->reputation?></span>
		                               <span><a href="login.php?logout=true">Logout</a></span>
		                             </div>
	                             </div>
	                             <div class="sidebar-user-options">
									  <a href="account.php"><span class="glyphicon glyphicon-cog"></span> Settings</a>
				                      <a href="profile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a>
                                </div>
                           </div>
                          <div class="site-options-menu-container">
                             <div class="site-options"><a href="askquestion.php">
                             <img src="askQues.jpg">Ask Question</a></div>
                             <div class="site-options"><a href="#" class="find-expert-btn">
                             <img src="askFriend.jpg">Find Experts</a></div>
                             <div class="site-options"><a href="myChat/">Group Chat</a></div>

                             <div class="expert-finding-zone">
                                <span class="expert-back-btn-span"><button class="expert-back-btn post-btn">back</button></span>
                                <div class="sub-expert-finding-zone">
                                   <div class="sub-expert-finding-tag-area form-group tag-for-expert" style="clear:both;">
                                          <label for="tags">Tags:</label>
                                          <select multiple data-role="tagsinput" class='form-control' id="tag-for-expert-input" name='tags[]'></select>
                                          <div class="tag-list-container"></div>

                                   </div>

                                   <span><button class="post-btn expt-fnd-btn">FIND</button></span>

                                </div>
                             </div>
                          </div>
                       </div>
                  <?php
	              }else echo "</ul>";

	              ?>

	            </div>
	          </div>
<div class=main-content>
