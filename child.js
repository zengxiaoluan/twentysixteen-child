/**
 * author me@zengxiaoluan.com
 * created 2016-11-01
 *
 * updated0 2017-08-12
 * updated1 2017-11-10
 * updated2 2018-10-25 second day in pingan
 */
'use strict';

(function ($) {
  var EventUtil = {
    getClipboardText: function (event) {
      var clipboardData = (event.clipboardData || window.clipboardData)
      return clipboardData.getData('text')
    },
    setClipboardText: function (event, value) {
      if (event.clipboardData) {
        return event.clipboardData.setData('text/plain', value)
      } else if (window.clipboardData) {
        return window.clipboardData.setData('text', value)
      }
    },
    throttle: function (fn, delay, mustRunDelay) {
      var timer = null
      var start
      return function () {
        var context = this
        var args = arguments
        var current = +new Date()
        clearTimeout(timer)
        if (!start) {
          start = current
        }
        if (current - start >= mustRunDelay) {
          fn.apply(context, args)
          start = current
        } else {
          timer = setTimeout(function () {
            fn.apply(context, args)
          }, delay)
        }
      }
    }
  }

  var modules = {
    top: function () {
      /* back to top */
      $('#top').on('click', function (event) {
        event.preventDefault()
        $('html,body').animate({scrollTop: 0}, 500)
      })
    },
    jobWanted: function () {
      /* 求职广告 */
      console.log('%c Give me a better job? %c E-mail: %c me@zengxiaoluan.com', 'background-image:-webkit-gradient( linear, left top,right top, color-stop(0, #00a419),color-stop(0.15, #f44336), color-stop(0.29, #ff4300),color-stop(0.3, #AA00FF),color-stop(0.4, #8BC34A), color-stop(0.45, #607D8B),color-stop(0.6, #4096EE), color-stop(0.75, #D50000),color-stop(0.9, #4096EE), color-stop(1, #FF1A00));color:white;-webkit-background-clip:text;font-size:30px;', 'font-size:12px;color:#1a1a1a;', 'color:red;')

      console.log("%c                            ","background: url(https://zengxiaoluan.com/wp-content/uploads/2016/10/cropped-logo-3.jpg) no-repeat left center;font-size: 128px;");
    },
    copyHandler: function () {
      function addCopyrights (event) {
        var copyStr = window.getSelection().toString();
        var limitSize = 20;
        var enter = '\n\n';
        if (copyStr.length > limitSize) {
          EventUtil.setClipboardText(event, copyStr + enter + 
            '标题：' + $('h1').text() + enter +
            '内容来自曾小乱的blog：' + window.location.href);
          
          event.preventDefault();
        }
      }
      document.addEventListener('copy', addCopyrights, false)
    },
    nprogress: function () {
      window.NProgress.configure({
        trickle: false,
        showSpinner: false,
        minimum: 0,
        trickleSpeed: 1000,
        speed: 1000
      })

      var documentHeight = $(document).height()
      var windowHeight = $(window).height()

      scrollHandler()
      function scrollHandler () {
        var increment = $(window).scrollTop() / (documentHeight - windowHeight)
        increment = increment >= 1 ? 0.9999 : increment
        window.NProgress.set(increment)
      }
      $(window).scroll(EventUtil.throttle(scrollHandler, 100))
    },
    contentMenu: function () {
      var h2 = $('.entry-content h2').not('.author-title')
      
      if (!$('body.single').length || !h2.length || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) return

      // 给 h2 自动加上一个 a 标签
      $.each(h2, function () {
        if (!$(this).find('a').length) {
          var title = $(this).text()
          $(this).append(`<a id="${title}"></a>`);
        }
      });

      var a = h2.find('a')
      var html = '<ul id="anchors-wrap"><li id="total-menu">文章目录</li>'

      a.each(function(index, el) {
        html += '<li><a class="anchors" href="#' + el.id + '">' + $(this).parent('h2').text() + '</a></li>'
      });

      html += '</ul>'

      $('.entry-footer').append(html)

      $('.entry-footer').on('click', '.anchors', function(event) {
        event.preventDefault()
        var hash = $(this).attr('href').slice(1)
        var targetH2 = $('#' + hash).parent('h2')
        $('html, body').animate({
          scrollTop: targetH2.offset().top - targetH2.outerHeight(true)
        });
        history.replaceState({}, null, '#' + hash)
      })
      .end()
      .on('click', '#total-menu', function (event) {
        $('html, body').animate({
          scrollTop: $('h1').offset().top - $('h1').outerHeight(true)
        });
        history.replaceState({}, null, '#' + '');
      });

      var top = $('#anchors-wrap').offset().top

      function contentMenuScroller () {
        var scrollTop = $(window).scrollTop()

        if (top - scrollTop <= 0) {
          $('#anchors-wrap').addClass('anchors-fixed').css('left', $('.entry-footer').offset().left);
        } else {
          $('#anchors-wrap').removeClass('anchors-fixed')
        }
        
        if ($('#comments').offset().top - $(window).height() < scrollTop) {
          $('#anchors-wrap').removeClass('anchors-fixed')
        }
      }

      $(window).scroll(EventUtil.throttle(contentMenuScroller, 500, 100));

    }
  }

  // 执行
  for (var i in modules) {
    modules[i]()
  }
})(window.jQuery)
