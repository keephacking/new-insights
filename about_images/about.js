var postsTop;
var winHeight;

$(document).ready(function(){
    $('.main-nav').hide();
    $(window).scroll(function(){
      var wScroll = $(this).scrollTop();

      if(wScroll > $(".sub-row").offset().top-($(window).height()/1.2) ){
          $(".sub-col").each(function(i){
            setTimeout(function(){
              $(".sub-col").eq(i).addClass('is-showing');
            },150*(i+1));
          });
      }

      if(wScroll >$(".promoScope").offset().top - $(window).height()){
        $(".promoScope").css({"background-position":"center "+(wScroll-$(".promoScope").offset().top)+"px"});
        var opacity= (wScroll - $(".promoScope").offset().top+150 ) / (wScroll/5);

        $(".window-tint").css({"opacity":opacity});
      }

      postsTop = $('.his-container').offset().top;
    	winHeight = $(window).height();
      posts(wScroll);

       var fix=0;
      if(wScroll >= $(".about-author").offset().top){
        var ht=$(".side-scrollable").height();
        fix=wScroll-$(".about-author").offset().top;
         if(fix >= (ht-$(window).height())){
            fix=ht-$(window).height()+1;
         }
        $(".side-fixed").css({"transform":"translate(0,"+fix+"px)"});
      }
      else
       {
         fix=0;
         $(".side-fixed").css({"transform":"translate(0,"+fix+"px)"});
       }

      var  nHht = 175-wScroll;
        nHht=Math.max(50,nHht);
        $("header").css({"height":nHht});
      var nW = 150-wScroll;
      nW=Math.max(50,nW);
        $(".my-photo img").css({"height":nW,"width":nW});

        $(".my-logo img").css({"height":nHht/1.5});

        if(nHht==50){
          $(".head-title h1").css({"font-size":"20px"});
        }
        else $(".head-title h1").css({"font-size":"50px"});
    })

});



function posts(x){
	var goal = postsTop - winHeight / 8;
	var offset;

	if(x < goal){
		offset = Math.min(0.005*Math.pow(x - goal, 2), winHeight);
	}else{
		offset = 0;
	}

	$('.his-1').css({'transform': 'translate('+ -offset +'px, '+ offset * 0.2 +'px)'});

	$('.his-3').css({'transform': 'translate('+ offset +'px, '+ offset * 0.2 +'px)'});
}
