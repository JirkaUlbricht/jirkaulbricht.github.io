$('#navbar a, .btn').on('click', function (event) {
    if (this.hash !== '') {
        event.preventDefault();
        const hash = this.hash;
        $('html, body').animate(
            {
                scrollTop: $(hash).offset().top - 100
            }, 1000
        )
    }
})


var nav_sections = $('section');
var main_nav = $('#navbar li, .mobile-nav');

$(window).on('scroll', function () {

    var cur_pos = $(this).scrollTop() + 200;

    // Menu Opacity on scrolling and hidding source

    if (cur_pos > 350) {
        document.querySelector('#navbar').style.opacity = 0.8;
        document.querySelector('#showcase .source').style.display = "none";
    } else {
        document.querySelector('#navbar').style.opacity = 1;
        document.querySelector('#showcase .source').style.display = "block";
    }}