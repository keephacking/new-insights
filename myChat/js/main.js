$(function(){
  var conn = new WebSocket('ws://localhost:8080');
  var chatForm = $(".chatForm"),
      messageInputField = chatForm.find("#message"),
      messageList = $(".message-list"),
      usernameForm = $(".username-form"),
      usernameInput = usernameForm.find(".username-input");

  usernameForm.on("submit",function(e){
    e.preventDefault();
    var chatName = usernameInput.val();
    if(chatName.length>0){
      $.cookie("chat_name",chatName);
      $('.username').text(chatName);
    }
  });

  chatForm.on("submit",function(e){
    e.preventDefault();
    var message = {
      text : messageInputField.val(),
      sender : $.cookie("chat_name"),
      type : "message"
    }
    conn.send(JSON.stringify(message));
    messageList.prepend("<li><strong>"+message.sender+" : </strong>"+message.text+"</li>");
  });
  conn.onopen = function(e){
    console.log("Connection Established");

    var chatName = $.cookie("chat_name");
    if(!chatName){
      var timestamp = (new Date()).getTime();
      chatName = "anonymous"+timestamp;
      $.cookie("chat_name",chatName);
    }
    $('.username').text(chatName);
  } ;

  conn.onmessage = function(e){
    var msg = JSON.parse(e.data);
    messageList.prepend("<li><strong >"+msg.sender+" : </strong>"+msg.text+"</li>");
    console.log(e.data);
  };
});
