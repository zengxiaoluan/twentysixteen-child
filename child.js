/**
 * author me@zengxiaoluan.com
 * created 2016-11-01
 * 
 * updated0 2017-08-12
 * updated1 2017-11-10
 */
;'use strict';

(function($){

    var EventUtil = {
        getClipboardText: function( event ){
            var clipboardData = ( event.clipboardData || window.clipboardData );
            return clipboardData.getData( 'text' );
        },
        setClipboardText: function( event, value ){
            if ( event.clipboardData ) {
                return event.clipboardData.setData( 'text/plain', value );
            }else if ( window.clipboardData ) {
                return window.clipboardData.setData( 'text', value );
            }
        },
        throttle: function(fn, delay, mustRunDelay){
            var timer = null;
            var t_start;
            return function(){
                var context = this, args = arguments, t_curr = +new Date();
                clearTimeout(timer);
                if(!t_start){
                    t_start = t_curr;
                }
                if(t_curr - t_start >= mustRunDelay){
                    fn.apply(context, args);
                    t_start = t_curr;
                } else {
                    timer = setTimeout(function(){
                        fn.apply(context, args);
                    }, delay);
                }
            };
        }
    }

    var modules = {
        top: function(){
            /*back to top*/
            $('#top').on('click', function(event) {
                event.preventDefault();
                $('html,body').animate({scrollTop: 0}, 500);
            });
        },
        jobWanted: function(){
            /*求职广告*/
            console.log( '%c Give me a better job?\n %c E-mail: %c me@zengxiaoluan.com', 'background-image:-webkit-gradient( linear, left top,right top, color-stop(0, #00a419),color-stop(0.15, #f44336), color-stop(0.29, #ff4300),color-stop(0.3, #AA00FF),color-stop(0.4, #8BC34A), color-stop(0.45, #607D8B),color-stop(0.6, #4096EE), color-stop(0.75, #D50000),color-stop(0.9, #4096EE), color-stop(1, #FF1A00));color:transparent;-webkit-background-clip:text;font-size:30px;', 'font-size:12px;color:#1a1a1a;','color:red;' );
        },
        colorBox: function(){
            // color box below
            $('<div id="color-box" style="position:fixed;top:0;right:0;bottom:0;left:0;display:none;background:#333;opacity: 0.5;z-index:101;filter:blur(5px);"></div>').appendTo('body');

            $('body').on('click', '#color-box,.color-box-img', function(event) {
                $('#color-box').fadeOut(500);
                $('.color-box-img').remove();
            });

            $('article img').click(function(event) {
                if( $(this).parent().is('a') ){
                    return;
                }
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
                    display: 'none',
                    cursor: 'zoom-out'
                }).attr('class', 'color-box-img').show(500);
                $('#color-box').fadeIn(500);

            });
        },
        copyHandler: function(){
            function addCopyrights( event ){
                EventUtil.setClipboardText( event, window.getSelection().toString() + '\n\n内容来自曾小乱的blog：' + location.href )
                event.preventDefault();
            }
            document.addEventListener( 'copy', addCopyrights, false );
        },
        nprogress: function(){
            NProgress.configure({
                    trickle: false,
                    showSpinner: false,
                    minimum: 0,
                    trickleSpeed: 0,
                    speed: 100
                });
            NProgress.start()

            var documentHeight = $(document).height();
            var windowHeight = $(window).height();

            scrollHandler();
            function scrollHandler(){
                var increment = $(window).scrollTop() / (documentHeight - windowHeight);
                increment = increment >= 1 ? 0.9999 : increment;
                NProgress.set(increment)
            }
            $(window).scroll(EventUtil.throttle(scrollHandler, 100));
        }
    }

    // 执行
    for( var i in modules ){
        modules[i]();
    }

})(jQuery);