<?php 
    /**
     * google adsense
     * 2020-03-02
     */
    function google_adsense(){ ?>

    <script data-ad-client="ca-pub-1203517256266060" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<?php } 
    if (!is_user_logged_in() && !WP_DEBUG) {
        add_action( 'wp_head', 'google_adsense' );
    }
