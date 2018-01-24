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
    <?php $slides = explode('<!--more-->', apply_filters('the_content', get_the_content())); ?>

        <div id="fullpage">
            <div class="section">
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>
            </div>
            <?php foreach ($slides as $slide): ?>
                <div class="section"><?php echo $slide; ?></div>
            <?php endforeach; ?>
        </div>

</article><!-- #post-## -->
