<?php
/**
 * Template Name: RSS
 * 
 * created at 2020-08-09
 */

get_header();?>



<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            // End of the loop.
        endwhile;
        ?>

    <div id="app"></div>
    <script src="<?php echo get_stylesheet_directory_uri() . '/dist/rss.js?'.date('s');?>"></script>




    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<style>
  
</style>

<?php get_footer(); ?>
