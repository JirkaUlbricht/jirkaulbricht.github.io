$('#welcome a, .arrow').on('click', function (event) {
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

let on = $(window).on('scroll', function () {

    var cur_pos = $(this).scrollTop() + 200;
})
