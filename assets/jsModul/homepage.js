let baseUrl = "";
$(document).ready(function() {
	//set active class to navbar
	var uriValue = "home";
	$('#li_nav_produk').removeClass('active');
	$('#li_nav_kontak').removeClass('active');
	$('#li_nav_faq').removeClass('active');
	$('#li_nav_login').removeClass('active');
	$('#li_nav_home').addClass('active');
});

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}