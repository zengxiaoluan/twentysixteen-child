<?php
/**
 * The template used for displaying slides content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen_child
 * @since Twenty Sixteen Child 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php twentysixteen_post_thumbnail(); ?>
    <?php 
        $slides = preg_split('/<hr.*\/>/', apply_filters('the_content', get_the_content()));
    ?>

        <div id="primary">
            <div class="section">
                <div class="slide">
                    <header class="entry-header text-center">
                        <?php echo get_avatar(1, 128); ?>
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <a href="<?php bloginfo('url'); ?>" target="_blank">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php echo ' | '; the_date(); echo ' | ';?>
                        <?php the_views(); ?>
                    </header>
                </div>

                <?php foreach ($slides as $slide): ?>
                    <div class="slide"><?php echo $slide; ?></div>
                <?php endforeach; ?>

                <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        echo '<div class="slide">';
                            comments_template();
                        echo '</div>';
                    }
                ?>
            </div>
        </div>

</article><!-- #post-## -->

<style>
    .text-center {
        text-align: center;
    }
</style>
