// back to top
const toTop = document.querySelector('.toTop');
window.onscroll = function() {
    if (window.pageYOffset > 300) {
        toTop.style.display = 'block';
    } else {
        toTop.style.display = 'none';
    }
}

$(document).ready(function() {
// scroll smooth
    $(".smooth").on('click', function(event) {

        if (this.hash !== "") {
            event.preventDefault();

            var hash = this.hash;

            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {

                window.location.hash = hash;
            });
        }
    });
});