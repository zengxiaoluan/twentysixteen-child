<?php
/**
 * Template Name: Slides
 * Share Of Slides
 * created at 2018-01-24
 */

get_header('slides'); ?>

    <?php
        // 转为<!--more-->
        // add_filter('the_content', 'inject_content_filter', 999);
        // function inject_content_filter($content) {
        //     $content = preg_replace('/<span id\=\"(more\-\d+)"><\/span>/', '<!--more-->', $content);
        //     return $content;
        // }
     ?>

    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

        // Include the page content template.
        get_template_part( 'template-parts/content', 'slides' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

        // End of the loop.
    endwhile;
    ?>

    <link rel="stylesheet" href="https://alvarotrigo.com/fullPage/jquery.fullpage.min.css">
    <script src="https://alvarotrigo.com/fullPage/jquery.fullPage.min.js"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
              $('#fullpage').fullpage({
                sectionsColor: ['#f2f2f2'],
                controlArrows: false,
                anchors: ['slides'],
              })
            })
        })(jQuery)
    </script>

<?php get_footer(); ?>