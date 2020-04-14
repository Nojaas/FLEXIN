$(window).scroll(function() {
  if ($(this).scrollTop() > 70){  
      $('header').addClass("sticky");
  }
  else{
      $('header').removeClass("sticky");
  }
});