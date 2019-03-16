$(function () {

    var userAgent = navigator.userAgent;
    var isMobile  = (userAgent.match(/Android/i)
    || userAgent.match(/webOS/i)
    || userAgent.match(/iPhone/i)
    || userAgent.match(/iPad/i)
    || userAgent.match(/iPod/i)
    || userAgent.match(/BlackBerry/i)
    || userAgent.match(/Windows Phone/i));

    var navBar      = $('#headersticky');

    $('body').scroll(function () {
        if (isMobile) {
            return null;
        }

        if (bodyElement.scrollTop > 100) {
            navBar.css('background-color', '#2798c6');
        } else {
            navBar.css('background-color', 'transparent');
        }
    });
});
