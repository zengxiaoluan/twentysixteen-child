;'use strict';

(function($){
    $('#top').on('click', function(event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: 0}, 1000);
    });
})(jQuery)