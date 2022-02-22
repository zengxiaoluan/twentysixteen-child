<?php
/**
 * Template Name: Svg2png
 * 
 * created at 2020-06-13
 */

get_header(); ?>

<script src="<?php echo get_stylesheet_directory_uri() . '/dist/svg2png.js';?>"></script>

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
<input style="display:none" type="file" id='svg-file' value="请上传你的 svg 文件">

<div id="drag-svg-file" class="drag-svg-file">Drop svg file or click here</div>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<style>
    .drag-svg-file{
        height: 200px;
        border-width: 3px;
        border-style: dashed;
        border-color: aqua;
        text-align: center;
        line-height: 200px;
        font-size: xxx-large;
        color: aquamarine;
    }
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
