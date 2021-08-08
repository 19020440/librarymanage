$(document).ready(function() {
    $(window).click(function(e) {
        let notify = $('.header__navbar-item');
        if(!notify.is(e.target) && notify.has(e.target).length === 0) {
            $('.header__notify').hide();
        } else {
            if($('.header_nofi-link').is(e.target) || $('.header_nofi-link').has(e.target).length > 0) {
                $('.header__notify').toggle();
            } else {
                $('.header__notify').show();  
            }
        }

        let navcart = $('.nav-cart');
        if(!navcart.is(e.target) && navcart.has(e.target).length === 0) {
            $('.nav-cart-list').hide();
        } else {
            if($('.header_cart-link').is(e.target) || $('.header_cart-link').has(e.target).length > 0) {
                $('.nav-cart-list').toggle();
            } else {
                $('.nav-cart-list').show();  
            }
        }
    });
}) 
    
