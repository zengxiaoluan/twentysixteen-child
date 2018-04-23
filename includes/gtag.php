<?php 
    /**
     * google gtag
     * 2017-09-19
     * me@zengxiaoluan.com
     */
    function gtag(){ ?>

    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106748743-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());

      gtag('config', 'UA-106748743-1');
    </script> -->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-106748743-1', 'auto');
      ga('send', 'pageview');

    </script>

<?php } 

    if (!is_user_logged_in() && !WP_DEBUG) {
        add_action( 'wp_head', 'gtag' );
    }
