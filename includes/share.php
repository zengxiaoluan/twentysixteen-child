<?php

add_filter( 'the_content', 'share_the_content' );
function share_the_content( $content ) {
    $page_type = basename( get_page_template() );
    // overpass sildes
    if (strpos($page_type, 'slides')) {
        return $content;
    }
    if ( is_single() || is_page() ) {
        $content .= '<h2>我要<a id="share-this"></a>分享</h2><div class="social-share" data-disabled="diandian"></div>';
    }
    return $content;
}

add_action('wp_enqueue_scripts', 'enqueue_share_styles');
function enqueue_share_styles () {
    wp_enqueue_script('share-js', 'https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js', array(), '2019-01-01', true);

    wp_enqueue_style('share-css', 'https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css', array(), '2019-01-01', 'all');
}
