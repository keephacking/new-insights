<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Chat App</title>
    <link rel="stylesheet" href="css/skeleton.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
  <div class="container">
    <div class="row">
       <form class="username-form" action="index.html" method="post">
          <div class="">
            <label for="">Set Username</label>
            <input type="text" name="name" value="" class="username-input">
          </div>
          <button type="submit" class="button-primary"name="button">Set</button>
       </form>
    </div>
    <div class="columns">
      <h1>Chat</h1>
      <h3>Message for</h3>
      <h5 class="username"></h5>
       <div class="message-window">
         <div class="message-list">
         </div>
       </div>
       <form class="chatForm" action="index.html" method="post">
         <div class="row">
             <div class="columns eight">
               <textarea class="u-full-width" id="message" name="name"></textarea>
             </div>
             <div class="columns four">
               <input class="button-primary" type="submit" name="name" value="send">
             </div>
          </div>
       </form>
    </div>
  </div>

  </body>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</html>
