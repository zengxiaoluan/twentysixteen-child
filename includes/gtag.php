<?php 
    /**
     * google gtag
     * 2017-09-19
     * me@zengxiaoluan.com
     */
    function gtag(){ ?>

    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106748743-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());

      gtag('config', 'UA-106748743-1');
    </script>

<?php } ?>

<?php 

    add_action( 'wp_head', 'gtag' );

 ?>