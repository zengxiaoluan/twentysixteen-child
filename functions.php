<?php 
    
    add_action('wp_enqueue_scripts', 'enqueue_styles');

    function enqueue_styles(){
        // load parent styles
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    }

    add_action( 'twentysixteen_credits', 'add_beian_number');

    function add_beian_number(){
        echo "<span class='site-title'><a target='_blank' href='http://www.miibeian.gov.cn/state/outPortal/loginPortal.action'>湘ICP备16005159号-1</a></span>";
    }