$(document).ready(function(){
    //var altura = $('#main_navbar').offset().top;
    var altura = 0;
    $(window).on('scroll', function(){
        if ( $(window).scrollTop() > altura ){
            $('#navbarmenu').addClass('fixed-top');
            $('#navbarmenu').addClass('sombraNavbar');
        } else {
            $('#navbarmenu').removeClass('fixed-top');
            $('#navbarmenu').removeClass('sombraNavbar');
        }
    });
});
