<?php
/**
 * Template Name: RSS
 * 
 * created at 2020-08-09
 */

get_header('rss');?>

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

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/dist/rss-vuetify.css?'.date('s');?>">
    <script src="<?php echo get_stylesheet_directory_uri() . '/dist/rss.js?'.date('s');?>"></script>




    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

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
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
