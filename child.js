;'use strict';

(function($){

    /*back to top*/
    $('#top').on('click', function(event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: 0}, 1000);
    });

    /*求职广告*/
    // console.log( '%c Give me a better job?\n %c E-mail: %c me@zengxiaoluan.com', 'font-size:30px;color:#1a1a1a;text-align:center;', 'font-size:12px;color:#1a1a1a;','color:red;' );

    // color box below
    
    $('<div id="color-box" style="position:fixed;top:0;right:0;bottom:0;left:0;display:none;background:#ccc;opacity: 0.5;z-index:101;filter:blur(5px);"></div>').appendTo('body');

    $('body').on('click', '#color-box', function(event) {
        $('#color-box').fadeOut(500);
        $('.color-box-img').hide(500);
    });

    $('article img').each(function(index, el) {
        if( $(el).parent().is('a') )
            return;

        $(el).click(function(event) {
            $(event.target).clone().appendTo('body').css({
                position: 'fixed',
                top: '50%',
                left: '50%',
                right: '0',
                bottom: '0',
                zIndex: '102',
                transform: 'translate(-50%,-50%)',
                maxWidth: '90%',
                maxHeight: '90%',
                width: 'auto',
                height: 'auto',
                display: 'none'
            }).attr('class', 'color-box-img').show(500);
            $('#color-box').fadeIn(500);
        });
    });

})(jQuery)