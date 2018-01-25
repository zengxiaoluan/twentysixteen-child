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
        $slides = explode('<hr />', apply_filters('the_content', get_the_content()));
    ?>

        <div id="fullpage">
            <div class="section">
                <div class="slide">
                    <header class="entry-header text-center">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <?php echo bloginfo('name') . ' | '; the_date();?>
                    </header>
                </div>
                <?php foreach ($slides as $slide): ?>
                    <div class="slide"><?php echo $slide; ?></div>
                <?php endforeach; ?>
            </div>
        </div>

</article><!-- #post-## -->

<style>
    .text-center {
        text-align: center;
    }
</style>
