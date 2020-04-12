$(window).scroll(function() {
  if ($(this).scrollTop() > 25){  
      $('header').addClass("sticky");
  }
  else{
      $('header').removeClass("sticky");
  }
});