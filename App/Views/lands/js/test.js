$(document).ready(function () {

    var dir = 'left';
    var banner = $('.wrapper-' + dir);
    var page = $('div.wrapper-maincontent > div > div.row');
    var offset = banner.offset().top;
    $(window).on('scroll', function () {
        var top = $(this).scrollTop();
        var cor_banner = banner.offset().top + banner.height();
        var cor_page = page.offset().top + page.height();
        if (cor_banner >= cor_page)
        {
            banner.css({
                top: '',
                bottom: '0px'
            });
        } else
        {
            banner.css({
                top: top >= offset ? top - offset : 0,
                bottom: ''
            });
        }
        console.log(cor_banner + 'vs' + cor_page);
        //console.log(cor_banner - banner.height());
    });
});
