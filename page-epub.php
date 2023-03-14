<?php
/**
 * Template Name: epub
 * 
 * created at 2023-03-11
 */

get_header('slides'); ?>


    <?php
        $version = 2;
    ?>


    <link href=<?php echo get_stylesheet_directory_uri() . '/dist-epub/static/css/app.css?'.$version; ?> rel=stylesheet>


    <div id=app></div>

    <script type=text/javascript src=<?php echo get_stylesheet_directory_uri() . '/dist-epub/static/js/manifest.js?'.$version; ?>></script>
    <script type=text/javascript src=<?php echo get_stylesheet_directory_uri() . '/dist-epub/static/js/vendor.js?'.$version; ?>></script>
    <script type=text/javascript src=<?php echo get_stylesheet_directory_uri() . '/dist-epub/static/js/app.js?'.$version; ?>></script>

<style>
    .comment-form textarea {
        background: #f7f7f7;
        background-image: -webkit-linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
        border: 1px solid #d1d1d1;
        border-radius: 2px;
        color: #686868;
        padding: 0.625em 0.4375em;
        width: 100%;
    }
    .site-content {
        padding: 0;
    }
</style>

<?php get_footer('slides'); ?>