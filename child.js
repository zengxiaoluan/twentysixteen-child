;'use strict';

(function($){

    /*back to top*/
    $('#top').on('click', function(event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: 0}, 1000);
    });

    /*求职广告*/
    console.log( '%c Give me a better job?\n %c E-mail: %c me@zengxiaoluan.com', 'font-size:30px;color:#1a1a1a;text-align:center;', 'font-size:12px;color:#1a1a1a;','color:red;' );

})(jQuery)