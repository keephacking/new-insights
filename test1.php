<?php 
require_once 'include/head.php';
/*$user= new user_class();
$user->get_table("users");
$data = array("username"=>"Sachin Vignesh","email"=>"dash@gmail.yyy",);

//$user->store($data);
$user->load(27);
$all_vars=get_object_vars($user);
echo "<pre>";
print_r($all_vars);
echo "</pre>";
echo $user->followers_num;


$tags=array('php','java','cpp','ruby');
echo "<br><pre>";
print_r($tags);
echo "</pre>";

foreach ($tags as $key)
{
	$tags[$key]='python';
}

echo "<br><pre>";
print_r($tags);
echo "</pre>";


$obj=new table('tags',0);
$obj->delete();

$tag="Sachin";
$t="select * from tags where tag='$tag'";
echo $t;



<html>
<style>
html{
margin:0;
height:100%;
width:100%;
}
body{
margin:0;
height:100%;
width:100%;
}
.min-box
{
height:200px;
width:200px;
border:1px solid;
background-color:red;

}
.max-box{
width:100%;
height:100%;
background-color:red;
position:absolute;
float:initial;
}
</style>
<script>
$(document).ready(function(){

$('#btn').on('click', function(){

   $('div').toggleClass('max-box');

});


});
</script>
<head>
</head>
<body>
<div>
<button type="button" id="btn">click me</button>
</div>
<h1>Sachin</h1>
</body>
</html>


<html>
<head>
<style>
body{
margin:0;
height:100%;
width:100%
}
</style>
</head>
<body>

<div id="divContent" style="height: 40px; width: 100%; overflow: hidden; background-color: white;">The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.</div>
<a id="anchorMoreLess" onclick="moreLess('divContent','anchorMoreLess'); return false;" href="#">More</a>
</body>
</html>
<script>
function moreLess(divContentID, aMoreLessID)
{
 //
 // The div whose height is to be minimized or maximized.
 //
 var divCont = document.getElementById(divContentID);
 //
 // The anchor which is used to perform more/less operation (maximize/minimize).
 //
 var aMoreLess = document.getElementById(aMoreLessID);
 
 //
 // Check to see if the content div is hidden.
 //
 if(divCont.style.overflow == 'hidden')
 {
  //
  // As the content div is HIDDEN, So make it visible.
  //
  divCont.style.overflow = 'visible';
  //
  // Remove height as we want to see all the text.
  //
  divCont.style.height =" 100%";
  //
  // Change the text of anchor.
  //
  aMoreLess.innerHTML = 'Less';
 }
 else
 {
  //
  // As the content div is VISIBLE, So make it hidden to clip the text.
  //
  divCont.style.overflow = 'hidden';
  //
  // Again add the height so that we can see only few lines of text, rest of the text will be clipped as we set overflow to hidden.
  //
  divCont.style.height = '40px';
  //
  // Change the text of anchor.
  //
  aMoreLess.innerHTML = 'More';
  }
}
</script>

*/
/***********maximize div**************/
?>

<style>
html,body{
margin:0;
background-color:green;
overflow:hidden;
}
#div-container{
width:400px;
display:flex;
flex-direction:column;
background-color:#ccc;
border:5px solid blue;
flex-wrap:no-wrap;
}
.item{

}
#div-1{
height:auto;
width:100%;
background-color:honeydew;
}
#div-2
{
background-color:red;
width:100%;
flex-grow:1;
}
#div-container.fullscreen{
position:absolute;
height:100vh;
width:100%;
flex-grow:1;
top:0px;
bottom:0px;

}
</style>
<script>
$(document).ready(function(){
$("#bn").click(function(){
  $("#div-container").toggleClass("fullscreen");

  });
	
});
</script>
</head>
<body>

<div id="div-container" class="parent">
  <div id="div-1" class="item"><h1>DIV 1 HERE</h1>
    <button id="bn" type="button">max</button>
  </div>
  <div id="div-2" class="item"><h1>DIV 2 HERE</h1></div>
</div>
<h1>Iam Sachin</h1>
</body>
</html>

